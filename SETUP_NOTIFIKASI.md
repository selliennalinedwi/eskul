# 📧 SETUP NOTIFIKASI EMAIL & 📱 WHATSAPP

Panduan lengkap untuk setup sistem notifikasi (Email dan WhatsApp) di Ekskul Online.

---

## 1️⃣ KONFIGURASI EMAIL SMTP

### Opsi A: Menggunakan Gmail (Rekomendasi untuk Testing)

#### Step 1: Buat App Password Gmail
1. Login ke akun Google Anda: https://myaccount.google.com
2. Buka "Security" → "App passwords"
3. Pilih "Mail" dan "Windows Computer"
4. Salin password yang ditampilkan (16 karakter)

#### Step 2: Update .env file
Tambahkan konfigurasi di file `env` (atau buat `.env` dari copy `env`):

```plaintext
email.protocol = smtp
email.SMTPHost = smtp.gmail.com
email.SMTPUser = your-email@gmail.com
email.SMTPPass = xxxx-xxxx-xxxx-xxxx
email.SMTPPort = 587
email.SMTPCrypto = tls
```

**Contoh Lengkap .env:**
```plaintext
CI_ENVIRONMENT = production

app.baseURL = 'http://localhost:8080'

database.default.hostname = localhost
database.default.database = ci4_ekskul
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
database.default.port = 3306

email.protocol = smtp
email.SMTPHost = smtp.gmail.com
email.SMTPUser = your-email@gmail.com
email.SMTPPass = xxxx-xxxx-xxxx-xxxx
email.SMTPPort = 587
email.SMTPCrypto = tls
```

### Opsi B: Menggunakan Hostinger/Hosting Provider

```plaintext
email.protocol = smtp
email.SMTPHost = mail.yourdomain.com
email.SMTPUser = admin@yourdomain.com
email.SMTPPass = your-password
email.SMTPPort = 587
email.SMTPCrypto = tls
```

### Opsi C: Menggunakan SendGrid

```plaintext
email.protocol = smtp
email.SMTPHost = smtp.sendgrid.net
email.SMTPUser = apikey
email.SMTPPass = SG.xxxxxxxxxxxx
email.SMTPPort = 587
email.SMTPCrypto = tls
```

---

## 2️⃣ KONFIGURASI WHATSAPP NOTIFICATION

Pilih salah satu provider dari 3 opsi berikut:

### Opsi A: Twilio (Paling Reliable)

#### Step 1: Buat Akun Twilio
1. Daftar di https://www.twilio.com/console
2. Verify nomor telepon Anda
3. Dapatkan Twilio WhatsApp Number
4. Copy Account SID dan Auth Token

#### Step 2: Update .env
```plaintext
whatsapp.provider = twilio
whatsapp.twilio.account_sid = ACxxxxxxxxxxxxxxxx
whatsapp.twilio.auth_token = xxxxxxxxxxxxxxxx
whatsapp.twilio.from_number = +1234567890
```

---

### Opsi B: Green API (Terjangkau untuk ID)

#### Step 1: Buat Akun Green API
1. Daftar di https://green-api.com
2. Hubungkan WhatsApp Business Anda
3. Copy Instance ID dan Token

#### Step 2: Update .env
```plaintext
whatsapp.provider = greenapi
whatsapp.greenapi.instance_id = 1101234567
whatsapp.greenapi.access_token = d75xxxxxxxxxxxxxx
```

---

### Opsi C: Fonnte (Populer di Indonesia)

#### Step 1: Buat Akun Fonnte
1. Daftar di https://fonnte.com
2. Hubungkan device/WhatsApp Anda
3. Copy Device ID dan API Token

#### Step 2: Update .env
```plaintext
whatsapp.provider = fonnte
whatsapp.fonnte.device_id = 12345678
whatsapp.fonnte.api_token = xxxxxxxxxxxx
```

---

## 3️⃣ TEST NOTIFIKASI

### Test Email

1. Login ke aplikasi
2. Buka `/profile/settings`
3. Input email notifikasi Anda
4. Klik tombol **"Test"** di bagian Email
5. Cek inbox email Anda

**Jika gagal:**
- Check logs: `writable/logs/log-2025-12-02.log`
- Verifikasi SMTP credentials di `.env`
- Pastikan port 587 atau 465 terbuka (jika di server)

