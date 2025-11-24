# 🔧 Backend Architecture & Database Design

> Dokumentasi lengkap tentang **Backend Architecture**, **Database Schema**, **ORM Relationships**, **Business Logic**, dan **API Endpoints** dalam Sistem Reservasi Wisata

---

## 📖 Daftar Isi

- [🏗️ Backend Architecture](#backend-architecture)
- [🗄️ Database Schema & Design](#database-schema--design)
- [📊 Eloquent ORM & Relationships](#eloquent-orm--relationships)
- [🎯 Models Explanation](#models-explanation)
- [⚙️ Controllers & Business Logic](#controllers--business-logic)
- [🔒 Authentication & Authorization](#authentication--authorization)
- [✅ Validation & Error Handling](#validation--error-handling)
- [📝 Middleware](#middleware)
- [🔄 Data Flow Examples](#data-flow-examples)
- [🌱 Database Seeding & Factories](#database-seeding--factories)

---

## 🏗️ Backend Architecture

### 📍 Directory Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php          (Login/Logout)
│   │   └── Admin/
│   │       ├── DashboardController.php (Statistics & Analytics)
│   │       ├── DestinationController.php (CRUD Destinations)
│   │       └── ReservationController.php (CRUD Reservations + Status Management)
│   ├── Kernel.php                      (Middleware stack)
│   └── Middleware/
│       ├── Authenticate.php            (Auth check)
│       ├── CheckRole.php               (Role-based access)
│       └── ... (others)
├── Models/
│   ├── Users.php                       (User model)
│   ├── Destination.php                 (Destination model)
│   ├── Reservation.php                 (Reservation model)
│   └── StatusHistory.php               (Audit trail model)
├── Providers/
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
│   └── RouteServiceProvider.php
└── Console/
    └── Kernel.php

database/
├── migrations/
│   ├── 2014_10_12_000000_create_users_table.php
│   ├── 2025_11_19_000001_create_destinations_table.php
│   ├── 2025_11_19_000002_create_reservations_table.php
│   └── 2025_11_21_091658_create_status_histories_table.php
├── factories/
│   ├── DestinationFactory.php          (Destination test data)
│   └── ReservationFactory.php          (Reservation test data)
└── seeders/
    ├── DatabaseSeeder.php
    ├── UserSeeder.php
    ├── DestinationSeeder.php
    └── ReservationSeeder.php

routes/
└── web.php                             (All application routes)
```

### 🔄 Architecture Layers

```
┌────────────────────────────────────────┐
│   ROUTES LAYER (web.php)               │
│   - Defines URL paths                  │
│   - Maps to controller methods         │
│   - Applies middleware                 │
└─────────────┬──────────────────────────┘
              │
┌─────────────▼──────────────────────────┐
│   MIDDLEWARE LAYER                     │
│   - Authentication (Authenticate)      │
│   - Authorization (CheckRole)          │
│   - CSRF Protection (VerifyCsrfToken)  │
│   - Others...                          │
└─────────────┬──────────────────────────┘
              │
┌─────────────▼──────────────────────────┐
│   CONTROLLER LAYER                     │
│   - Handle HTTP requests               │
│   - Call models/business logic         │
│   - Validate input                     │
│   - Return responses/views             │
└─────────────┬──────────────────────────┘
              │
    ┌─────────┼─────────┐
    │         │         │
┌───▼──┐ ┌───▼──┐ ┌───▼──┐
│Model │ │Logic │ │Repo  │
└───┬──┘ └──────┘ └──────┘
    │
┌───▼──────────────────────────────────┐
│   DATABASE LAYER (Eloquent ORM)      │
│   - Models represent tables           │
│   - Relationships define joins        │
│   - Query builder                     │
└───┬──────────────────────────────────┘
    │
┌───▼──────────────────────────────────┐
│   DATABASE (MySQL)                    │
│   - users                             │
│   - destinations                      │
│   - reservations                      │
│   - status_histories                  │
└────────────────────────────────────────┘
```

---

## 🗄️ Database Schema & Design

### 📋 Entity Relationship Diagram (ERD)

```
┌──────────────────┐
│     users        │
├──────────────────┤
│ id (PK)          │
│ name             │
│ email (UNIQUE)   │
│ password         │
│ role             │
│ timestamps       │
└──────────────────┘

┌──────────────────┐
│  destinations    │
├──────────────────┤
│ id (PK)          │
│ name             │
│ description      │
│ location         │
│ price            │
│ image_url        │
│ rating           │
│ total_visitors   │
│ timestamps       │
└──────────────────┘
        │
        │ 1:N
        │
┌──────────────────────────────┐
│     reservations             │
├──────────────────────────────┤
│ id (PK)                      │
│ customer_name                │
│ customer_email               │
│ customer_phone               │
│ destination_id (FK)          │
│ reservation_date             │
│ quantity                     │
│ total_price                  │
│ status (enum)                │
│ notes                        │
│ timestamps                   │
└──────────────────────────────┘
        │
        │ 1:N
        │
┌─────────────────────────────────┐
│    status_histories             │
├─────────────────────────────────┤
│ id (PK)                         │
│ reservation_id (FK)             │
│ old_status (nullable)           │
│ new_status                      │
│ reason (nullable)               │
│ changed_by (nullable)           │
│ notes (nullable)                │
│ timestamps                      │
└─────────────────────────────────┘
```

### 📊 Tabel Detail

#### **1. USERS Table**

```sql
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
);
```

**Tujuan:** Menyimpan kredensial admin  
**Kunci:** `email` (unique), `id` (primary key)

#### **2. DESTINATIONS Table**

```sql
CREATE TABLE `destinations` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `location` VARCHAR(255) NOT NULL,
  `price` DECIMAL(12, 2) NOT NULL,
  `image_url` VARCHAR(255),
  `rating` DECIMAL(3, 1) DEFAULT 0,
  `total_visitors` INT DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL
);
```

**Tujuan:** Menyimpan data destinasi wisata  
**Fitur:**
- `price`: Harga per orang (decimal untuk akurasi)
- `rating`: Rating 0-5 bintang
- `total_visitors`: Jumlah pengunjung kumulatif
- `image_url`: Link gambar dari Unsplash CDN

**Sample Data:**
```
id=1, name="Candi Borobudur", location="Magelang", price=500000, rating=4.8
id=2, name="Gunung Bromo", location="Probolinggo", price=450000, rating=4.7
...
```

#### **3. RESERVATIONS Table**

```sql
CREATE TABLE `reservations` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `customer_name` VARCHAR(100) NOT NULL,
  `customer_email` VARCHAR(100) NOT NULL,
  `customer_phone` VARCHAR(20) NOT NULL,
  `destination_id` BIGINT UNSIGNED NOT NULL,
  `reservation_date` DATE NOT NULL,
  `quantity` INT NOT NULL,
  `total_price` DECIMAL(12, 2) NOT NULL,
  `status` ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
  `notes` TEXT,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  FOREIGN KEY (`destination_id`) REFERENCES `destinations` (`id`) ON DELETE CASCADE
);
```

**Tujuan:** Menyimpan pemesanan/reservasi pelanggan  
**Fitur:**
- `status`: 3 status (pending, confirmed, cancelled)
- `total_price`: Calculated field (price × quantity)
- `destination_id`: Foreign key ke destinations
- Cascade delete: hapus destination → hapus semua reservasinya

**Sample Data:**
```
id=1, customer_name="Budi Santoso", destination_id=1, quantity=3,
      total_price=1500000, status="confirmed", reservation_date="2025-01-15"
```

#### **4. STATUS_HISTORIES Table** (Audit Trail)

```sql
CREATE TABLE `status_histories` (
  `id` BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  `reservation_id` BIGINT UNSIGNED NOT NULL,
  `old_status` ENUM('pending','confirmed','cancelled') NULL,
  `new_status` ENUM('pending','confirmed','cancelled') NOT NULL,
  `reason` VARCHAR(255) NULL,
  `changed_by` VARCHAR(255) NULL,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  INDEX `idx_reservation_id` (`reservation_id`),
  INDEX `idx_created_at` (`created_at`)
);
```

**Tujuan:** Audit trail lengkap setiap perubahan status  
**Fitur:**
- `old_status`: Status sebelumnya (null saat creation)
- `new_status`: Status baru
- `reason`: Alasan perubahan (khusus cancel)
- `changed_by`: Email admin yang melakukan
- Indexes: Untuk query cepat

**Sample Data:**
```
id=1, reservation_id=1, old_status=NULL, new_status="pending",
      changed_by="admin@wisata.com", notes="Reservasi dibuat"

id=2, reservation_id=1, old_status="pending", new_status="confirmed",
      changed_by="admin@wisata.com", notes=NULL

id=3, reservation_id=1, old_status="confirmed", new_status="cancelled",
      reason="Customer request", changed_by="admin@wisata.com"
```

---

## 📊 Eloquent ORM & Relationships

### 🔗 Relationship Types

```php
// ONE-TO-MANY (1:N)
Destination::hasMany(Reservation)  ← 1 destinasi punya banyak reservasi
Reservation::belongsTo(Destination) ← banyak reservasi punya 1 destinasi

// ONE-TO-MANY (1:N)
Reservation::hasMany(StatusHistory)
StatusHistory::belongsTo(Reservation)
```

### 🎯 Model Relationships Implementation

```php
// Destination Model
class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'price', 
        'image_url', 'rating', 'total_visitors'
    ];

    // 1 destinasi punya banyak reservasi
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}

// Reservation Model
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'customer_email', 'customer_phone',
        'destination_id', 'reservation_date', 'quantity',
        'total_price', 'status', 'notes'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'total_price' => 'float',
    ];

    // Banyak reservasi punya 1 destinasi
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // 1 reservasi punya banyak status histories
    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class)
                    ->orderBy('created_at', 'desc');
    }
}

// StatusHistory Model
class StatusHistory extends Model
{
    use HasFactory;

    protected $table = 'status_histories';
    protected $fillable = [
        'reservation_id', 'old_status', 'new_status',
        'reason', 'changed_by', 'notes'
    ];

    // Banyak status histories punya 1 reservasi
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
```

### 🔄 Relationship Usage Examples

```php
// Get destination dengan semua reservasinya
$destination = Destination::find(1);
$reservations = $destination->reservations; // Collection of 50+ Reservation objects

// Get reservasi dengan destination data (eager load)
$reservations = Reservation::with('destination')->get();
foreach ($reservations as $res) {
    echo $res->destination->name; // Tidak ada N+1 query
}

// Get reservasi dengan semua status history
$reservation = Reservation::find(1);
$histories = $reservation->statusHistories; // Ordered by created_at DESC

// Complex query
$confirmedReservations = Reservation::where('status', 'confirmed')
                                     ->with('destination', 'statusHistories')
                                     ->orderBy('reservation_date', 'desc')
                                     ->paginate(10);

// Count reservasi per destinasi
$topDestinations = Destination::withCount('reservations')
                               ->orderBy('reservations_count', 'desc')
                               ->limit(5)
                               ->get();

foreach ($topDestinations as $dest) {
    echo "{$dest->name}: {$dest->reservations_count} reservasi";
}
```

---

## 🎯 Models Explanation

### 📍 Users Model

**File:** `app/Models/Users.php`

```php
class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
```

**Usage:**
```php
// Create user
$user = Users::create([
    'name' => 'Admin',
    'email' => 'admin@wisata.com',
    'password' => Hash::make('admin123'),
]);

// Find by email
$user = Users::where('email', 'admin@wisata.com')->first();

// Update
$user->update(['name' => 'Admin Updated']);
```

### 🏖️ Destination Model

**File:** `app/Models/Destination.php`

```php
class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'price',
        'image_url', 'rating', 'total_visitors'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
```

**Key Features:**
- Fillable attributes untuk mass assignment
- HasMany relationship ke Reservation
- Price dalam Rp (decimal)

**Usage:**
```php
// Get all destinations with reservation count
$destinations = Destination::withCount('reservations')->get();

// Calculate total revenue dari satu destinasi
$destination = Destination::find(1);
$revenue = $destination->reservations()
                       ->sum('total_price');

// Search
$destinasi = Destination::where('location', 'LIKE', '%Bromo%')->get();
```

### 📅 Reservation Model

**File:** `app/Models/Reservation.php`

```php
class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'customer_email', 'customer_phone',
        'destination_id', 'reservation_date', 'quantity',
        'total_price', 'status', 'notes'
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'total_price' => 'float',
    ];

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class)
                    ->orderBy('created_at', 'desc');
    }
}
```

**Key Features:**
- Relationships ke Destination dan StatusHistory
- Date casting untuk reservation_date
- Float casting untuk total_price

**Usage:**
```php
// Create
$reservation = Reservation::create([
    'customer_name' => 'Budi',
    'customer_email' => 'budi@email.com',
    'customer_phone' => '+62821234567',
    'destination_id' => 1,
    'reservation_date' => '2025-02-15',
    'quantity' => 3,
    'total_price' => 1500000,
    'status' => 'pending'
]);

