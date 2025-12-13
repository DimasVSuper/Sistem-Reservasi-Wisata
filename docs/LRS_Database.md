# 📊 LOGICAL RECORD STRUCTURE (LRS)
## Sistem Reservasi Wisata

**Versi:** 3.0.0  
**Tanggal:** November 2025  
**Database:** MySQL 8.0

---

## 📋 DAFTAR TABEL

| No | Nama Tabel | Deskripsi | Jumlah Field |
|----|------------|-----------|--------------|
| 1 | `users` | Data pengguna sistem (admin/user) | 8 |
| 2 | `customers` | Data pelanggan yang melakukan reservasi | 10 |
| 3 | `destinations` | Data destinasi/tempat wisata | 9 |
| 4 | `reservations` | Data reservasi pelanggan | 11 |
| 5 | `status_histories` | Riwayat perubahan status reservasi | 9 |

---

## 🗂️ STRUKTUR TABEL DETAIL

### 1️⃣ TABEL: `users`
**Deskripsi:** Menyimpan data pengguna sistem untuk autentikasi

| No | Field | Tipe Data | Constraint | Keterangan |
|----|-------|-----------|------------|------------|
| 1 | `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID unik pengguna |
| 2 | `username` | VARCHAR(255) | NOT NULL | Nama pengguna |
| 3 | `email` | VARCHAR(255) | NOT NULL, UNIQUE | Email pengguna (login) |
| 4 | `password` | VARCHAR(255) | NOT NULL | Password terenkripsi (bcrypt) |
| 5 | `No_Handphone` | VARCHAR(15) | NOT NULL | Nomor HP pengguna |
| 6 | `role` | ENUM('user','admin') | DEFAULT 'user' | Hak akses pengguna |
| 7 | `remember_token` | VARCHAR(100) | NULLABLE | Token untuk "remember me" |
| 8 | `created_at` | TIMESTAMP | NULLABLE | Waktu pembuatan |
| 9 | `updated_at` | TIMESTAMP | NULLABLE | Waktu update terakhir |

---

### 2️⃣ TABEL: `customers`
**Deskripsi:** Menyimpan data pelanggan yang melakukan reservasi wisata

| No | Field | Tipe Data | Constraint | Keterangan |
|----|-------|-----------|------------|------------|
| 1 | `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID unik pelanggan |
| 2 | `name` | VARCHAR(100) | NOT NULL | Nama lengkap pelanggan |
| 3 | `email` | VARCHAR(100) | NOT NULL, UNIQUE | Email pelanggan |
| 4 | `phone` | VARCHAR(20) | NOT NULL | Nomor telepon (10-15 digit) |
| 5 | `address` | TEXT | NULLABLE | Alamat lengkap |
| 6 | `city` | VARCHAR(100) | NULLABLE | Kota domisili |
| 7 | `province` | VARCHAR(100) | NULLABLE | Provinsi domisili |
| 8 | `postal_code` | VARCHAR(10) | NULLABLE | Kode pos (4-6 digit) |
| 9 | `notes` | TEXT | NULLABLE | Catatan tambahan |
| 10 | `created_at` | TIMESTAMP | NULLABLE | Waktu pembuatan |
| 11 | `updated_at` | TIMESTAMP | NULLABLE | Waktu update terakhir |

---

### 3️⃣ TABEL: `destinations`
**Deskripsi:** Menyimpan data destinasi/tempat wisata yang tersedia

