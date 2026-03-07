# 🔐 VulnWeb - IntraCorp Portal

⚠️ **PERINGATAN:** Aplikasi ini sengaja dibuat vulnerable untuk keperluan **security training & penetration testing**.
**JANGAN deploy ke production!**

---

## 🚀 Quick Setup

### 1. **Import Database**

```bash
# Import schema dan data sample
mysql -u root -p < database/intracorp_portal.sql
```

Atau via phpMyAdmin:

- Buat database baru (nama bebas)
- Import file `database/intracorp_portal.sql`

### 2. **Konfigurasi Database**

Edit file `.env` (atau langsung di `config/db_config.php`):

```
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=intracorp_portal
```

### 3. **Jalankan Server**

```bash
php -S 0.0.0.0:8000 -t public
```

Akses: http://localhost:8000

---

## 🔑 Default Login

**Admin:**

- Email: `admin@intracorp.local`
- Password: `admin123`

**Employee:**

- Email: `john.doe@intracorp.local`
- Password: `employee123`

---

## 📁 Struktur Project

```
app/
  Controllers/    # Request handlers
  Models/         # Database operations
  Views/          # UI templates
  Core/           # Framework core (Router, BaseController)
config/
  db_config.php   # Database configuration
database/
  intracorp_portal.sql  # Master schema + sample data
public/
  index.php       # Entry point
  assets/         # CSS & JS
```

---

## ⚠️ Vulnerabilities (Intentional)

Aplikasi ini mengandung vulnerability berikut untuk tujuan edukasi:

- ❌ **SQL Injection** - No prepared statements
- ❌ **XSS** - No output sanitization
- ❌ **IDOR** - Insecure direct object references
- ❌ **Weak Authentication** - Plain text passwords
- ❌ **File Upload Vulnerability** - No validation
- ❌ **CSRF** - No token protection
- ❌ **Information Disclosure** - Error messages exposed

**Gunakan untuk belajar security testing!**

---

## 📚 Fitur

### Admin Panel

- ✅ User management
- ✅ Announcements
- ✅ IT Support tickets
- ✅ File uploads (BLOB storage)

### Employee Dashboard

- ✅ View announcements
- ✅ Submit tickets
- ✅ Profile management
- ✅ File attachments

---

## 🛠️ Teknologi

- PHP 7.4+ (Native, no framework)
- MySQL 5.7+
- Bootstrap 5
- Custom MVC architecture

---

**Build for Security Training | © 2026**
