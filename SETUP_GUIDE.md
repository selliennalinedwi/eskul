# Setup & Installation Guide

## Prerequisites
- PHP 7.4+
- Composer
- MySQL/MariaDB
- GD Library (untuk image processing)

## Setup Instructions

### 1. Install Dependencies

```bash
composer install
```

### 2. Configuration

Buat file `.env` dari `.env.example`:

```bash
cp .env.example .env
```

Edit `.env` dan sesuaikan konfigurasi:

```env
# Database Configuration
database.default.hostname = localhost
database.default.database = ekskul_online
database.default.username = root
database.default.password = 

# Email Configuration (untuk Early Warning System)
email.protocol = smtp
email.SMTPHost = smtp.gmail.com
email.SMTPPort = 587
email.SMTPUser = your-email@gmail.com
email.SMTPPass = your-app-password
email.SMTPCrypto = tls
email.mailType = html

# WhatsApp Configuration (Pilih salah satu provider)

# Option 1: Twilio
WHATSAPP_PROVIDER = twilio
WHATSAPP_ACCOUNT_SID = your_account_sid
WHATSAPP_AUTH_TOKEN = your_auth_token
WHATSAPP_PHONE_NUMBER = +1234567890

# Option 2: Green API
WHATSAPP_PROVIDER = green_api
WHATSAPP_INSTANCE_ID = your_instance_id
WHATSAPP_INSTANCE_KEY = your_instance_key

# Option 3: Fonnte
WHATSAPP_PROVIDER = fonnte
WHATSAPP_FONNTE_TOKEN = your_fonnte_token

# App Configuration
app.baseURL = http://localhost:8080
app.timezone = Asia/Jakarta
```

### 3. Database Setup

```bash
# Jalankan migrations
php spark migrate

# (Opsional) Jalankan seeders
php spark db:seed SampleSeeder
```

### 4. Create Upload Directory

```bash
mkdir -p public/uploads/media
chmod 755 public/uploads/media
```

### 5. Start Development Server

```bash
php spark serve
```

Server akan berjalan di http://localhost:8080

## Testing

### Akses Dashboard

1. **Admin Dashboard**: http://localhost:8080/admin/dashboard
   - Email: admin@example.com
   - Password: admin123

2. **Guru Dashboard**: http://localhost:8080/guru/dashboard
   - Email: guru@example.com
   - Password: guru123

3. **Early Warning**: http://localhost:8080/early-warning
   - Hanya untuk admin

4. **Media Gallery**: http://localhost:8080/media/gallery
   - Accessible untuk semua user yang login

## File Structure

```
app/
├── Config/
│   └── Routes.php (diupdate dengan routes baru)
├── Controllers/
│   ├── AdminController.php (diupdate)
│   ├── GuruController.php (diupdate)
│   ├── AuthController.php
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
├── Views/
│   ├── guru/dashboard.php (updated)
│   ├── admin/dashboard.php (updated)
│   ├── early_warning/ (NEW)
│   └── media/ (NEW)
└── Database/
    └── Migrations/ (untuk create tables)

public/
├── uploads/
│   └── media/ (untuk storage foto)
└── assets/
    └── ... (existing assets)
```

## Fitur yang Sudah Diimplementasikan

### ✅ Dashboard Guru
- Professional UI dengan sidebar navigasi
- Statistik siswa dan ekskul
- Grafik distribusi siswa
- List siswa terbaru
- Quick actions
- Jadwal hari ini

### ✅ Dashboard Admin
- Professional UI dengan color scheme
- Statistik pendaftaran (pending/approved/rejected)
- Pie chart status
- Daftar ekskul terpopuler
- Quick actions
- Tabel pendaftaran pending

### ✅ Multi-Level Login
- Session-based authentication
- Role-based redirects
- Logout functionality

### ✅ Early Warning System
- Create warning manually
- Dashboard dengan statistik
- Email & WhatsApp notifications
- Multiple notification channels
- Warning tracking & resolution

### ✅ Media Upload (Instagram-like)
- Drag & drop upload
- Multiple aspect ratios (Square, Portrait, Landscape, Story)
- Auto crop & resize
- Thumbnail generation
- File compression
- Galeri dengan filters
- Visibility control (public/private)
- AJAX upload support

## Troubleshooting

### Error: "Class not found"
- Jalankan: `composer dump-autoload`

### Permission Denied pada uploads
```bash
sudo chmod -R 755 public/uploads/
sudo chown -R www-data:www-data public/uploads/
```

### Database Connection Error
- Verifikasi `.env` database credentials
- Pastikan MySQL/MariaDB running
- Create database terlebih dahulu

### Email tidak terkirim
- Verifikasi SMTP credentials
- Untuk Gmail, gunakan App Password (bukan password regular)
- Check firewall/ISP blocking port 587

### WhatsApp tidak terkirim
- Verifikasi provider credentials
- Check phone number format (gunakan +62 untuk Indonesia)
- Verify WhatsApp Business Account status

## API Documentation

### Early Warning Endpoints

```
GET  /early-warning                      - Dashboard
GET  /early-warning/create               - Form create
POST /early-warning/store                - Save warning
GET  /early-warning/view/{id}            - View detail
GET  /early-warning/resolve/{id}         - Mark resolved
GET  /early-warning/send-notifications   - Send pending
```

### Media Endpoints

```
GET  /media/gallery                      - View gallery
GET  /media/upload                       - Upload form
POST /media/upload                       - Save file
POST /media/upload-ajax                  - AJAX upload
GET  /media/view/{id}                    - View photo
GET  /media/delete/{id}                  - Delete photo
POST /media/visibility/{id}              - Toggle visibility
GET  /media/settings                     - Admin settings
```

## Performance Tips

1. **Compress Images**: Aktifkan image compression di ImageUploadService
2. **Use CDN**: Upload media ke CDN provider
3. **Database Indexing**: Tambah index untuk column yang sering diquery
4. **Caching**: Implementasi caching untuk dashboard stats

## Security Checklist

- [ ] Set strong database password
- [ ] Use HTTPS in production
- [ ] Update environment variables
- [ ] Set proper file permissions
- [ ] Validate all user inputs
- [ ] Use CSRF tokens (already enabled)
- [ ] Set secure session cookies
- [ ] Regular backup database

## Production Deployment

1. Set `CI_ENVIRONMENT = production` di `.env`
2. Disable error display: `display_errors = false`
3. Enable HTTPS
4. Set proper file permissions
5. Use environment-specific database
6. Setup email properly
7. Configure WhatsApp production credentials
8. Monitor logs regularly

## Support

Untuk support atau pertanyaan, hubungi tim development.
