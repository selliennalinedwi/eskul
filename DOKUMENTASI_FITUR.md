# Dokumentasi Sistem Informasi Pendaftaran Ekskul Online

## Fitur yang Telah Diimplementasikan

### 1. Dashboard Multi-Level

#### Dashboard Guru
- **Lokasi**: `/guru/dashboard`
- **Fitur**:
  - Statistik siswa dan ekskul
  - Grafik distribusi siswa per ekskul
  - Daftar siswa yang terdaftar
  - Jadwal mengajar hari ini
  - Quick actions (catat kehadiran, kirim pesan, buat jadwal)
  - Aktivitas terbaru
  - Sidebar navigasi dengan akses ke berbagai menu

#### Dashboard Admin
- **Lokasi**: `/admin/dashboard`
- **Fitur**:
  - Statistik pendaftaran (pending, approved, rejected)
  - Grafik status pendaftaran (pie chart)
  - Daftar ekskul terpopuler
  - Aksi cepat (tambah ekskul, lihat pendaftaran, kelola pengguna)
  - Tabel pendaftaran yang menunggu verifikasi
  - Sidebar navigasi dengan akses ke semua fitur admin

### 2. Sistem Login Multi-Level

**Fitur**:
- Login dengan email dan password
- Validasi role (admin, guru, siswa)
- Session management
- Redirect otomatis ke dashboard sesuai role:
  - Admin → `/admin/dashboard`
  - Guru → `/guru/dashboard`
  - Siswa → `/ekskul` (halaman utama)

**File yang Dimodifikasi**:
- `app/Controllers/AuthController.php`
- `app/Config/Routes.php`

### 3. Early Warning System (Sistem Peringatan Dini)

#### Model dan Database
```php
// Database: early_warnings table
- id (primary key)
- student_id (foreign key)
- type (attendance, performance, behavior, dropout_risk)
- title
- description
- severity (low, medium, high)
- status (active, resolved)
- sent_at
- created_at, updated_at
```

#### Fitur
- **Buat Warning Manual** (`/early-warning/create`)
  - Pilih siswa
  - Tentukan tipe warning
  - Atur tingkat keseriusan
  - Tambah deskripsi

- **Dashboard Warning** (`/early-warning`)
  - Lihat semua warning aktif
  - Filter berdasarkan tipe dan tingkat keseriusan
  - Statistik warning
  - Tindakan (lihat detail, tandai selesai)

- **Kirim Notifikasi**
  - Email notification
  - WhatsApp notification
  - Multi-channel support

#### Services
- `app/Services/NotificationService.php` - Koordinator notifikasi
- `app/Services/EmailNotificationService.php` - Kirim email
- `app/Services/WhatsAppNotificationService.php` - Kirim WhatsApp

#### Konfigurasi WhatsApp
Tambahkan ke file `.env`:

```env
# WhatsApp Configuration
WHATSAPP_PROVIDER=twilio  # atau green_api, fonnte

# Untuk Twilio
WHATSAPP_ACCOUNT_SID=your_account_sid
WHATSAPP_AUTH_TOKEN=your_auth_token
WHATSAPP_PHONE_NUMBER=+1234567890

# Atau untuk Green API
WHATSAPP_INSTANCE_ID=your_instance_id
WHATSAPP_INSTANCE_KEY=your_instance_key

# Atau untuk Fonnte
WHATSAPP_FONNTE_TOKEN=your_fonnte_token
```

#### Controller
- `app/Controllers/EarlyWarningController.php`

#### Views
- `app/Views/early_warning/dashboard.php` - Dashboard
- `app/Views/early_warning/create_warning.php` - Form buat warning

### 4. Modul Upload Foto (Instagram-like)

#### Fitur Utama
- **Drag & Drop Upload**: Tarik foto ke area upload
- **Aspect Ratio Presets**: 
  - Square (1:1) - 1080x1080
  - Portrait (4:5) - 1080x1350
  - Landscape (16:9) - 1200x675
  - Story (9:16) - 1080x1920

- **Auto Crop & Resize**: Gambar otomatis di-crop ke tengah sesuai aspect ratio
- **Thumbnail Generation**: Buat thumbnail otomatis (300x300)
- **File Compression**: Kompresi gambar untuk performa optimal

#### Tipe Foto
- Profile - Foto profil user
- Product - Foto produk/barang
- Logo - Logo organisasi/ekskul
- Gallery - Galeri umum

#### Model
```php
// Database: media table
- id (primary key)
- user_id (foreign key)
- type (profile, product, logo, gallery)
- filename
- original_filename
- file_path
- mime_type
- file_size
- width
- height
- aspect_ratio
- description
- is_public (boolean)
- created_at, updated_at
```

#### Service
- `app/Services/ImageUploadService.php`
  - Upload dengan validasi
  - Crop dan resize otomatis
  - Generate thumbnail
  - Delete dengan cleanup file
  - Storage statistics

#### Controller
- `app/Controllers/MediaController.php`
  - `gallery()` - Tampilkan galeri
  - `uploadForm()` - Form upload
  - `upload()` - Process upload
  - `uploadAjax()` - AJAX upload (untuk preview langsung)
  - `viewPhoto()` - Lihat detail foto
  - `deletePhoto()` - Hapus foto
  - `updateVisibility()` - Ubah visibilitas (publik/pribadi)
  - `settings()` - Pengaturan media

#### Views
- `app/Views/media/upload_form.php` - Form upload dengan drag & drop
- `app/Views/media/gallery.php` - Galeri dengan filter dan statistik

#### Fitur JavaScript
- Drag & drop handler
- Real-time preview
- Progress bar simulation
- Filter berdasarkan tipe

### Routes yang Ditambahkan