### Test WhatsApp

1. Login ke aplikasi
2. Buka `/profile/settings`
3. Input nomor WhatsApp dengan format: `62XXXXXXXXXX`
   - Contoh: `6285123456789`
4. Klik tombol **"Test"** di bagian WhatsApp
5. Cek WhatsApp Anda

**Jika gagal:**
- Verifikasi nomor WhatsApp format (harus dengan kode negara 62)
- Check logs: `writable/logs/log-2025-12-02.log`
- Pastikan WhatsApp provider credentials di `.env` benar

---

## 4️⃣ MENGGUNAKAN NOTIFIKASI DI EARLY WARNING

Setelah email dan WhatsApp ter-setup:

1. Login sebagai Admin/Guru
2. Buka menu **"Early Warning"** → **"Buat Warning Baru"**
3. Pilih siswa dari dropdown
4. Isi informasi warning (tipe, judul, deskripsi, severity)
5. Di bagian **"Opsi Notifikasi":**
   - ✅ Centang "Kirim notifikasi ke siswa/orang tua"
   - ✅ Centang "Email" (jika email siswa/orang tua tersedia)
   - ✅ Centang "WhatsApp" (jika nomor WhatsApp tersedia)
6. Klik **"Buat Warning"**

Notifikasi akan otomatis terkirim ke email dan WhatsApp siswa/orang tua!

---

## 5️⃣ TROUBLESHOOTING

### Email Tidak Terkirim

**Error: "SMTP connection refused"**
- Port SMTP tidak sesuai (gunakan 587 untuk TLS, 465 untuk SSL)
- Firewall/ISP memblokir port
- SMTP credentials salah

**Error: "Authentication failed"**
- Password salah atau expired
- Gmail: pastikan menggunakan App Password (bukan password akun)
- SendGrid: gunakan "apikey" sebagai username

**Error: "Email berhasil dikirim tapi tidak diterima"**
- Email masuk ke spam folder
- Domain belum ter-verify
- SPF/DKIM belum dikonfigurasi di DNS

### WhatsApp Tidak Terkirim

**Error: "Invalid phone number"**
- Format harus `62XXXXXXXXXX` (tanpa 0 di awal)
- Pastikan kode negara 62 (Indonesia)
- Contoh benar: `6285123456789`

**Error: "Provider API error"**
- Credentials di `.env` tidak cocok
- API quota sudah habis
- Device WhatsApp belum terhubung ke provider

**Error: "Timeout"**
- Provider API down (cek status provider)
- Koneksi internet lambat
- Coba ulangi dalam beberapa menit

---

## 6️⃣ KONFIGURASI DATABASE UNTUK RECIPIENTS

Setiap user memiliki field untuk notifikasi:

```sql
SELECT id, username, email, phone_number, notification_email 
FROM users 
WHERE id = 1;
```

- `email` - Email utama akun
- `phone_number` - Nomor WhatsApp (format: 62XXXXXXXXXX)
- `notification_email` - Email alternatif untuk notifikasi (opsional)

User bisa update data mereka sendiri di `/profile/settings`

---

## 7️⃣ FITUR BULK NOTIFICATION

Untuk mengirim notifikasi ke multiple users:

```php
$phoneNumbers = ['6285123456789', '6282234567890'];
$this->notificationService->sendWhatsAppBulk($phoneNumbers, $message);
```

---

## 📋 CHECKLIST SETUP

- [ ] Update `.env` dengan SMTP credentials
- [ ] Update `.env` dengan WhatsApp provider credentials
- [ ] Test Email via `/profile/settings`
- [ ] Test WhatsApp via `/profile/settings`
- [ ] Update nomor WhatsApp & email di profil user
- [ ] Buat Early Warning dan pastikan notifikasi terkirim
- [ ] Monitor logs untuk error: `writable/logs/`

---

## 📞 SUPPORT

Jika masih bermasalah:

1. Check `writable/logs/log-YYYY-MM-DD.log` untuk error messages
2. Verify credentials di `.env`
3. Test manual SMTP connection dengan telnet
4. Contact WhatsApp provider support

---

**Setup selesai!** 🎉 Notifikasi Anda sudah siap digunakan.