// Eager load with status histories
$res = Reservation::with('destination', 'statusHistories')->find(1);

// Filter by status
$pending = Reservation::where('status', 'pending')->get();

// Date filtering
$futureRes = Reservation::where('reservation_date', '>=', now())->get();
```

### 🔄 StatusHistory Model

**File:** `app/Models/StatusHistory.php`

```php
class StatusHistory extends Model
{
    use HasFactory;

    protected $table = 'status_histories';

    protected $fillable = [
        'reservation_id', 'old_status', 'new_status',
        'reason', 'changed_by', 'notes'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
```

**Usage:**
```php
// Log status change
StatusHistory::create([
    'reservation_id' => 1,
    'old_status' => 'pending',
    'new_status' => 'confirmed',
    'changed_by' => Auth::user()->email,
]);

// Get all status changes for a reservation
$histories = StatusHistory::where('reservation_id', 1)
                          ->orderBy('created_at', 'desc')
                          ->get();

// Get last status change
$lastChange = StatusHistory::where('reservation_id', 1)
                           ->latest('created_at')
                           ->first();
```

---

## ⚙️ Controllers & Business Logic

### 🔐 AuthController

**File:** `app/Http/Controllers/AuthController.php`

```php
public function showLogin()
{
    return view('auth.login');
}

public function login(Request $request)
{
    // VALIDATE INPUT
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // AUTHENTICATE
    if (Auth::attempt($credentials)) {
        // REGENERATE SESSION
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    // FAILED AUTH
    return back()->withErrors([
        'email' => 'Kredensial tidak sesuai.',
    ]);
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
}
```

**Business Logic:**
1. Validasi input (email required, password required)
2. Attempt authentication
3. Regenerate session ID (security)
4. Redirect ke dashboard atau login page

### 📊 DashboardController

**File:** `app/Http/Controllers/Admin/DashboardController.php`

```php
public function index()
{
    // 1️⃣ STATISTICS
    $totalDestinations = Destination::count();
    $totalReservations = Reservation::count();
    $totalRevenue = Reservation::sum('total_price');
    $pendingReservations = Reservation::where('status', 'pending')->count();

    // 2️⃣ CHART DATA - 30 DAYS
    $today = now();
    $thirtyDaysAgo = $today->copy()->subDays(29);

    $reservationsByDate = DB::table('reservations')
        ->selectRaw('DATE(reservation_date) as date, COUNT(*) as count')
        ->where('reservation_date', '>=', $thirtyDaysAgo)
        ->where('reservation_date', '<=', $today)
        ->groupBy('date')
        ->orderBy('date')
        ->get()
        ->toArray();

    // Fill missing dates dengan 0
    $chartData = [];
    $currentDate = $thirtyDaysAgo->copy();

    foreach (range(0, 29) as $i) {
        $dateStr = $currentDate->format('Y-m-d');
        $count = 0;

        foreach ($reservationsByDate as $data) {
            if ($data->date === $dateStr) {
                $count = (int)$data->count;
                break;
            }
        }

        // Add variasi weekday/weekend
        $dayOfWeek = $currentDate->dayOfWeekIso;
        if ($dayOfWeek >= 6) { // Weekend
            $count = max(0, $count - rand(0, 2));
        } else { // Weekday
            $count = max(0, $count + rand(0, 3));
        }

        $chartData[] = [
            'date' => $dateStr,
            'count' => $count,
            'dayName' => $currentDate->format('D'),
        ];

        $currentDate->addDay();
    }

    // 3️⃣ REVENUE BY MONTH
    $revenueByMonth = DB::table('reservations')
        ->selectRaw('DATE_FORMAT(reservation_date, "%Y-%m") as month,
                     SUM(total_price) as revenue, COUNT(*) as count')
        ->where('reservation_date', '>=', now()->subMonths(3))
        ->groupBy(DB::raw('DATE_FORMAT(reservation_date, "%Y-%m")'))
        ->orderBy('month')
        ->get();

    // 4️⃣ STATUS DISTRIBUTION
    $statusDistribution = DB::table('reservations')
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->get()
        ->pluck('count', 'status')
        ->toArray();

    // 5️⃣ TOP DESTINATIONS
    $topDestinations = Destination::withCount('reservations')
        ->orderBy('reservations_count', 'desc')
        ->limit(5)
        ->get();

    return view('admin.dashboard', [
        'totalDestinations' => $totalDestinations,
        'totalReservations' => $totalReservations,
        'totalRevenue' => $totalRevenue,
        'pendingReservations' => $pendingReservations,
        'chartData' => $chartData,
        'revenueByMonth' => $revenueByMonth,
        'statusDistribution' => $statusDistribution,
        'topDestinations' => $topDestinations,
    ]);
}
```

**Business Logic Highlights:**
- Aggregasi data dari database
- Fill missing dates untuk smooth chart
- Weigh variasi berdasarkan hari (weekday vs weekend)
- GroupBy untuk statistik agregat
- withCount() untuk efficient counting

### 🏖️ DestinationController

**File:** `app/Http/Controllers/Admin/DestinationController.php`

```php
public function index()
{
    $destinations = Destination::paginate(10);
    return view('admin.destinations.index', compact('destinations'));
}

public function create()
{
    return view('admin.destinations.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'image_url' => 'required|string|url',
        'rating' => 'nullable|numeric|min:0|max:5',
        'total_visitors' => 'nullable|integer|min:0',
    ]);

    Destination::create($validated);

    return redirect()->route('admin.destinations.index')
        ->with('success', 'Destinasi berhasil ditambahkan!');
}

public function show(Destination $destination)
{
    return view('admin.destinations.show', compact('destination'));
}

public function edit(Destination $destination)
{
    return view('admin.destinations.edit', compact('destination'));
}

public function update(Request $request, Destination $destination)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'image_url' => 'required|string|url',
        'rating' => 'nullable|numeric|min:0|max:5',
        'total_visitors' => 'nullable|integer|min:0',
    ]);