```php
// Early Warning
$routes->get('early-warning', 'EarlyWarningController::dashboard');
$routes->get('early-warning/create', 'EarlyWarningController::createWarning');
$routes->post('early-warning/store', 'EarlyWarningController::storeWarning');
$routes->get('early-warning/view/(:num)', 'EarlyWarningController::viewWarning/$1');
$routes->get('early-warning/resolve/(:num)', 'EarlyWarningController::resolveWarning/$1');
$routes->get('early-warning/send-notifications', 'EarlyWarningController::sendPendingNotifications');

// Media/Upload
$routes->get('media/gallery', 'MediaController::gallery');
$routes->get('media/upload', 'MediaController::uploadForm');
$routes->post('media/upload', 'MediaController::upload');
$routes->post('media/upload-ajax', 'MediaController::uploadAjax');
$routes->get('media/view/(:num)', 'MediaController::viewPhoto/$1');
$routes->get('media/delete/(:num)', 'MediaController::deletePhoto/$1');
$routes->post('media/visibility/(:num)', 'MediaController::updateVisibility/$1');
$routes->get('media/settings', 'MediaController::settings');
```

## Database Migrations

Jalankan perintah berikut untuk membuat tabel:

```bash
php spark migrate
```

Atau buat migrations secara manual:

### Tabel: early_warnings
```sql
CREATE TABLE early_warnings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    type VARCHAR(50) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    severity VARCHAR(20),
    status VARCHAR(20) DEFAULT 'active',
    sent_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id)
);
```

### Tabel: notifications
```sql
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type VARCHAR(50),
    channel VARCHAR(50),
    recipient VARCHAR(255),
    subject VARCHAR(255),
    message LONGTEXT,
    is_sent BOOLEAN DEFAULT FALSE,
    sent_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

### Tabel: media
```sql
CREATE TABLE media (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type VARCHAR(50),
    filename VARCHAR(255) NOT NULL,
    original_filename VARCHAR(255),
    file_path VARCHAR(255),
    mime_type VARCHAR(100),
    file_size INT,
    width INT,
    height INT,
    aspect_ratio VARCHAR(50),
    description TEXT,
    is_public BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX idx_user_type (user_id, type)
);
```

## Struktur Direktori

```
app/
├── Controllers/
│   ├── AdminController.php (updated)
│   ├── GuruController.php (updated)
│   ├── EarlyWarningController.php (NEW)
│   └── MediaController.php (NEW)
├── Models/
│   ├── UserModel.php
│   ├── EarlyWarningModel.php (NEW)
│   ├── NotificationModel.php (NEW)
│   └── MediaModel.php (NEW)
├── Services/
│   ├── NotificationService.php (NEW)
│   ├── EmailNotificationService.php (NEW)
│   ├── WhatsAppNotificationService.php (NEW)
│   └── ImageUploadService.php (NEW)
└── Views/
    ├── guru/
    │   └── dashboard.php (updated)
    ├── admin/
    │   └── dashboard.php (updated)
    ├── early_warning/ (NEW)
    │   ├── dashboard.php
    │   └── create_warning.php
    └── media/ (NEW)
        ├── upload_form.php
        └── gallery.php

public/
└── uploads/
    └── media/ (untuk storage foto)
```

## Penggunaan

### 1. Upload Foto
1. Masuk sebagai user yang login
2. Klik "Upload Foto" di navbar
3. Drag & drop gambar atau klik untuk memilih
4. Pilih aspect ratio yang diinginkan
5. Pilih tipe foto
6. Tambah deskripsi (opsional)
7. Klik "Upload Foto"

### 2. Kelola Galeri
1. Buka `/media/gallery`
2. Lihat semua foto yang telah diupload
3. Filter berdasarkan tipe
4. Zoom/preview dengan click icon
5. Hapus foto yang tidak diinginkan

### 3. Buat Early Warning
1. Masuk sebagai admin
2. Buka `/early-warning/create`
3. Pilih siswa yang akan diberi warning
4. Tentukan tipe dan deskripsi warning
5. Atur tingkat keseriusan
6. Pilih channel notifikasi (email/WhatsApp)
7. Submit

### 4. View Early Warning Dashboard
1. Buka `/early-warning`
2. Lihat daftar warning aktif
3. Lihat statistik warning
4. Klik "Lihat" untuk detail
5. Klik "Selesai" untuk menandai resolved

## Security & Best Practices

1. **File Upload Security**
   - Validasi tipe file (MIME type)
   - Limit ukuran file (5MB)
   - Generate filename unik
   - Simpan di folder terpisah dari public

2. **Permission Check**
   - Verifikasi user ownership sebelum akses
   - Admin bypass untuk management

3. **API Keys**
   - Gunakan environment variables
   - Jangan commit `.env`

4. **Error Handling**
   - Try-catch di setiap service
   - User-friendly error messages

## Next Steps / Fitur Tambahan

1. **Batch Upload** - Upload multiple files sekaligus
2. **Image Editing** - Editor foto online
3. **Auto Warning** - Cek kehadiran/nilai otomatis
4. **Notification History** - Log semua notifikasi
5. **Advanced Filters** - Filter kompleks di gallery
6. **Performance Optimization** - CDN integration
7. **API Endpoint** - REST API untuk mobile app

## Troubleshooting

### Upload gagal: Permission denied
- Check folder permissions: `chmod 755 public/uploads/media/`

### WhatsApp tidak terkirim
- Verify credentials di `.env`
- Check WhatsApp Business Account status
- Verify phone number format

### Email tidak terkirim
- Test SMTP configuration
- Check spam folder
- Verify from email address

## Support & Documentation

- CodeIgniter 4: https://codeigniter.com
- Twilio: https://www.twilio.com/docs
- Image Manipulation: https://www.codeigniter.com/user_guide/libraries/images.html
