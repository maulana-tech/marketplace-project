# Panduan Instalasi dan Setup phpMyAdmin + Migrasi Database

## 1. Instalasi phpMyAdmin di XAMPP (macOS)

Anda sudah menggunakan XAMPP, jadi phpMyAdmin seharusnya sudah terinstall otomatis. Namun jika belum ada, ikuti langkah berikut:

### Opsi A: Menggunakan phpMyAdmin yang sudah ada di XAMPP
```bash
# Buka XAMPP Control Panel
/Applications/XAMPP/manager-osx

# Atau jalankan dari terminal
sudo /Applications/XAMPP/xamppfiles/xampp start
```

### Opsi B: Download phpMyAdmin Manual (jika tidak ada)
```bash
# Masuk ke direktori htdocs
cd /Applications/XAMPP/xamppfiles/htdocs

# Download phpMyAdmin versi terbaru
curl -O https://files.phpmyadmin.net/phpMyAdmin/5.2.1/phpMyAdmin-5.2.1-all-languages.zip

# Extract file
unzip phpMyAdmin-5.2.1-all-languages.zip

# Rename folder
mv phpMyAdmin-5.2.1-all-languages phpmyadmin
```

## 2. Konfigurasi phpMyAdmin

### Langkah 1: Setup File Konfigurasi
```bash
# Masuk ke direktori phpMyAdmin
cd /Applications/XAMPP/xamppfiles/htdocs/phpmyadmin

# Copy file konfigurasi
cp config.sample.inc.php config.inc.php
```

### Langkah 2: Edit Konfigurasi
Edit file `config.inc.php`:

```php
<?php
// Blowfish secret untuk cookie encryption
$cfg['blowfish_secret'] = 'your-32-character-random-string-here';

// Server configuration
$i = 0;

// First server
$i++;
$cfg['Servers'][$i]['auth_type'] = 'cookie';
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['extension'] = 'mysqli';

// Optional: Allow login without password (tidak direkomendasikan untuk production)
$cfg['Servers'][$i]['AllowNoPassword'] = true;

// Database for phpMyAdmin configuration storage
$cfg['Servers'][$i]['pmadb'] = 'phpmyadmin';
$cfg['Servers'][$i]['controluser'] = 'pma';
$cfg['Servers'][$i]['controlpass'] = 'pmapass';

// phpMyAdmin configuration storage settings
$cfg['Servers'][$i]['bookmarktable'] = 'pma__bookmark';
$cfg['Servers'][$i]['relation'] = 'pma__relation';
$cfg['Servers'][$i]['table_info'] = 'pma__table_info';
$cfg['Servers'][$i]['table_coords'] = 'pma__table_coords';
$cfg['Servers'][$i]['pdf_pages'] = 'pma__pdf_pages';
$cfg['Servers'][$i]['column_info'] = 'pma__column_info';
$cfg['Servers'][$i]['history'] = 'pma__history';
$cfg['Servers'][$i]['recent'] = 'pma__recent';
$cfg['Servers'][$i]['favorite'] = 'pma__favorite';
$cfg['Servers'][$i]['users'] = 'pma__users';
$cfg['Servers'][$i]['usergroups'] = 'pma__usergroups';
$cfg['Servers'][$i]['navigationhiding'] = 'pma__navigationhiding';
$cfg['Servers'][$i]['savedsearches'] = 'pma__savedsearches';
$cfg['Servers'][$i]['central_columns'] = 'pma__central_columns';
$cfg['Servers'][$i]['designer_settings'] = 'pma__designer_settings';
$cfg['Servers'][$i]['export_templates'] = 'pma__export_templates';

// Upload directory
$cfg['UploadDir'] = '';

// Save directory
$cfg['SaveDir'] = '';

// Increase timeout for large imports
$cfg['ExecTimeLimit'] = 300;
$cfg['MemoryLimit'] = '512M';
?>
```

## 3. Menjalankan XAMPP dan Akses phpMyAdmin

### Start Services
```bash
# Start Apache dan MySQL
sudo /Applications/XAMPP/xamppfiles/xampp start apache
sudo /Applications/XAMPP/xamppfiles/xampp start mysql

# Atau start semua services
sudo /Applications/XAMPP/xamppfiles/xampp start
```

### Akses phpMyAdmin
Buka browser dan kunjungi:
```
http://localhost/phpmyadmin
```

### Login Credentials
- **Username**: root
- **Password**: (kosong untuk default XAMPP)

## 4. Setup Database untuk Storage phpMyAdmin (Opsional)

Jalankan SQL berikut untuk membuat database dan tabel konfigurasi phpMyAdmin:

```sql
-- Buat database untuk phpMyAdmin
CREATE DATABASE phpmyadmin;

-- Buat user untuk phpMyAdmin
CREATE USER 'pma'@'localhost' IDENTIFIED BY 'pmapass';
GRANT ALL PRIVILEGES ON phpmyadmin.* TO 'pma'@'localhost';
FLUSH PRIVILEGES;
```

Kemudian import file SQL untuk tabel konfigurasi:
```bash
mysql -u root -p phpmyadmin < /Applications/XAMPP/xamppfiles/htdocs/phpmyadmin/sql/create_tables.sql
```

## 5. Migrasi Database

### A. Export Database dari Server Lama

