# 🏖️ Sistem Reservasi Wisata - Kelompok 4

![Laravel](https://img.shields.io/badge/Laravel-10-red?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-purple?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-blue?style=flat-square&logo=mysql)
![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)

> Platform Digital untuk Manajemen Reservasi Destinasi Wisata dengan Interface Modern dan Fitur AJAX

## 📸 Fitur Utama

- 🔐 **Sistem Authentication** - Login/Register dengan role-based access control
- 🎯 **CRUD Destinasi** - Admin dapat mengelola destinasi wisata (Create, Read, Update, Delete)
- 📅 **Booking Reservasi** - Customer dapat membuat dan mengelola reservasi
- 🔄 **AJAX Functionality** - Semua operasi tanpa page reload untuk UX yang smooth
- 📊 **Admin Dashboard** - Statistik real-time (total destinasi, pesanan, revenue)
- 🎨 **Responsive Design** - Mobile-friendly dengan gradient UI yang modern
- 🔍 **Search & Filter** - Cari destinasi dan filter pesanan dengan AJAX
- 🔔 **Toast Notifications** - Feedback visual untuk setiap aksi user

## 🏗️ Teknologi Stack

| Kategori | Teknologi |
|----------|-----------|
| **Backend** | Laravel 10 |
| **Frontend** | Blade Template + Vanilla JavaScript |
| **Database** | MySQL 8.0 |
| **Server** | Apache (XAMPP) |
| **Styling** | CSS3 + Gradient Colors |
| **API** | RESTful JSON API |

## 👥 Sistem Role & Akses

### Customer (Pelanggan)
```
✓ Melihat destinasi wisata
✓ Membuat reservasi baru
✓ Melihat riwayat booking
✓ Membatalkan reservasi (status pending)
✓ Dashboard personal
```

### Petugas/Admin
```
✓ Akses Admin Dashboard dengan statistik
✓ Full CRUD destinasi wisata
✓ Mengelola semua pesanan customer
✓ Update status pesanan (pending → dikonfirmasi/dibatalkan)
✓ Melihat analytics & revenue
```

### Guest (Pengunjung)
```
✓ Melihat destinasi yang tersedia
✓ Search & filter destinasi
✓ Melihat statistik sistem
✓ Akses login/register page
```

## 📋 Database Schema

### Users Table
```sql
- id, name, email (unique), hp, role, status
- password, timestamps
- role: 'customer' | 'petugas_user'
- status: 'active' | 'inactive'
```

### Wisatas Table (Destinasi)
```sql
- id, nama, deskripsi, lokasi, harga, kapasitas, status, timestamps
- status: 'tersedia' | 'penuh'
```

### Reservasis Table (Pesanan)
```sql
- id, user_id (FK), wisata_id (FK)
- tanggal_reservasi, jumlah_orang, total_harga
- status: 'pending' | 'dikonfirmasi' | 'dibatalkan'
- catatan, timestamps
```

## 🚀 Quick Start

### Prerequisites
- PHP 8.1+
- MySQL 8.0+
- Composer
- XAMPP/Server

### Installation

1. **Clone Repository**
```bash
git clone https://github.com/yourusername/projectpakandri.git
cd projectpakandri
```

2. **Install Dependencies**
```bash
composer install
```

3. **Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Edit `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_project_reservasi
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run Migrations & Seeders**
```bash
php artisan migrate:fresh --seed
```

6. **Start Server**
```bash
php artisan serve
```

Server akan berjalan di `http://127.0.0.1:8000`

## 🔑 Test Accounts

Setelah menjalankan seeder, gunakan akun berikut:

### Admin/Petugas
```
Email: admin@wisata.com
Password: password123
```

### Customer
```
Email: budi@example.com
Password: password123

Email: siti@example.com
Password: password123
```

## 📁 Project Structure

```
projectpakandri/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── RegisterController.php
│   │   │   ├── ReservasiController.php
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php
│   │   │       ├── DestinasiController.php
│   │   │       └── PesananController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Wisata.php
│       └── Reservasi.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   ├── UserSeeder.php
│   │   ├── WisataSeeder.php
│   │   └── ReservasiSeeder.php
├── resources/views/
│   ├── beranda.blade.php
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── dashboard/
│   │   └── dashboard.blade.php
│   ├── reservasi/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── show.blade.php
│   └── admin/
│       ├── dashboard.blade.php
│       ├── destinasi/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       └── pesanan/
│           ├── index.blade.php
│           └── show.blade.php
├── routes/
│   ├── web.php
│   └── api.php
└── ...
```

## 🔌 API Endpoints

### Public API (No Auth Required)

**Get All Destinations**
```http
GET /api/destinasi
Content-Type: application/json
```

**Search Destinations**
```http
GET /api/destinasi?search=pantai
Content-Type: application/json
```

**Get Statistics**
```http
GET /api/stats
Content-Type: application/json
```

Response:
```json
{
  "totalDestinasi": 10,
  "totalReservasi": 7,
  "totalCustomer": 4
}
```

## 🎯 User Workflows

### Customer Booking Flow
```
1. Homepage → Browse Destinasi
2. Login/Register
3. Create Reservasi
4. View Riwayat Booking
5. Cancel Reservasi (jika pending)
6. Dashboard Personal
```

### Admin Management Flow
```
1. Login (admin account)
2. Admin Dashboard (lihat statistics)
3. Manage Destinasi (CRUD)
4. Manage Pesanan Customer
5. Update Status Pesanan
6. View Analytics
```

## 🎨 UI Features

- **Gradient Backgrounds**: Purple-Blue gradient untuk customer, Red gradient untuk admin
- **AJAX Interactions**: Semua operasi tanpa page reload
- **Modal Confirmations**: Konfirmasi sebelum delete/cancel
- **Toast Notifications**: Real-time feedback untuk user
- **Responsive Grid**: Auto-fit layout untuk berbagai screen sizes
- **Status Badges**: Visual status indicator (pending, confirmed, cancelled)
- **Loading Spinners**: Feedback saat loading data

## ✨ AJAX Features

### Destinasi Operations
```javascript
// Delete dengan confirmation modal
DELETE /admin/destinasi/{id}
// Returns: { success: true/false, message: "..." }
```

### Reservasi Operations
```javascript
// Cancel reservation
PUT /reservasi/{id}/cancel
// Returns: { success: true/false, message: "..." }
```

### Pesanan Operations
```javascript
// Update status
PATCH /admin/pesanan/{id}/status/{status}
// Returns: { success: true/false, message: "..." }
```

### Search & Filter
```javascript
// Search destinasi
GET /api/destinasi?search=keyword

// Filter pesanan by status
// Client-side filtering
```

## 📊 Security Features

✅ **Authentication** - Email/Password validation  
✅ **Authorization** - Role-based middleware (CheckRole)  
✅ **CSRF Protection** - Token included in forms & AJAX  
✅ **Password Hashing** - Bcrypt hashing via Hash::make()  
✅ **Session Management** - Session regeneration on login  
✅ **Input Validation** - Server-side validation on all inputs  
✅ **JSON API Security** - Accept header validation for AJAX  

## 🧪 Testing

### Manual Testing

1. **Test Guest Flow**
   - Buka homepage tanpa login
   - Search destinasi
   - Lihat stats

2. **Test Customer Flow**
   - Register user baru
   - Create reservasi
   - View reservasi
   - Cancel reservasi

3. **Test Admin Flow**
   - Login as admin
   - CRUD destinasi
   - Manage customer pesanan
   - Update pesanan status

### Test Data
- 10 Destinasi wisata
- 6 User accounts (2 admin, 4 customer)
- 7 Sample reservasi dengan berbagai status

## 📝 API Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation berhasil",
  "data": { ... }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Error message",
  "errors": { ... }
}
```

## 🛠️ Development Commands

```bash
# Fresh migrate dengan seeding
php artisan migrate:fresh --seed

