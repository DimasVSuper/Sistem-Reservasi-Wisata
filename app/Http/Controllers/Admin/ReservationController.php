<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Destination;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with('destination');

        // Search by customer name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by destination
        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->input('destination_id'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('reservation_date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('reservation_date', '<=', $request->input('date_to'));
        }

        // Sort by
        $sortBy = $request->input('sort_by', 'reservation_date');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $reservations = $query->paginate(10)->appends($request->query());
        $destinations = Destination::all();
        
        return view('admin.reservations.index', compact('reservations', 'destinations'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.reservations.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|max:20',
            'destination_id' => 'required|exists:destinations,id',
            'reservation_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $reservation = Reservation::create($validated);

        // Log initial status
        StatusHistory::create([
            'reservation_id' => $reservation->id,
            'old_status' => null,
            'new_status' => $validated['status'],
            'changed_by' => Auth::user()->email,
            'notes' => 'Reservasi dibuat',
        ]);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil ditambahkan!');
    }

    public function show(Reservation $reservation)
    {
        $statusHistories = $reservation->statusHistories;
        return view('admin.reservations.show', compact('reservation', 'statusHistories'));
    }

    public function edit(Reservation $reservation)
    {
        $destinations = Destination::all();
        return view('admin.reservations.edit', compact('reservation', 'destinations'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|max:20',
            'destination_id' => 'required|exists:destinations,id',
            'reservation_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $reservation->status;
        $reservation->update($validated);

        // Log status change
        if ($oldStatus !== $validated['status']) {
            StatusHistory::create([
                'reservation_id' => $reservation->id,
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
                'changed_by' => Auth::user()->email,
                'notes' => $validated['notes'] ?? null,
            ]);
        }

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil diperbarui!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil dihapus!');
    }

    /**
     * Change status dengan reason
     */
    public function changeStatus(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'reason' => 'nullable|string',
        ]);

        $oldStatus = $reservation->status;
        $reservation->status = $validated['status'];
        $reservation->save();

        // Log status change
        StatusHistory::create([
            'reservation_id' => $reservation->id,
            'old_status' => $oldStatus,
            'new_status' => $validated['status'],
            'reason' => $validated['reason'] ?? null,
            'changed_by' => Auth::user()->email,
        ]);

        return back()->with('success', 'Status berhasil diubah menjadi ' . strtoupper($validated['status']));
    }

    /**
     * Bulk status update
     */
    public function bulkStatusUpdate(Request $request)
    {
        $validated = $request->validate([
            'reservation_ids' => 'required|array',
            'reservation_ids.*' => 'integer|exists:reservations,id',
            'status' => 'required|in:pending,confirmed,cancelled',
            'reason' => 'nullable|string',
        ]);

        $changedBy = Auth::user()->email;
        $count = 0;

        foreach ($validated['reservation_ids'] as $id) {
            $reservation = Reservation::find($id);
            $oldStatus = $reservation->status;

            if ($oldStatus !== $validated['status']) {
                $reservation->status = $validated['status'];
                $reservation->save();

                StatusHistory::create([
                    'reservation_id' => $id,
                    'old_status' => $oldStatus,
                    'new_status' => $validated['status'],
                    'reason' => $validated['reason'] ?? null,
                    'changed_by' => $changedBy,
                ]);

                $count++;
            }
        }

        return redirect()->route('admin.reservations.index')
            ->with('success', "Status $count reservasi berhasil diubah!");
    }

    /**
     * View status history
     */
    public function statusHistory(Reservation $reservation)
    {
        $histories = $reservation->statusHistories;
        return view('admin.reservations.status-history', compact('reservation', 'histories'));
    }
}