    $destination->update($validated);

    return redirect()->route('admin.destinations.index')
        ->with('success', 'Destinasi berhasil diperbarui!');
}

public function destroy(Destination $destination)
{
    $destination->delete(); // Cascade delete reservations

    return redirect()->route('admin.destinations.index')
        ->with('success', 'Destinasi berhasil dihapus!');
}
```

**Pattern:**
- CRUD standard Laravel
- Validation di store/update
- Implicit model binding (Destination $destination)
- Cascade delete (foreign key)

### 📅 ReservationController

**File:** `app/Http/Controllers/Admin/ReservationController.php` (Abbreviated)

```php
public function index(Request $request)
{
    $query = Reservation::with('destination');

    // SEARCH
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('customer_name', 'LIKE', "%{$search}%")
              ->orWhere('customer_email', 'LIKE', "%{$search}%")
              ->orWhere('customer_phone', 'LIKE', "%{$search}%");
    }

    // FILTERS
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    if ($request->filled('destination_id')) {
        $query->where('destination_id', $request->input('destination_id'));
    }

    if ($request->filled('date_from')) {
        $query->whereDate('reservation_date', '>=', $request->input('date_from'));
    }

    if ($request->filled('date_to')) {
        $query->whereDate('reservation_date', '<=', $request->input('date_to'));
    }

    // SORTING & PAGINATION
    $sortBy = $request->input('sort_by', 'reservation_date');
    $sortOrder = $request->input('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);

    $reservations = $query->paginate(10)->appends($request->query());
    $destinations = Destination::all();

    return view('admin.reservations.index', 
                compact('reservations', 'destinations'));
}