| No | Field | Tipe Data | Constraint | Keterangan |
|----|-------|-----------|------------|------------|
| 1 | `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID unik destinasi |
| 2 | `name` | VARCHAR(100) | NOT NULL | Nama destinasi wisata |
| 3 | `description` | TEXT | NOT NULL | Deskripsi destinasi |
| 4 | `location` | VARCHAR(100) | NOT NULL | Lokasi destinasi |
| 5 | `price` | DECIMAL(12,2) | NOT NULL | Harga per orang (Rp) |
| 6 | `image_url` | VARCHAR(255) | NULLABLE | URL gambar destinasi |
| 7 | `rating` | DECIMAL(3,2) | DEFAULT 0 | Rating 0.00 - 5.00 |
| 8 | `total_visitors` | INT | DEFAULT 0 | Total pengunjung |
| 9 | `created_at` | TIMESTAMP | NULLABLE | Waktu pembuatan |
| 10 | `updated_at` | TIMESTAMP | NULLABLE | Waktu update terakhir |

---

### 4️⃣ TABEL: `reservations`
**Deskripsi:** Menyimpan data reservasi/pemesanan wisata pelanggan

| No | Field | Tipe Data | Constraint | Keterangan |
|----|-------|-----------|------------|------------|
| 1 | `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID unik reservasi |
| 2 | `customer_id` | BIGINT UNSIGNED | FOREIGN KEY, NOT NULL | Referensi ke customers.id |
| 3 | `customer_name` | VARCHAR(255) | NOT NULL | Nama customer (denormalized) |
| 4 | `destination_id` | BIGINT UNSIGNED | FOREIGN KEY, NOT NULL | Referensi ke destinations.id |
| 5 | `reservation_date` | DATE | NOT NULL | Tanggal reservasi |
| 6 | `quantity` | INT | NOT NULL | Jumlah orang (1-100) |
| 7 | `total_price` | DECIMAL(12,2) | NOT NULL | Total harga (quantity × price) |
| 8 | `status` | ENUM('pending','confirmed','cancelled') | DEFAULT 'pending' | Status reservasi |
| 9 | `notes` | TEXT | NULLABLE | Catatan reservasi |
| 10 | `created_at` | TIMESTAMP | NULLABLE | Waktu pembuatan |
| 11 | `updated_at` | TIMESTAMP | NULLABLE | Waktu update terakhir |

---

### 5️⃣ TABEL: `status_histories`
**Deskripsi:** Menyimpan riwayat perubahan status reservasi (audit trail)

| No | Field | Tipe Data | Constraint | Keterangan |
|----|-------|-----------|------------|------------|
| 1 | `id` | BIGINT UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID unik history |
| 2 | `reservation_id` | BIGINT UNSIGNED | FOREIGN KEY, NOT NULL | Referensi ke reservations.id |
| 3 | `old_status` | ENUM('pending','confirmed','cancelled') | NULLABLE | Status sebelumnya |
| 4 | `new_status` | ENUM('pending','confirmed','cancelled') | NOT NULL | Status baru |
| 5 | `reason` | VARCHAR(255) | NULLABLE | Alasan perubahan |
| 6 | `changed_by` | VARCHAR(255) | NULLABLE | Admin yang mengubah |
| 7 | `notes` | TEXT | NULLABLE | Catatan tambahan |
| 8 | `created_at` | TIMESTAMP | NULLABLE | Waktu perubahan |
| 9 | `updated_at` | TIMESTAMP | NULLABLE | Waktu update |

**Index:**
- INDEX pada `reservation_id`
- INDEX pada `created_at`

---

## 🔗 RELASI ANTAR TABEL

### Diagram Relasi (Text-based)
```
┌─────────────────┐
│     users       │
├─────────────────┤
│ *id (PK)        │
│  username       │
│  email (UNIQUE) │
│  password       │
│  No_Handphone   │
│  role           │
│  remember_token │
│  timestamps     │
└─────────────────┘
        │
        │ (standalone - untuk login admin)
        │
        
┌─────────────────┐          ┌─────────────────────┐
│   customers     │          │    destinations     │
├─────────────────┤          ├─────────────────────┤
│ *id (PK)        │          │ *id (PK)            │
│  name           │          │  name               │
│  email (UNIQUE) │          │  description        │
│  phone          │          │  location           │
│  address        │          │  price              │
│  city           │          │  image_url          │
│  province       │          │  rating             │
│  postal_code    │          │  total_visitors     │
│  notes          │          │  timestamps         │
│  timestamps     │          └──────────┬──────────┘
└────────┬────────┘                     │
         │                              │
         │ (1)                     (1)  │
         │                              │
         └──────────┐    ┌──────────────┘
                    │    │
                   (N)  (N)
                    │    │
                    ▼    ▼
          ┌─────────────────────────┐
          │      reservations       │
          ├─────────────────────────┤
          │ *id (PK)                │
          │ #customer_id (FK)  ─────┼──→ customers.id
          │  customer_name          │
          │ #destination_id (FK) ───┼──→ destinations.id
          │  reservation_date       │
          │  quantity               │
          │  total_price            │
          │  status                 │
          │  notes                  │
          │  timestamps             │
          └───────────┬─────────────┘
                      │
                      │ (1)
                      │
                     (N)
                      │
                      ▼
          ┌─────────────────────────┐
          │    status_histories     │
          ├─────────────────────────┤
          │ *id (PK)                │
          │ #reservation_id (FK) ───┼──→ reservations.id
          │  old_status             │
          │  new_status             │
          │  reason                 │
          │  changed_by             │
          │  notes                  │
          │  timestamps             │
          └─────────────────────────┘

Keterangan:
* = Primary Key (PK)
# = Foreign Key (FK)
(1) = One side
(N) = Many side
```

