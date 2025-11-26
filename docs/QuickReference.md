# 🎯 QUICK REFERENCE - SISTEM RESERVASI WISATA

> Referensi cepat untuk memahami alur sistem dalam 5 menit

---

## 📊 OVERVIEW

```
┌────────────────────────────────────────────────────────────┐
│   SISTEM RESERVASI WISATA - ADMIN DASHBOARD               │
│                                                            │
│   Stack: Laravel 10 + MySQL + Bootstrap 5 + Chart.js      │
│   Purpose: Manage destinations & reservations             │
│   Users: Admin only (role-based access control)           │
└────────────────────────────────────────────────────────────┘
```

---

## 🔐 LOGIN FLOW

```
1. User akses http://localhost:8000/login
   └─ Middleware: guest (hanya user belum login)
   
2. User input email + password
   └─ Email: admin@wisata.com
   └─ Password: password
   
3. System validasi
   ├─ Email valid?
   ├─ Password benar?
   ├─ Role = admin?
   └─ Success → redirect /admin/dashboard
      Fail   → back ke form dengan error
   
4. Session terbuat
   └─ Cookie session ID
   └─ Lifetime: 120 menit
   └─ Stored in storage/framework/sessions/
```

---

## 🗂️ 4 MAIN TABLES

```
USERS (Admin)
│
├─ id: 1
├─ email: admin@wisata.com
├─ role: admin
└─ password: hashed

        ↓ (Authenticatable)

DESTINATIONS (Wisata)
│
├─ id: 1
├─ name: "Pantai Indah"
├─ location: "Bali"
├─ price: 500000
├─ rating: 4.5
└─ [image_url, description, total_visitors]

        ↓ (hasMany) 1:M

RESERVATIONS (Pemesanan)
│
├─ id: 1
├─ customer_name: "John Doe"
├─ destination_id: 1
├─ reservation_date: 2025-12-01
├─ quantity: 2
├─ total_price: 1000000
├─ status: "pending"
└─ [customer_email, customer_phone, notes]

        ↓ (hasMany) 1:M

STATUS_HISTORIES (Audit Trail)
│
├─ id: 1
├─ old_status: null
├─ new_status: "pending"
├─ changed_by: "admin@wisata.com"
├─ created_at: 2025-12-01 10:00:00
└─ [reason, notes]
```

---

## 🔄 CRUD OPERATIONS

### Destinations

| Operation | Method | Route | Middleware |
|-----------|--------|-------|------------|
| List | GET | /admin/destinations | auth |
| Create Form | GET | /admin/destinations/create | auth |
| Save | POST | /admin/destinations | auth |
| Detail | GET | /admin/destinations/{id} | auth |
| Edit Form | GET | /admin/destinations/{id}/edit | auth |
| Update | PUT | /admin/destinations/{id} | auth |
| Delete | DELETE | /admin/destinations/{id} | auth |

**Features:**
- Search: by name or location
- Filter: by price range, rating
- Sort: by any column
- Paginate: 10 items/page

### Reservations

| Operation | Method | Route | Middleware |
|-----------|--------|-------|------------|
| List | GET | /admin/reservations | auth |
| Create Form | GET | /admin/reservations/create | auth |
| Save | POST | /admin/reservations | auth |
| Detail | GET | /admin/reservations/{id} | auth |
| Edit Form | GET | /admin/reservations/{id}/edit | auth |
| Update | PUT | /admin/reservations/{id} | auth |
| Delete | DELETE | /admin/reservations/{id} | auth |
| Quick Status | POST | /admin/reservations/{id}/change-status | auth |
| Bulk Status | POST | /admin/reservations/bulk-status-update | auth |
| Audit Trail | GET | /admin/reservations/{id}/status-history | auth |

**Features:**
- Search: by customer name/email/phone
- Filter: by status, destination, date range
- Sort: by any column
- Paginate: 10 items/page
- Eager load destination (N+1 prevention)

---

## 📋 VALIDATIONS

### ✅ Two-Layer Validation (Frontend + Backend)

#### **Customers**

**Backend Rules:**
```
name:        required | min:3 | max:100 | letters & spaces only
email:       required | unique | valid format | lowercase ONLY
phone:       required | unique | 10-15 digits only
city:        optional | letters & spaces only
province:    optional | letters & spaces only  
postal_code: optional | 4-6 digits only
notes:       optional | max 1000 chars
```

**Frontend Validation:**
```html
name:        pattern="^[a-zA-Z\s]{3,100}$" minlength="3" maxlength="100"
email:       type="email" + helper text for lowercase
phone:       type="tel" pattern="^[0-9]{10,15}$"
city:        pattern="^[a-zA-Z\s]*$" maxlength="100"
province:    pattern="^[a-zA-Z\s]*$" maxlength="100"
postal_code: pattern="^[0-9]{4,6}$"
notes:       maxlength="1000"
```