# Clear cache
php artisan cache:clear
php artisan config:clear

# View all routes
php artisan route:list

# Tinker shell
php artisan tinker

# Generate app key
php artisan key:generate
```

## 📈 Performance Optimization

- ✅ Eager Loading: `with('wisata')`, `with(['user', 'wisata'])`
- ✅ Query Optimization: Minimal queries menggunakan relationships
- ✅ Caching: Session caching untuk user preferences
- ✅ AJAX: No full page reloads untuk smooth UX
- ✅ Lazy Loading Images: Emoji icons tidak perlu loading



```

## 🐛 Known Limitations

- Image upload untuk destinasi tidak diimplementasikan (menggunakan emoji)
- Email notifications belum terintegrasi
- Password reset functionality belum ada
- Two-factor authentication belum ada
- Real-time notifications belum ada




**Kelompok 4 - Sistem Informasi**

Untuk questions atau issues:
1. Buat GitHub Issue di repository
2. Contact development team
3. Check documentation di Wiki

## 📄 License

MIT License - Project ini tersedia untuk keperluan akademik dan komersial

## 👏 Credits

**Development Team - Kelompok 4**
- Backend: Laravel Framework
- Frontend: Blade Templates + Vanilla JavaScript
- Database: MySQL
- UI/UX Design: Custom CSS with Gradients

---

**Last Updated:** November 3, 2025  

