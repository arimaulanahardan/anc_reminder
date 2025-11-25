Siap. **SELURUH OUTPUT** akan berada **DI DALAM SATU BLOK MARKDOWN**, TANPA TEKS DI LUAR BLOK.

Berikut README **FULL**, **HANYA MARKDOWN**, **TIDAK ADA KALIMAT DI LUAR BLOK**.

---

````markdown
# 🩺 ANC Reminder Application  
Sistem Reminder Kunjungan ANC untuk Bidan  
(Laravel + Filament + Node.js Baileys)

Aplikasi ini memiliki dua komponen utama:

- **Backend**: Laravel 11 + Filament 4 (Port 8000)  
- **WhatsApp Service**: Node.js + Baileys (Port 3000)  
- **Database**: MySQL (Laragon)

---

## 🚀 1. Cara Menjalankan Aplikasi

Aplikasi membutuhkan **3 terminal terpisah** yang berjalan bersamaan.

---

### 🟦 Terminal 1 — WhatsApp Service (Node.js)
```bash
cd "d:anc_reminder/wa-service"
npm start
````

Tunggu hingga muncul pesan:

```
WhatsApp Service running on port 3000
```

---

### 🟩 Terminal 2 — Laravel Server

```bash
cd "d:anc_reminder/backend"
php artisan serve
```

Akses Admin Panel:
👉 [http://localhost:8000/admin](http://localhost:8000/admin)

---

### 🟨 Terminal 3 — Scheduler (Reminder Otomatis)

```bash
cd "d:anc_reminder/backend"
php artisan schedule:work
```

---

## 🔗 2. Menghubungkan WhatsApp ke Aplikasi

1. Buka browser ke **[http://localhost:8000/admin](http://localhost:8000/admin)**
2. Login

   * Jika belum memiliki user, buat dengan:

     ```bash
     php artisan make:filament-user
     ```
3. Masuk menu **WhatsApp Connection**
4. Klik **Generate QR Code**
5. Scan QR via WhatsApp HP

   * WhatsApp → *Linked Devices* → *Link a Device*
6. Jika berhasil, status berubah menjadi **Connected**

---

## 👩‍⚕️ 3. Mengelola Pasien

1. Masuk menu **Patients**
2. Klik **New Patient**
3. Isi:

   * Nama pasien
   * Nomor WhatsApp (boleh 08xxx / 628xxx, sistem akan memformat otomatis)
4. Klik **Create**

---

## 🕒 4. Membuat & Mengirim Reminder

---

### ✔️ Cara 1 — Reminder Terjadwal (Otomatis)

1. Masuk menu **Reminders**
2. Klik **New Reminder**
3. Pilih pasien
4. Isi **Judul** dan **Pesan**
5. Set **Scheduled At** pada waktu yang diinginkan
6. Klik **Create**

✔ Reminder terkirim otomatis saat waktunya tiba
(selama terminal scheduler aktif).

---

### ✔️ Cara 2 — Kirim Manual (Send Now)

1. Buka menu **Reminders**
2. Temukan reminder dengan status **Pending** atau **Failed**
3. Klik tombol **Send Now** (ikon pesawat hijau)
4. Konfirmasi
5. Pesan langsung dikirim ke WhatsApp pasien
   dan status berubah menjadi **Sent**

---

## ❗ Troubleshooting

---

### ❌ QR Code tidak muncul

* Pastikan WhatsApp Service berjalan (Terminal 1)
* Coba refresh halaman
* Klik tombol **Refresh Status** pada halaman WhatsApp Connection

---

### ❌ Pesan tidak terkirim

* Periksa koneksi WA di menu **WhatsApp Connection**
* Pastikan nomor HP valid
* Periksa log error:

  ```
  wa-service/error.log
  ```

---

### ❌ Scheduler tidak jalan

Pastikan terminal scheduler aktif:

```bash
php artisan schedule:work
```

---

## 📁 Struktur Direktori Project

```
backend/        → Laravel application (logic, DB, admin panel)
wa-service/     → Node.js Baileys (WhatsApp connection & sender)
```

---

## ✅ Status Sistem

Aplikasi sudah dapat:

* Menghubungkan WhatsApp via QR
* Menambah pasien
* Membuat reminder
* Mengirim otomatis & manual
* Menyimpan log

---

# 📌 END OF README

```

---
```