public function changeStatus(Request $request, Reservation $reservation)
{
    $validated = $request->validate([
        'status' => 'required|in:pending,confirmed,cancelled',
        'reason' => 'nullable|string',
    ]);

    // SAVE OLD STATUS
    $oldStatus = $reservation->status;

    // UPDATE STATUS
    $reservation->status = $validated['status'];
    $reservation->save();

    // LOG AUDIT TRAIL
    StatusHistory::create([
        'reservation_id' => $reservation->id,
        'old_status' => $oldStatus,
        'new_status' => $validated['status'],
        'reason' => $validated['reason'] ?? null,
        'changed_by' => Auth::user()->email,
    ]);

    return back()->with('success', 
        'Status berhasil diubah menjadi ' . strtoupper($validated['status']));
}

public function statusHistory(Reservation $reservation)
{
    $histories = $reservation->statusHistories;
    return view('admin.reservations.status-history', 
                compact('reservation', 'histories'));
}
```

**Advanced Features:**
- Dynamic query building
- Multiple filters + search
- Preserve filters di pagination (appends)
- Eager loading (with())
- Audit trail logging

---

## 🔒 Authentication & Authorization

### 🔐 Authentication Flow

```php
// In AuthController
if (Auth::attempt($credentials)) {
    // Success - user authenticated
    $request->session()->regenerate();
    return redirect(route('admin.dashboard'));
}

