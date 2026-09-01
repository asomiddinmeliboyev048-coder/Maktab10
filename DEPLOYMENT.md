# Render Deploy Guide - Smart Maktab

## 🚀 Deployment Instructions

Bu fayl Maktab10 loyihasini Render'ga deploy qilish bo'yicha to'liq yo'riqnomasi.

### 1. Prerequisites (Zarur Asboblar)

- GitHub akkaunt va repo push qilish huquqi
- Render.com akkaunt (https://render.com)
- Environment variables tayyor (DATABASE_URL va boshqalar)

### 2. GitHub Preparation

Quyidagi fayllar push qilinganini tekshiring:

```bash
- docker-entrypoint.sh      # Database migration va seeding
- Dockerfile                # Docker image configuration
- render.yaml              # Render deployment config
- .env.example             # Environment template
- database/seeds/UsersTableSeeder.php  # Default users
- database/seeds/DatabaseSeeder.php    # Seeder runner
```

### 3. Render Setup

#### Step 1: New Web Service

1. Render dashboard'ga kiring: https://dashboard.render.com
2. **"New +"** → **"Web Service"** bosing
3. GitHub repository'ni tanlang
4. Quyidagi sozlamalarni kiriting:

```
Name: maktab10-app
Environment: Docker
Region: Ohio (yoki sizning zonangiz)
Plan: Free (yoki Pro)
```

#### Step 2: Environment Variables

Render'da quyidagi environment variables'ni o'rnatish:

```env
APP_NAME=Smart Maktab
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:GENERATED_KEY_HERE  # php artisan key:generate orqali generate qiling
APP_URL=https://your-app-name.onrender.com

# Database (Render'dan auto-generate qilinadi)
DATABASE_URL=mysql://user:password@hostname:3306/database

# Other settings
MAIL_MAILER=log
SESSION_DRIVER=file
CACHE_DRIVER=file
```

#### Step 3: Database Service

1. Render dashboard'da **"New +"** → **"MySQL"** bosing
2. Quyidagi sozlamalarni o'rnatish:
   - **Name**: maktab10-db
   - **Database**: maktab10
   - **Region**: Ohio
   - **Plan**: Free

3. Database create qilgandan so'ng, `DATABASE_URL` ni Web Service'ing environment variables'ga qo'shish.

### 4. Application KEY Generation

Agar `APP_KEY` noma'lum bo'lsa, mahalliy generatsiya qiling:

```bash
# Mahalliyda
composer install
php artisan key:generate

# .env faylidan base64: bilan boshlangan qiymatni nusxa oling
cat .env | grep APP_KEY
```

Keyin Render environment variables'da o'rnatish.

### 5. What Happens on Deploy

Render deploy qilganda quyidagi bosqichlar avtomatik bajariladi (docker-entrypoint.sh):

1. ✅ **Cache Clear** - Config va route cache tozalanadi
2. ✅ **Migrations Run** - Database jadvallari yaratiladi
3. ✅ **Database Seeding** - Default direktor va permissions yaratiladi
4. ✅ **Apache Start** - Web server ishga tushadi

### 6. First Login

Deploy qilgandan so'ng:

```
Email:    director@school.uz
Password: Director123!
```

**MUHIM**: Birinchi login qilgach, parolni o'zgartiring!

### 7. Troubleshooting

#### ❌ "Email yoki parol noto'g'ri" xatosi

**Sabab**: Database seeder ishlamadi

**Yechim**:
1. Render dashboard'da Web Service'ing logs'ni tekshiring
2. Environment `DATABASE_URL` to'g'ri o'rnatilganini tekshiring
3. Manual seed qilish:
   ```bash
   # Render CLI orqali
   render run php artisan db:seed --force
   ```

#### ❌ "500 Internal Server Error"

**Sabab**: APP_KEY yo'q yoki database connection noto'g'ri

**Yechim**:
1. APP_KEY o'rnatilganini tekshiring (base64: bilan boshlashi kerak)
2. DATABASE_URL to'g'ri format: `mysql://user:pass@host:3306/db`

#### ❌ Migrations failed

**Yechim**:
1. Render MySQL service'ing status'ni tekshiring
2. database/migrations papkasida fayllar tuzilishi
3. Manual migrations qilish:
   ```bash
   render run php artisan migrate --force
   ```

### 8. Security Tips

⚠️ **PRODUCTION-DA QUYIDAGILAR MUHIM**:

1. **APP_DEBUG=false** qiling (hech qachon true bo'lmasi)
2. Parolingizni o'zgartiring (director@school.uz)
3. HTTPS ishlatish (Render avtomatik qiladi)
4. Database backups oling
5. Regular logs tekshiring

### 9. Monitoring & Logs

Logs ko'rish:

```bash
# Render dashboard → maktab10-app → Logs
```

Key errors:

- `SQLSTATE[HY000]` - Database connection error
- `Class not found` - Composer dependencies missing
- `Permission denied` - File system permissions

### 10. Common Commands (Render CLI)

Agar Render CLI o'rnatilgan bo'lsa:

```bash
# Manual migration
render run php artisan migrate --force

# Manual seeding
render run php artisan db:seed --force

# Cache clear
render run php artisan cache:clear

# Logs
render logs --service maktab10-app
```

---

## 📚 Qo'shimcha Havolalar

- [Render Documentation](https://render.com/docs)
- [Laravel Docker Deployment](https://laravel.com/docs/installation#docker)
- [MySQL Connection Troubleshooting](https://dev.mysql.com/doc/refman/8.0/en/connecting.html)

---

**✨ Tayyorlangan**: 2026-01-01
**Versiya**: 1.0