---

## 📊 KARDINALITAS RELASI

| Relasi | Tabel 1 | Kardinalitas | Tabel 2 | Keterangan |
|--------|---------|--------------|---------|------------|
| R1 | customers | 1 : N | reservations | 1 customer bisa punya banyak reservasi |
| R2 | destinations | 1 : N | reservations | 1 destinasi bisa punya banyak reservasi |
| R3 | reservations | 1 : N | status_histories | 1 reservasi bisa punya banyak history status |

---

## 🔑 FOREIGN KEY CONSTRAINTS

### 1. reservations.customer_id → customers.id
```sql
FOREIGN KEY (customer_id) 
    REFERENCES customers(id) 
    ON DELETE CASCADE
```
**Behavior:** Jika customer dihapus, semua reservasi customer tersebut ikut terhapus.

### 2. reservations.destination_id → destinations.id
```sql
FOREIGN KEY (destination_id) 
    REFERENCES destinations(id) 
    ON DELETE CASCADE
```
**Behavior:** Jika destinasi dihapus, semua reservasi ke destinasi tersebut ikut terhapus.

### 3. status_histories.reservation_id → reservations.id
```sql
FOREIGN KEY (reservation_id) 
    REFERENCES reservations(id) 
    ON DELETE CASCADE
```
**Behavior:** Jika reservasi dihapus, semua history status reservasi tersebut ikut terhapus.

---

## 📐 LRS DIAGRAM (Logical Record Structure)

```
┌─────────────────────────────────────────────────────────────────────────────────┐
│                         LOGICAL RECORD STRUCTURE                                │
│                         Sistem Reservasi Wisata                                 │
└─────────────────────────────────────────────────────────────────────────────────┘

┌───────────────────────┐
│        USERS          │
├───────────────────────┤
│ id            : PK    │
│ username      : str   │
│ email         : str   │◄── UNIQUE
│ password      : str   │
│ No_Handphone  : str   │
│ role          : enum  │
└───────────────────────┘


┌───────────────────────┐                    ┌───────────────────────┐
│      CUSTOMERS        │                    │     DESTINATIONS      │
├───────────────────────┤                    ├───────────────────────┤
│ id            : PK    │                    │ id            : PK    │
│ name          : str   │                    │ name          : str   │
│ email         : str   │◄── UNIQUE          │ description   : text  │
│ phone         : str   │                    │ location      : str   │
│ address       : text  │                    │ price         : dec   │
│ city          : str   │                    │ image_url     : str   │
│ province      : str   │                    │ rating        : dec   │
│ postal_code   : str   │                    │ total_visitors: int   │
│ notes         : text  │                    └───────────┬───────────┘
└───────────┬───────────┘                                │
            │                                            │
            │ 1                                        1 │
            │                                            │
            │                                            │
            └──────────────┐          ┌─────────────────┘
                           │          │
                           ▼ N      N ▼
                    ┌──────────────────────────┐
                    │       RESERVATIONS       │
                    ├──────────────────────────┤
                    │ id               : PK    │
                    │ customer_id      : FK    │───→ customers.id
                    │ customer_name    : str   │
                    │ destination_id   : FK    │───→ destinations.id
                    │ reservation_date : date  │
                    │ quantity         : int   │
                    │ total_price      : dec   │
                    │ status           : enum  │
                    │ notes            : text  │
                    └────────────┬─────────────┘
                                 │
                                 │ 1
                                 │
                                 ▼ N
                    ┌──────────────────────────┐
                    │     STATUS_HISTORIES     │
                    ├──────────────────────────┤
                    │ id               : PK    │
                    │ reservation_id   : FK    │───→ reservations.id
                    │ old_status       : enum  │
                    │ new_status       : enum  │
                    │ reason           : str   │
                    │ changed_by       : str   │
                    │ notes            : text  │
                    └──────────────────────────┘
```