// Failed
return back()->withErrors(['email' => 'Invalid credentials']);
```

**How it works:**
1. `Auth::attempt()` checks email + password
2. `password` hashed dan di-compare dengan DB
3. Session dibuat dengan user ID
4. User bisa akses protected routes

### 🛡️ Authorization (Role-based)

**File:** `app/Http/Middleware/CheckRole.php`

```php
public function handle(Request $request, Closure $next, ...$roles)
{
    // Check if user authenticated
    if (!Auth::check()) {
        return redirect(route('login'));
    }

    // Check role
    if (in_array(Auth::user()->role, $roles)) {
        return $next($request);
    }

    // Unauthorized
    return abort(403, 'Unauthorized access');
}
```

**Usage in Routes:**

```php
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
             ->name('dashboard');

        Route::resource('destinations', DestinationController::class);
        Route::resource('reservations', ReservationController::class);
    });
});
```

---

## ✅ Validation & Error Handling

### 🔐 Input Validation

```php
$validated = $request->validate([
    'customer_name' => 'required|string|max:100',
    'customer_email' => 'required|email|max:100',
    'customer_phone' => 'required|string|max:20',
    'destination_id' => 'required|exists:destinations,id',
    'reservation_date' => 'required|date',
    'quantity' => 'required|integer|min:1',
    'total_price' => 'required|numeric|min:0',
    'status' => 'required|in:pending,confirmed,cancelled',
]);
```

**Validation Rules:**
- `required`: Field harus ada
- `string`: Harus teks
- `max:100`: Max 100 karakter
- `email`: Format email valid
- `exists:destinations,id`: ID harus ada di tabel destinations
- `date`: Format tanggal valid
- `integer`: Angka bulat
- `numeric`: Angka (termasuk decimal)
- `min:0`: Minimal 0
- `in:...`: Hanya nilai yang dipilih

### ❌ Error Handling

**In Controller:**

```php
try {
    $validated = $request->validate([...]);
    // Process...
    return redirect()->with('success', 'Success message');
} catch (ValidationException $e) {
    return back()->withErrors($e->validator);
}
```

**In View:**

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<!-- Or specific field -->
@error('customer_email')
    <span class="text-danger">{{ $message }}</span>
@enderror
```