**Special Features:**
- 💡 Email automatically converted to lowercase (backend)
- ✓ Phone & Email must be unique per customer
- ✓ All error messages in Indonesian

---

#### **Destinations**

**Backend Rules:**
```
name:         required | min:5 | max:100 | unique
location:     required | min:5 | max:100
description:  required | min:10 | max:2000
price:        required | Rp 10,000 - Rp 999,999,999
rating:       optional | 0-5 stars
image_url:    optional | valid URL | max 500 chars
total_visitors: optional | integer
```

**Frontend Validation:**
```html
name:       minlength="5" maxlength="100"
location:   minlength="5" maxlength="100"
description: minlength="10" maxlength="2000"
price:      type="number" min="10000" max="999999999" step="1"
rating:     type="number" min="0" max="5" step="0.1"
image_url:  type="url" maxlength="500"
```

**Special Features:**
- ✓ Destination name must be unique
- ✓ Price has realistic business range
- ✓ Rating in 0.1 increments (0.0 to 5.0)

---

#### **Reservations**

**Backend Rules:**
```
customer_id:      required | must exist in customers table
destination_id:   required | must exist in destinations table
reservation_date: required | future date | max 1 year ahead
quantity:         required | 1-100 people per reservation
total_price:      required | Rp 50,000 - Rp 999,999,999
status:           required | in [pending, confirmed, cancelled]
notes:            optional | max 1000 chars
```

**Frontend Validation:**
```html
reservation_date: type="date" min="+1 day" max="+1 year"
quantity:         type="number" min="1" max="100" onchange="updatePrice()"
total_price:      type="number" min="50000" readonly (auto-calculated)
status:           select (3 valid options)
notes:            maxlength="1000"
```

**Special Features:**
- 🚫 Cannot book past dates or more than 1 year ahead
- 💡 Total price auto-calculated: destination_price × quantity
- ✓ Total price field is readonly to prevent manual errors
- ✓ Status automatically logged in status_histories table

---

#### **Login**

**Backend Rules:**
```
email:    required | valid email format
password: required | min 6 characters
```

---

### 🔄 Status Change Validation

**Backend Rules:**
```
status: required | in [pending, confirmed, cancelled]
reason: optional | string (for cancellation reason)
```

---

### 📊 Validation Statistics

**Total Validation Rules per Module:**
- Customers: 7 rules (backend) + 7 fields (frontend)
- Destinations: 7 rules (backend) + 7 fields (frontend)
- Reservations: 7 rules (backend) + 5 fields (frontend)

**Key Features:**
- ✅ Email lowercase enforcement
- ✅ Unique constraints (email, phone, destination name)
- ✅ Regex patterns for format validation
- ✅ Date range constraints (future dates only)
- ✅ Quantity limits (1-100 people)
- ✅ Price range validation
- ✅ Auto-calculated total price
- ✅ All custom error messages in Indonesian
- ✅ Browser-level frontend validation (instant feedback)
- ✅ Server-level backend validation (security gate)

---

## 🎨 CONTROLLERS & METHODS

### AuthController

```php
showLogin()       → GET /login
login()           → POST /login
logout()          → POST /logout
```

### DashboardController

```php
index()                    → GET /admin/dashboard
getReservationChartData()  → (internal) Last 30 days
getRevenueByMonth()        → (internal) Last 3 months
getStatusDistribution()    → (internal) Status counts
```

### DestinationController

```php
index()      → GET /admin/destinations (with search/filter)
create()     → GET /admin/destinations/create
store()      → POST /admin/destinations
show()       → GET /admin/destinations/{id}
edit()       → GET /admin/destinations/{id}/edit
update()     → PUT /admin/destinations/{id}
destroy()    → DELETE /admin/destinations/{id}
```

### ReservationController

```php
index()                 → GET /admin/reservations (with search/filter)
create()                → GET /admin/reservations/create
store()                 → POST /admin/reservations
                           + create StatusHistory
show()                  → GET /admin/reservations/{id}
edit()                  → GET /admin/reservations/{id}/edit
update()                → PUT /admin/reservations/{id}
                           + create StatusHistory if status changed
destroy()               → DELETE /admin/reservations/{id}
changeStatus()          → POST /admin/reservations/{id}/change-status
bulkStatusUpdate()      → POST /admin/reservations/bulk-status-update
statusHistory()         → GET /admin/reservations/{id}/status-history
```

---

## 🛡️ MIDDLEWARE STACK

