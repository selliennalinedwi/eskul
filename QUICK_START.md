# 🚀 Quick Start Guide

## Akses Cepat Fitur

### 1️⃣ Dashboard Guru
```
URL: http://localhost:8080/guru/dashboard
Role: guru
Fitur:
  ✅ Lihat statistik siswa dan ekskul
  ✅ Grafik distribusi siswa
  ✅ List siswa terbaru
  ✅ Jadwal mengajar hari ini
  ✅ Quick actions
```

### 2️⃣ Dashboard Admin
```
URL: http://localhost:8080/admin/dashboard
Role: admin
Fitur:
  ✅ Lihat statistik pendaftaran
  ✅ Status chart (pending/approved/rejected)
  ✅ Ekskul terpopuler
  ✅ Table pendaftaran pending
  ✅ Aksi verifikasi
```

### 3️⃣ Early Warning System
```
URL: http://localhost:8080/early-warning
Role: admin
Fitur:
  ✅ Dashboard peringatan dini
  ✅ Buat warning baru (/early-warning/create)
  ✅ Lihat detail warning (/early-warning/view/{id})
  ✅ Kirim notifikasi email & WhatsApp
  ✅ Tracking status warning
```

### 4️⃣ Media Gallery
```
URL: http://localhost:8080/media/gallery
Role: semua user yang login
Fitur:
  ✅ Galeri foto personal
  ✅ Filter by type (profile, product, logo, gallery)
  ✅ Upload foto baru (/media/upload)
  ✅ Lightbox preview
  ✅ Delete & visibility control
```

---

## 📝 Workflow Umum

### Workflow Admin
```
1. Login → Admin Dashboard
2. Lihat pendaftaran pending
3. Approve/Reject pendaftaran
4. Kelola ekskul (add/edit/delete)
5. Create early warning untuk siswa
6. Monitor dashboard
```

### Workflow Guru
```
1. Login → Guru Dashboard
2. Lihat siswa di ekskul saya
3. Catat kehadiran siswa
4. Kelola jadwal
5. Kirim pesan ke siswa
6. Review grafik siswa
```

### Workflow Upload Foto
```
1. Go to /media/upload
2. Drag & drop foto atau click browse
3. Pilih aspect ratio (Square/Portrait/Landscape/Story)
4. Pilih tipe foto (Profile/Product/Logo/Gallery)
5. (Opsional) Tambah deskripsi
6. Click "Upload Foto"
7. Lihat di /media/gallery
```

### Workflow Early Warning
```
1. Go to /early-warning/create
2. Pilih siswa dari dropdown
3. Tentukan tipe warning
4. Atur tingkat keseriusan
5. Isi deskripsi
6. Pilih channel notifikasi (email/WhatsApp)
7. Submit
8. Lihat di /early-warning dashboard
9. Klik "Selesai" untuk mark resolved
```

---

## 🔑 Login Credentials (Sample)

```
Admin:
Email: admin@example.com
Password: admin123
Role: admin

Guru:
Email: guru@example.com
Password: guru123
Role: guru

Siswa:
Email: siswa@example.com
Password: siswa123
Role: siswa
```

---

## 🛠️ Setup Cepat (5 Langkah)

```bash
# 1. Install dependencies
composer install

# 2. Copy .env
cp .env.example .env

# 3. Setup database di .env
# database.default.hostname = localhost
# database.default.database = ekskul_online
# database.default.username = root
# database.default.password = 

# 4. Run migrations
php spark migrate

# 5. Start server
php spark serve
```

---

## 📱 Browser Compatibility

✅ Chrome/Chromium (latest)
✅ Firefox (latest)
✅ Safari (latest)
✅ Edge (latest)
✅ Mobile browsers (iOS Safari, Chrome Mobile)

---

## 🐛 Common Issues & Solutions

### Issue: "Class not found"
```bash
Solution: composer dump-autoload
```

### Issue: "Upload folder permission denied"
```bash
Solution: chmod 755 public/uploads/media
```

### Issue: "Database connection error"
```
Check:
1. MySQL/MariaDB running?
2. .env database credentials correct?
3. Database exists?
```

### Issue: "Email/WhatsApp not sending"
```
Check:
1. SMTP config in .env
2. WhatsApp provider credentials
3. Check error logs in writable/logs/
```

---

## 📚 Documentation Files

1. **RINGKASAN_IMPLEMENTASI.md** (Comprehensive overview)
2. **SETUP_GUIDE.md** (Detailed setup instructions)
3. **DOKUMENTASI_FITUR.md** (Full feature documentation)

---

## ⚡ Performance Tips

1. Enable image compression in settings
2. Use CDN for media uploads
3. Clear logs periodically
4. Optimize database indexes
5. Use browser caching

---

## 🔐 Security Reminders

- ⚠️ Change default passwords
- ⚠️ Update .env with real credentials
- ⚠️ Set proper file permissions
- ⚠️ Use HTTPS in production
- ⚠️ Regular database backups

---

## 📞 Need Help?

1. Check the documentation files
2. Review error messages in browser console
3. Check application logs: `writable/logs/`
4. Verify configuration in `.env`

---

**Happy coding! 🎉**