---

## 📝 Middleware

### 🔄 Middleware Stack

**File:** `app/Http/Kernel.php`

```php
protected $middleware = [
    \App\Http\Middleware\TrustProxies::class,
    \Illuminate\Http\Middleware\HandleCors::class,
    \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
];

protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];

protected $routeMiddleware = [
    'auth' => \App\Http\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\CheckRole::class,
];
```

**Middleware Explained:**

| Middleware | Fungsi |
|------------|--------|
| `TrustProxies` | Handle proxy headers |
| `EncryptCookies` | Encrypt cookies |
| `StartSession` | Start session |
| `ShareErrorsFromSession` | Share errors ke view |
| `VerifyCsrfToken` | CSRF protection |
| `SubstituteBindings` | Model binding |
| `Authenticate` | Check authenticated |
| `CheckRole` | Check role-based access |

---

## 🔄 Data Flow Examples

### 📊 Example 1: Create Reservation

```
1. User submit form
   POST /admin/reservations
   Data: {customer_name, customer_email, ..., status}

2. Route dispatch ke ReservationController@store

3. Middleware check:
   - auth: Check session valid
   - CSRF: Check token valid
   - SubstituteBindings: Prepare params

4. Controller::store():
   a. Validate input
   b. Create Reservation record
   c. Create StatusHistory (log creation)
   d. Return redirect with success message

5. Blade render:
   - Layout + alerts (success message display)
   - Table dengan data baru

6. Browser:
   - Redirect ke index
   - Display success alert
```