```
Request comes in
    ↓
1. EncryptCookies      → Encrypt cookies
    ↓
2. TrimStrings         → Trim input strings
    ↓
3. ConvertEmptyStrings → Convert empty to null
    ↓
4. TrustProxies        → Handle proxy headers
    ↓
5. Authenticate        → Check if logged in?
                         YES → continue
                         NO  → redirect /login
    ↓
6. VerifyCsrfToken     → CSRF protection
    ↓
7. ShareErrorsFromSession → Share validation errors
    ↓
8. SubstituteBindings  → Auto-inject models
    ↓
✓ Reach Controller Method
```

---

## 📈 DASHBOARD ANALYTICS

```
┌─────────────────────────────────────────────┐
│           STATISTICS CARDS                  │
├─────────────────────────────────────────────┤
│ Total Destinations  │ Total Reservations    │
│ X destinasi         │ Y reservations        │
├─────────────────────────────────────────────┤
│ Total Revenue       │ Pending Reservations  │
│ Rp XXX,XXX,XXX      │ Z pending             │
└─────────────────────────────────────────────┘

┌─────────────────────────────────────────────┐
│        CHARTS & ANALYTICS                   │
├─────────────────────────────────────────────┤
│ 30-Day Reservations  │ Revenue by Month     │
│ (Line Chart)         │ (Bar Chart)          │
├─────────────────────────────────────────────┤
│ Status Distribution  │ Top 5 Destinations   │
│ (Pie Chart)          │ (Bar Chart)          │
└─────────────────────────────────────────────┘
```

---

## 🔄 STATUS MANAGEMENT FLOW

```
Initial Status: pending

┌──────────────────┐
│   PENDING        │  ← New reservation created
│  (waiting)       │
└────────┬─────────┘
         │
    User can choose:
    ├─ Confirm → CONFIRMED
    └─ Cancel  → CANCELLED

┌──────────────────┐
│   CONFIRMED      │  ← Reservation approved
│  (approved)      │
└────────┬─────────┘
         │
    User can choose:
    └─ Cancel  → CANCELLED

┌──────────────────┐
│   CANCELLED      │  ← Final state
│  (cancelled)     │
└──────────────────┘

AUDIT TRAIL:
- pending → confirmed (by admin@wisata.com, 2025-12-01 10:00)
- confirmed → cancelled (by admin@wisata.com, reason: customer request, 2025-12-01 11:00)
```

---

## 🚀 QUICK START COMMANDS

```bash
# Install & Setup
composer install              # Install PHP dependencies
npm install                   # Install JS dependencies
php artisan key:generate      # Generate APP_KEY
php artisan migrate --seed    # Run migrations + seeders

# Start Development
php artisan serve             # Start Laravel server (http://localhost:8000)
npm run dev                   # Start Vite (asset compiler)

# Database
php artisan migrate           # Run migrations
php artisan migrate:rollback  # Rollback last migration
php artisan db:seed          # Run seeders
php artisan tinker           # Laravel console

# Artisan Helpers
php artisan route:list       # List all routes
php artisan model:show App\\Models\\Destination  # Model info
php artisan make:seeder ReservationSeeder        # Create new seeder
```

---

## 📍 KEY FILES

| File | Purpose |
|------|---------|
| `app/Models/*.php` | Database models & relationships |
| `app/Http/Controllers/**/*.php` | Business logic |
| `routes/web.php` | Route definitions |
| `database/migrations/*.php` | Database schema |
| `database/seeders/*.php` | Test data generation |
| `resources/views/**/*.blade.php` | HTML templates |
| `config/*.php` | Configuration files |
| `.env` | Environment variables |
| `composer.json` | PHP dependencies |
| `package.json` | Node dependencies |

---

## 🔒 SECURITY CHECKLIST

✅ Authentication (login required)  
✅ Authorization (role-based access)  
✅ CSRF protection (token verification)  
✅ Password hashing (bcrypt)  
✅ Session management (120 min lifetime)  
✅ Mass assignment protection ($fillable)  
✅ SQL injection prevention (Eloquent ORM)  
✅ XSS protection (Blade escaping)  
✅ Foreign key constraints  
✅ Cascade delete (referential integrity)  

---

## 🎯 DEFAULT CREDENTIALS

```
Email: admin@wisata.com
Password: password
Role: admin
```

**Note:** Change these in production!

---

## 💡 TIPS

1. **Search & Filter** works on index pages (destinations & reservations)
2. **Pagination** is set to 10 items/page
3. **Cascade Delete** means:
   - Deleting destination → deletes all its reservations
   - Deleting reservation → deletes all its status histories
4. **Status History** is automatically logged on every status change
5. **Dashboard** refreshes data in real-time (no caching)
6. **Timestamps** (created_at, updated_at) are auto-managed by Laravel

---

**Created:** 26 November 2025  
**Last Updated:** 26 November 2025  
**Version:** 1.0.0