---

## 📝 NOTASI LRS

### Primary Key (PK)
```
Ditandai dengan: *field_name atau : PK
Contoh: *id atau id : PK
```

### Foreign Key (FK)
```
Ditandai dengan: #field_name atau : FK
Contoh: #customer_id atau customer_id : FK
```

### Tipe Data
```
str     = String/VARCHAR
text    = TEXT (long string)
int     = Integer
dec     = Decimal
date    = Date
enum    = Enumeration
bool    = Boolean
```

### Kardinalitas
```
1 : 1   = One-to-One
1 : N   = One-to-Many
N : N   = Many-to-Many (memerlukan junction table)
```

---

## 🔄 ALUR DATA (Data Flow)

### Alur Reservasi Baru
```
1. Customer terdaftar di sistem
   └─ Data masuk ke tabel 'customers'

2. Admin menambah destinasi wisata
   └─ Data masuk ke tabel 'destinations'

3. Customer membuat reservasi
   └─ Data masuk ke tabel 'reservations'
   └─ customer_id → referensi ke customers.id
   └─ destination_id → referensi ke destinations.id
   └─ status default: 'pending'

4. Admin mengubah status reservasi
   └─ Update field 'status' di 'reservations'
   └─ Insert record baru di 'status_histories'
   └─ Track old_status, new_status, changed_by
```

### Alur Perubahan Status
```
pending ──────→ confirmed ──────→ (completed via business logic)
    │               │
    │               │
    └───────────────┴──────→ cancelled

Setiap perubahan status:
1. Update reservations.status
2. Insert ke status_histories dengan:
   - old_status: status sebelumnya
   - new_status: status baru
   - reason: alasan perubahan
   - changed_by: admin yang mengubah
   - timestamp: waktu perubahan
```

---

## 📊 SAMPLE DATA

### users
| id | username | email | role |
|----|----------|-------|------|
| 1 | Dimas | dimas@reservasi.local | admin |
| 2 | Septian | septian@reservasi.local | admin |

### customers
| id | name | email | phone | city |
|----|------|-------|-------|------|
| 1 | John Doe | john@email.com | 08123456789 | Jakarta |
| 2 | Jane Smith | jane@email.com | 08987654321 | Bandung |

### destinations
| id | name | location | price | rating |
|----|------|----------|-------|--------|
| 1 | Pantai Kuta | Bali | 150000.00 | 4.50 |
| 2 | Candi Borobudur | Magelang | 75000.00 | 4.80 |

### reservations
| id | customer_id | destination_id | reservation_date | quantity | total_price | status |
|----|-------------|----------------|------------------|----------|-------------|--------|
| 1 | 1 | 1 | 2025-12-15 | 2 | 300000.00 | confirmed |
| 2 | 2 | 2 | 2025-12-20 | 4 | 300000.00 | pending |

### status_histories
| id | reservation_id | old_status | new_status | changed_by |
|----|----------------|------------|------------|------------|
| 1 | 1 | pending | confirmed | admin |
| 2 | 2 | NULL | pending | system |

---

## ✅ NORMALISASI DATABASE

### First Normal Form (1NF) ✅
- Semua field atomik (tidak ada nilai berulang)
- Setiap tabel memiliki primary key
- Tidak ada duplikasi baris

### Second Normal Form (2NF) ✅
- Memenuhi 1NF
- Semua field non-key bergantung penuh pada primary key
- Tidak ada partial dependency

### Third Normal Form (3NF) ✅
- Memenuhi 2NF
- Tidak ada transitive dependency
- Field `customer_name` di reservations adalah denormalisasi yang disengaja untuk performa

---

## 📚 REFERENSI

- Laravel Eloquent Relationships: https://laravel.com/docs/eloquent-relationships
- Database Normalization: https://en.wikipedia.org/wiki/Database_normalization
- ERD & LRS Standards: Chen Notation

---

**Dibuat untuk:** Tugas LRS - Sistem Reservasi Wisata  
**Tim Pengembang:** Dimas, Septian, Ichwan, Mario, Rangga  
**Status:** ✅ Production Ready