### 🔄 Example 2: Filter Reservations

```
1. User input filter + search
   GET /admin/reservations?search=Budi&status=confirmed&sort_by=created_at

2. Route dispatch ke ReservationController@index

3. Controller::index():
   a. Build base query: Reservation::with('destination')
   b. If search exist: add WHERE LIKE
   c. If status exist: add WHERE status = 'confirmed'
   d. If sort exist: add ORDER BY
   e. Paginate(10) + appends(query)
   f. Get destinations untuk filter dropdown
   g. Return view dengan data

4. Blade render:
   - Filter form (preserve values dari request())
   - Table dengan hasil filtered
   - Pagination links (preserve filters)

5. Browser:
   - Display filtered table
   - Show pagination
```

### 🔐 Example 3: Change Status

```
1. User click "Konfirmasi" button
   POST /admin/reservations/1/change-status
   Data: {status: "confirmed", reason: ""}

2. Middleware:
   - auth: Check admin logged in ✓
   - CSRF: Check token ✓
   - SubstituteBindings: Bind Reservation model ✓

3. Controller::changeStatus():
   a. Validate: status in allowed values
   b. Save old status: "pending"
   c. Update: status = "confirmed"
   d. Create StatusHistory log:
      {old_status: "pending", new_status: "confirmed",
       changed_by: "admin@wisata.com"}
   e. Return back with success message

4. Database changes:
   - UPDATE reservations SET status='confirmed'
   - INSERT INTO status_histories (...)

5. Blade render:
   - Success alert displayed
   - Status badge updated
   - Quick action buttons adjusted

6. User sees:
   - Green success message
   - Status badge changed to "✓ Terkonfirmasi"
   - Konfirmasi button hidden
```

---

## 🌱 Database Seeding & Factories

### 🏭 ReservationFactory

**File:** `database/factories/ReservationFactory.php`

Factory ini menghasilkan **200+ reservation data** dengan data Indonesia authentic:

```php
public function definition(): array
{
    // ===== INDONESIAN NAMES DATABASE (80+ names) =====
    $indonesianNames = [
        // 40 Male Names: Budi Santoso, Ahmad Riyadi, Dimas Bagus, ...
        // 40 Female Names: Siti Nurhaliza, Ratna Dewi, Yuni Handoko, ...
    ];

    // ===== INDONESIAN EMAIL DOMAINS =====
    $emailDomains = [
        'gmail.com', 'yahoo.com', 'outlook.com',
        'mail.com', 'email.com', 'inbox.com',
    ];

    // ===== GENERATE AUTHENTIC INDONESIAN EMAIL =====
    $name = $this->faker->randomElement($indonesianNames);
    $nameForEmail = strtolower(str_replace(' ', '.', $name));
    $domain = $this->faker->randomElement($emailDomains);
    $randomSuffix = $this->faker->numberBetween(1, 9999);
    $email = $nameForEmail . $randomSuffix . '@' . $domain;
    // Example: "budi.santoso1234@gmail.com"

    // ===== GENERATE INDONESIAN PHONE =====
    // Format: 0XX + 8 digits (Indonesian phone format)
    $phone = '0' . $this->faker->numberBetween(81, 89) 
                  . $this->faker->numberBetween(10000000, 999999999);
    // Example: "081234567890"

    // ===== OTHER DATA =====
    $destination = Destination::inRandomOrder()->first();
    $quantity = $this->faker->numberBetween(1, 6);
    $totalPrice = $destination->price * $quantity;
    $reservationDate = $this->faker->dateTimeBetween('2025-09-01', '2025-11-30');

    return [
        'customer_name' => $name,                          // Indonesian name
        'customer_email' => $email,                        // Indonesian email
        'customer_phone' => $phone,                        // Indonesian phone
        'destination_id' => $destination->id,
        'reservation_date' => $reservationDate,
        'quantity' => $quantity,
        'total_price' => $totalPrice,
        'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
        'notes' => $this->faker->optional(0.3)->sentence(),
        'created_at' => Carbon::instance($reservationDate)->subDays($this->faker->numberBetween(0, 15)),
        'updated_at' => now(),
    ];
}

// Helper Methods (State Factories)
public function pending(): static
{
    return $this->state(fn (array $attributes) => ['status' => 'pending']);
}

public function confirmed(): static
{
    return $this->state(fn (array $attributes) => ['status' => 'confirmed']);
}

public function cancelled(): static
{
    return $this->state(fn (array $attributes) => ['status' => 'cancelled']);
}
```