#### Via phpMyAdmin (GUI):
1. Login ke phpMyAdmin server lama
2. Pilih database yang akan diexport
3. Klik tab "Export"
4. Pilih "Custom - display all possible options"
5. Format: SQL
6. Structure: ✓ Add CREATE DATABASE statement
7. Data: ✓ Complete inserts, ✓ Extended inserts
8. Klik "Go" untuk download file .sql

#### Via Command Line:
```bash
# Export single database
mysqldump -u username -p database_name > backup.sql

# Export multiple databases
mysqldump -u username -p --databases db1 db2 db3 > backup.sql

# Export semua databases
mysqldump -u username -p --all-databases > all_backup.sql

# Export dengan compression
mysqldump -u username -p database_name | gzip > backup.sql.gz
```

### B. Import Database ke Server Baru

#### Via phpMyAdmin (GUI):
1. Login ke phpMyAdmin server baru
2. Buat database baru (jika belum ada)
3. Pilih database tersebut
4. Klik tab "Import"
5. Pilih file .sql yang sudah diexport
6. Klik "Go"

#### Via Command Line:
```bash
# Import database
mysql -u username -p database_name < backup.sql

# Import dengan create database
mysql -u username -p < backup.sql

# Import compressed file
gunzip < backup.sql.gz | mysql -u username -p database_name
```

### C. Migrasi Data dengan phpMyAdmin

#### Untuk file besar (>50MB):
1. **Pecah file SQL**:
```bash
# Split file menjadi bagian 10MB
split -b 10m backup.sql backup_part_

# Atau gunakan tool khusus
mysqlsplit -s 10MB backup.sql
```

2. **Import bertahap**:
   - Import file per bagian
   - Monitor progress di phpMyAdmin

3. **Konfigurasi upload limit**:
Edit `/Applications/XAMPP/xamppfiles/etc/php.ini`:
```ini
upload_max_filesize = 200M
post_max_size = 200M
max_execution_time = 300
memory_limit = 512M
```

Restart Apache setelah edit:
```bash
sudo /Applications/XAMPP/xamppfiles/xampp restart apache
```

## 6. Verifikasi Migrasi

### Cek Data:
```sql
-- Cek jumlah tabel
SELECT COUNT(*) as table_count 
FROM information_schema.tables 
WHERE table_schema = 'your_database_name';

-- Cek jumlah record per tabel
SELECT 
    table_name,
    table_rows
FROM information_schema.tables 
WHERE table_schema = 'your_database_name';

-- Cek struktur tabel
DESCRIBE table_name;
```

### Test Aplikasi:
1. Update konfigurasi database di aplikasi
2. Test koneksi database
3. Test fungsionalitas utama
4. Cek log error

## 7. Troubleshooting

### Error "Cannot load mcrypt extension":
```bash
# Install mcrypt (jika perlu)
# Untuk PHP 7.2+, mcrypt sudah deprecated
# Gunakan sodium atau openssl sebagai gantinya
```

### Error "MySQL server has gone away":
Edit `/Applications/XAMPP/xamppfiles/etc/my.cnf`:
```ini
[mysqld]
max_allowed_packet = 500M
wait_timeout = 28800
interactive_timeout = 28800
```

### Error file upload terlalu besar:
Edit `php.ini` dan restart Apache:
```ini
upload_max_filesize = 500M
post_max_size = 500M
memory_limit = 1G
max_execution_time = 0
```

### Permisi folder:
```bash
# Set permission untuk phpMyAdmin
sudo chmod -R 755 /Applications/XAMPP/xamppfiles/htdocs/phpmyadmin
sudo chown -R daemon:daemon /Applications/XAMPP/xamppfiles/htdocs/phpmyadmin
```

## 8. Best Practices

### Keamanan:
1. **Ganti password default MySQL root**:
```sql
ALTER USER 'root'@'localhost' IDENTIFIED BY 'strong_password';
```

2. **Disable AllowNoPassword** di production:
```php
$cfg['Servers'][$i]['AllowNoPassword'] = false;
```

3. **Restrict access** dengan .htaccess:
```apache
<RequireAll>
    Require ip 127.0.0.1
    Require ip ::1
</RequireAll>
```

### Performance:
1. Enable query cache di MySQL
2. Optimize database tables regularly
3. Monitor slow queries
4. Use compression untuk backup besar

### Backup Regular:
```bash
# Setup cron job untuk backup otomatis
# Edit crontab
crontab -e

# Tambahkan baris untuk backup harian jam 2 pagi
0 2 * * * mysqldump -u root -p'password' --all-databases | gzip > /path/to/backup/mysql_backup_$(date +\%Y\%m\%d).sql.gz
```

## 9. Command Reference

### XAMPP Commands:
```bash
# Start/Stop services
sudo /Applications/XAMPP/xamppfiles/xampp start
sudo /Applications/XAMPP/xamppfiles/xampp stop
sudo /Applications/XAMPP/xamppfiles/xampp restart

# Start specific service
sudo /Applications/XAMPP/xamppfiles/xampp start apache
sudo /Applications/XAMPP/xamppfiles/xampp start mysql

# Check status
sudo /Applications/XAMPP/xamppfiles/xampp status
```

### MySQL Commands:
```bash
# Connect to MySQL
mysql -u root -p

# Show databases
SHOW DATABASES;

# Use database
USE database_name;

# Show tables
SHOW TABLES;

# Show table structure
DESCRIBE table_name;
```

Selamat! Anda sekarang memiliki panduan lengkap untuk setup phpMyAdmin dan migrasi database. Jika ada masalah atau pertanyaan, silakan tanyakan!