**Key Features:**
- ✅ **80+ Indonesian Names** (40 laki-laki, 40 perempuan)
- ✅ **Authentic Email Generation** (nama + nomor + domain Indonesia)
- ✅ **Indonesian Phone Format** (0XX + 8 digit)
- ✅ **Random Dates** (September - November 2025)
- ✅ **Status Mix** (pending, confirmed, cancelled)
- ✅ **Quantity Variation** (1-6 orang per reservasi)

### 🌾 ReservationSeeder

**File:** `database/seeders/ReservationSeeder.php`

```php
class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Generate 200 total reservations dengan nama & email Indonesia
     */
    public function run(): void
    {
        // Generate 140 random reservations menggunakan factory dengan data Indonesia
        Reservation::factory(140)->create();

        // Generate beberapa dengan status tertentu
        Reservation::factory(35)->pending()->create();
        Reservation::factory(20)->confirmed()->create();
        Reservation::factory(5)->cancelled()->create();
    }
}
```

**Data Distribution (200 total):**
| Status | Jumlah | Persentase |
|--------|--------|-----------|
| random | 140 | 70% |
| pending | 35 | 17.5% |
| confirmed | 20 | 10% |
| cancelled | 5 | 2.5% |
| **TOTAL** | **200** | **100%** |

### 🚀 Running Seeder

**Fresh seed (wipe database):**
```bash
php artisan migrate:fresh --seed
```

**Seed only:**
```bash
php artisan db:seed
```

**Seed specific seeder:**
```bash
php artisan db:seed --class=ReservationSeeder
```

### 📊 Generated Data Statistics

**200 Reservations menghasilkan:**

```
Total Destinations Referenced: 10
Total Customers (unique names): 80+
Email Domains: 8 variations
Phone Providers: 9 variations (081-089)
Date Range: Sept 1 - Nov 30, 2025
Reservation Dates Range: Created 0-15 hari sebelum reservation

Total Revenue (approx): Rp 75,000,000 - 120,000,000
Average per Reservation: Rp 500,000 - 1,500,000
Status Breakdown:
  - Pending: ~35 reservations
  - Confirmed: ~20 reservations
  - Cancelled: ~5 reservations
```

### 🎯 Usage Examples

**Generate 200 reservations:**
```php
// In ReservationSeeder
Reservation::factory(200)->create();
```

**Generate dengan status tertentu:**
```php
// 50 pending reservations
Reservation::factory(50)->pending()->create();

// 30 confirmed reservations
Reservation::factory(30)->confirmed()->create();
```

**Generate dalam controller/command:**
```php
// Generate 10 reservations on-the-fly
Reservation::factory(10)->create();

// Generate dengan custom attribute
Reservation::factory(5)->create([
    'destination_id' => 1,
    'status' => 'confirmed'
]);
```

---

## 📚 File Reference

| File | Purpose |
|------|---------|
| `app/Models/Users.php` | User model |
| `app/Models/Destination.php` | Destination model |
| `app/Models/Reservation.php` | Reservation model |
| `app/Models/StatusHistory.php` | Audit trail model |
| `app/Http/Controllers/AuthController.php` | Auth logic |
| `app/Http/Controllers/Admin/DashboardController.php` | Dashboard |
| `app/Http/Controllers/Admin/DestinationController.php` | Destination CRUD |
| `app/Http/Controllers/Admin/ReservationController.php` | Reservation CRUD + status |
| `database/migrations/` | Database schemas |
| `database/factories/ReservationFactory.php` | 200+ data generation |
| `database/seeders/` | Test data generators |
| `routes/web.php` | URL routing |

---

**Last Updated:** November 24, 2025  
**Version:** 2.2.0  
**Status:** ✅ Documentation Complete + 200 Data Seeding
