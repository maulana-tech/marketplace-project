# Panduan Lengkap Setup Development Environment Laravel + XAMPP + phpMyAdmin (Windows)

## Prerequisites & Tools Installation untuk Windows

### 1. Install XAMPP untuk Windows
```powershell
# Download XAMPP dari https://www.apachefriends.org/download.html
# Install ke C:\xampp (default location)

# Cek instalasi
C:\xampp\xampp-control.exe

# Start services via command line
C:\xampp\xampp_start.exe

# Atau gunakan XAMPP Control Panel
```

### 2. Install Git untuk Windows
```powershell
# Download dari https://git-scm.com/download/win
# Atau install via Chocolatey
choco install git

# Konfigurasi Git
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"

# Cek versi
git --version
```

### 3. Install PHP (sudah ada di XAMPP, tapi perlu untuk Composer)
```powershell
# Tambahkan PHP ke PATH
# Buka System Properties > Environment Variables
# Edit PATH, tambahkan: C:\xampp\php

# Atau via PowerShell (sebagai Administrator)
[Environment]::SetEnvironmentVariable("Path", $env:Path + ";C:\xampp\php", [EnvironmentVariableTarget]::Machine)

# Cek versi PHP
php --version

# Enable extensions di php.ini jika perlu
# Edit C:\xampp\php\php.ini
# Uncomment: extension=curl, extension=openssl, extension=mbstring
```

### 4. Install Composer
```powershell
# Download Composer-Setup.exe dari https://getcomposer.org/download/
# Atau install via PowerShell

# Download installer
Invoke-WebRequest -Uri "https://getcomposer.org/installer" -OutFile "composer-setup.php"

# Install Composer
php composer-setup.php --install-dir=C:\composer --filename=composer.exe

# Tambahkan ke PATH
[Environment]::SetEnvironmentVariable("Path", $env:Path + ";C:\composer", [EnvironmentVariableTarget]::Machine)

# Restart PowerShell dan cek
composer --version
```

### 5. Install Node.js & NPM
```powershell
# Download dari https://nodejs.org/
# Atau install via Chocolatey
choco install nodejs

# Atau via Winget
winget install OpenJS.NodeJS

# Cek versi
node --version
npm --version

# Update npm ke versi terbaru
npm install -g npm@latest
```

### 6. Install Laravel Installer
```powershell
# Install Laravel installer global
composer global require laravel/installer

# Tambahkan Composer global bin ke PATH
# Default location: C:\Users\%USERNAME%\AppData\Roaming\Composer\vendor\bin
[Environment]::SetEnvironmentVariable("Path", $env:Path + ";$env:APPDATA\Composer\vendor\bin", [EnvironmentVariableTarget]::User)

# Restart PowerShell dan cek
laravel --version
```

### 7. Install Code Editor (Optional)
```powershell
# Install Visual Studio Code
choco install vscode

# Atau download dari https://code.visualstudio.com/

# Install PHP extension untuk VS Code
# - PHP Extension Pack
# - Laravel Extension Pack
```

## Laravel Project Setup (Windows)

### 1. Create New Laravel Project
```powershell
# Masuk ke direktori htdocs XAMPP
cd C:\xampp\htdocs

# Create project baru
laravel new marketplace-project
# Atau
composer create-project laravel/laravel marketplace-project

# Masuk ke direktori project
cd marketplace-project
```

### 2. Project Configuration
```powershell
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate

# Set permissions (Windows biasanya tidak perlu chmod, tapi pastikan folder writable)
# Klik kanan folder storage dan bootstrap/cache > Properties > Security
# Atau via PowerShell (sebagai Administrator)
icacls "storage" /grant "Users:(OI)(CI)F" /T
icacls "bootstrap\cache" /grant "Users:(OI)(CI)F" /T
```

### 3. Database Configuration
Edit file `.env`:
```env
APP_NAME="Marketplace Project"
APP_ENV=local
APP_KEY=base64:your-generated-key
APP_DEBUG=true
APP_URL=http://localhost/marketplace-project

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=marketplace_db
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

## Database Setup & Migration (Windows)

### 1. Start XAMPP Services
```powershell
# Buka XAMPP Control Panel
C:\xampp\xampp-control.exe

# Atau via command line
C:\xampp\xampp_start.exe

# Start specific services
C:\xampp\apache_start.bat
C:\xampp\mysql_start.bat
```

### 2. Setup MySQL Database
```powershell
# Connect to MySQL via command line
C:\xampp\mysql\bin\mysql.exe -u root -p

# Atau gunakan MySQL Command Line Client dari Start Menu
```

```sql
-- Create database
CREATE DATABASE marketplace_db;

-- Create user (optional, untuk keamanan)
CREATE USER 'marketplace_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON marketplace_db.* TO 'marketplace_user'@'localhost';
FLUSH PRIVILEGES;

-- Exit MySQL
EXIT;
```

### 3. Run Laravel Migrations
```powershell
# Test database connection
php artisan migrate:status

# Run migrations
php artisan migrate

# Seed database (jika ada)
php artisan db:seed

# Atau migrate dengan seed sekaligus
php artisan migrate --seed

# Refresh migrations (hapus dan create ulang)
php artisan migrate:refresh --seed
```

### 4. Create Custom Migrations
```powershell
# Create migration for products table
php artisan make:migration create_products_table

# Create migration for categories table
php artisan make:migration create_categories_table

# Create migration dengan foreign key
php artisan make:migration add_category_id_to_products_table

# Create model dengan migration
php artisan make:model Product -m

# Create model dengan migration, factory, dan seeder
php artisan make:model Category -mfs
```

### 5. Example Migration File
Create file migration (contoh: `database\migrations\create_products_table.php`):
```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('image')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
```

## Frontend Setup (Node.js & NPM) untuk Windows

### 1. Install Dependencies
```powershell
# Install NPM dependencies
npm install

# Install additional packages untuk UI
npm install bootstrap jquery popper.js
npm install @fortawesome/fontawesome-free
npm install sweetalert2
npm install datatables.net-bs5

# Install development dependencies
npm install --save-dev sass
npm install --save-dev @vitejs/plugin-vue
npm install --save-dev alpinejs
```

### 2. Configure Vite
Edit `vite.config.js`:
```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '127.0.0.1',
        port: 5173,
        hmr: {
            host: 'localhost',
        },
    },
});
```

### 3. Build Assets
```powershell
# Development build
npm run dev

# Production build
npm run build

# Watch for changes (development)
npm run dev -- --watch

# Hot reload (development server)
npm run dev -- --host
```

### 4. Setup Bootstrap & CSS
Edit `resources\css\app.css`:
```css
@import 'bootstrap/dist/css/bootstrap.min.css';
@import '@fortawesome/fontawesome-free/css/all.min.css';

/* Custom styles */
body {
    font-family: 'Nunito', sans-serif;
}

.navbar-brand {
    font-weight: bold;
}

.product-card {
    transition: transform 0.2s;
}

.product-card:hover {
    transform: translateY(-5px);
}
```

Edit `resources\js\app.js`:
```javascript
import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import Swal from 'sweetalert2';

// Make SweetAlert available globally
window.Swal = Swal;

// Custom JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Your custom code here
    console.log('Laravel app loaded successfully!');
});
```

## Laravel Artisan Commands (Windows)

### 1. Essential Artisan Commands
```powershell
# Generate application key
php artisan key:generate

# Clear all caches
php artisan optimize:clear

# Clear specific caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Create symbolic link for storage
php artisan storage:link

# Check routes
php artisan route:list

# Check config
php artisan config:show database
```

### 2. Create Controllers
```powershell
# Basic controller
php artisan make:controller ProductController

# Resource controller (with CRUD methods)
php artisan make:controller ProductController --resource

# API resource controller
php artisan make:controller Api\ProductController --api

# Controller with model
php artisan make:controller ProductController --model=Product
```

### 3. Create Models & Related Files
```powershell
# Model only
php artisan make:model Product

# Model with migration
php artisan make:model Product -m

# Model with migration, factory, seeder
php artisan make:model Product -mfs

# Model with all (migration, factory, seeder, controller, policy)
php artisan make:model Product -a
```

### 4. Create Middleware
```powershell
# Create middleware
php artisan make:middleware CheckAge

# Create middleware untuk admin
php artisan make:middleware AdminMiddleware
```

### 5. Create Requests (Form Validation)
```powershell
# Create form request
php artisan make:request StoreProductRequest
php artisan make:request UpdateProductRequest
```

### 6. Create Seeders & Factories
```powershell
# Create seeder
php artisan make:seeder ProductSeeder

# Create factory
php artisan make:factory ProductFactory

# Run specific seeder
php artisan db:seed --class=ProductSeeder
```

### 7. Queue & Jobs
```powershell
# Create job
php artisan make:job ProcessProductImage

# Run queue worker
php artisan queue:work

# Create notification
php artisan make:notification OrderPlaced
```

## phpMyAdmin Setup & Configuration (Windows)

### 1. Access phpMyAdmin
```powershell
# Start XAMPP Control Panel
C:\xampp\xampp-control.exe

# Start Apache dan MySQL
# Klik Start pada Apache dan MySQL

# Access via browser
start http://localhost/phpmyadmin
```

### 2. phpMyAdmin Configuration
Create/edit `C:\xampp\phpMyAdmin\config.inc.php`:
```php
<?php
$cfg['blowfish_secret'] = 'marketplace-secret-key-32chars!';

$i = 0;
$i++;
$cfg['Servers'][$i]['auth_type'] = 'cookie';
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['connect_type'] = 'tcp';
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['extension'] = 'mysqli';
$cfg['Servers'][$i]['AllowNoPassword'] = true;

// Increase limits untuk file besar
$cfg['ExecTimeLimit'] = 600;
$cfg['MemoryLimit'] = '1024M';
$cfg['UploadDir'] = 'C:/xampp/phpMyAdmin/upload';
$cfg['SaveDir'] = 'C:/xampp/phpMyAdmin/save';

// Enable compression
$cfg['ZipDump'] = true;
$cfg['GZipDump'] = true;
?>
```

### 3. Increase PHP Limits
Edit `C:\xampp\php\php.ini`:
```ini
; File upload limits
upload_max_filesize = 500M
post_max_size = 500M
max_input_time = 300
max_execution_time = 300
memory_limit = 1024M

; MySQL settings
mysql.default_host = localhost
mysql.default_user = root
mysql.default_password = 

; MySQLi settings
mysqli.default_host = localhost
mysqli.default_user = root
mysqli.default_password = 

; Enable extensions
extension=curl
extension=openssl
extension=mbstring
extension=mysqli
extension=pdo_mysql
```

Restart Apache setelah edit:
```powershell
# Via XAMPP Control Panel: Stop dan Start Apache
# Atau via command line
C:\xampp\apache_stop.bat
C:\xampp\apache_start.bat
```

## Database Migration & Import/Export (Windows)

### 1. Export Database
```powershell
# Export via mysqldump
C:\xampp\mysql\bin\mysqldump.exe -u root -p marketplace_db > marketplace_backup.sql

# Export dengan struktur dan data
C:\xampp\mysql\bin\mysqldump.exe -u root -p --single-transaction --routines --triggers marketplace_db > marketplace_full_backup.sql

# Export multiple databases
C:\xampp\mysql\bin\mysqldump.exe -u root -p --databases marketplace_db test_db > multiple_backup.sql

# Export dengan compression (menggunakan 7zip)
C:\xampp\mysql\bin\mysqldump.exe -u root -p marketplace_db | "C:\Program Files\7-Zip\7z.exe" a -si marketplace_backup.sql.7z
```

### 2. Import Database
```powershell
# Import via mysql command
C:\xampp\mysql\bin\mysql.exe -u root -p marketplace_db < marketplace_backup.sql

# Import dengan create database
C:\xampp\mysql\bin\mysql.exe -u root -p < marketplace_full_backup.sql

# Import compressed file (7zip)
"C:\Program Files\7-Zip\7z.exe" x marketplace_backup.sql.7z -so | C:\xampp\mysql\bin\mysql.exe -u root -p marketplace_db
```

### 3. Migration via phpMyAdmin
```powershell
# Untuk file besar, split terlebih dahulu menggunakan PowerShell
# Split file 50MB per bagian
$content = Get-Content "marketplace_backup.sql"
$lineCount = $content.Length
$linesPerFile = [math]::Floor($lineCount / [math]::Ceiling($lineCount / 50000))

for ($i = 0; $i -lt $content.Length; $i += $linesPerFile) {
    $end = [math]::Min($i + $linesPerFile - 1, $content.Length - 1)
    $content[$i..$end] | Out-File "backup_part_$([math]::Floor($i / $linesPerFile) + 1).sql" -Encoding UTF8
}

# Import satu per satu via phpMyAdmin GUI
# 1. Login ke phpMyAdmin
# 2. Select database
# 3. Go to Import tab
# 4. Choose file
# 5. Select SQL format
# 6. Click Go
```

### 4. Laravel Database Operations
```powershell
# Export Laravel schema
php artisan schema:dump

# Migrate fresh (drop all tables and re-migrate)
php artisan migrate:fresh

# Migrate fresh with seed
php artisan migrate:fresh --seed

# Rollback migrations
php artisan migrate:rollback

# Rollback specific steps
php artisan migrate:rollback --step=3

# Check migration status
php artisan migrate:status
```

## Development Server Setup (Windows)

### 1. Laravel Development Server
```powershell
# Start Laravel development server
php artisan serve

# Start dengan custom host dan port
php artisan serve --host=127.0.0.1 --port=8001

# Start untuk external access
php artisan serve --host=0.0.0.0 --port=8000
```

### 2. Vite Development Server
```powershell
# Start Vite dev server (untuk hot reload)
npm run dev

# Build untuk production
npm run build

# Preview production build
npm run preview
```

### 3. Access URLs
- Laravel App: `http://localhost:8000`
- phpMyAdmin: `http://localhost/phpmyadmin`
- XAMPP Dashboard: `http://localhost/dashboard`
- Vite Dev Server: `http://localhost:5173`

## Windows-Specific Commands & Scripts

### 1. Batch Script untuk Start Development Environment
Create `start_dev.bat`:
```batch
@echo off
echo Starting XAMPP Services...
C:\xampp\apache_start.bat
C:\xampp\mysql_start.bat

echo Waiting for services to start...
timeout /t 5

echo Starting Laravel development server...
cd /d C:\xampp\htdocs\marketplace-project
start cmd /k "php artisan serve"

echo Starting Vite development server...
start cmd /k "npm run dev"

echo Development environment started!
pause
```

### 2. Batch Script untuk Stop Development Environment
Create `stop_dev.bat`:
```batch
@echo off
echo Stopping development servers...
taskkill /F /IM php.exe 2>nul
taskkill /F /IM node.exe 2>nul

echo Stopping XAMPP Services...
C:\xampp\apache_stop.bat
C:\xampp\mysql_stop.bat

echo Development environment stopped!
pause
```

### 3. PowerShell Script untuk Project Setup
Create `setup_project.ps1`:
```powershell
# Laravel Project Setup Script untuk Windows
param(
    [string]$ProjectName = "marketplace-project"
)

Write-Host "Setting up Laravel project: $ProjectName" -ForegroundColor Green

# Check if Laravel installer is available
if (!(Get-Command laravel -ErrorAction SilentlyContinue)) {
    Write-Host "Installing Laravel installer..." -ForegroundColor Yellow
    composer global require laravel/installer
}

# Navigate to htdocs
Set-Location "C:\xampp\htdocs"

# Create Laravel project
if (!(Test-Path $ProjectName)) {
    Write-Host "Creating Laravel project..." -ForegroundColor Yellow
    laravel new $ProjectName
} else {
    Write-Host "Project already exists!" -ForegroundColor Red
    exit
}

# Navigate to project directory
Set-Location $ProjectName

# Setup environment
Write-Host "Setting up environment..." -ForegroundColor Yellow
Copy-Item ".env.example" ".env"
php artisan key:generate

# Install NPM dependencies
Write-Host "Installing NPM dependencies..." -ForegroundColor Yellow
npm install

# Install additional packages
npm install bootstrap jquery popper.js @fortawesome/fontawesome-free sweetalert2

# Set permissions
Write-Host "Setting permissions..." -ForegroundColor Yellow
icacls "storage" /grant "Users:(OI)(CI)F" /T 2>$null
icacls "bootstrap\cache" /grant "Users:(OI)(CI)F" /T 2>$null

Write-Host "Project setup completed!" -ForegroundColor Green
Write-Host "Don't forget to:" -ForegroundColor Yellow
Write-Host "1. Update .env file with database credentials" -ForegroundColor Yellow
Write-Host "2. Create database in phpMyAdmin" -ForegroundColor Yellow
Write-Host "3. Run 'php artisan migrate'" -ForegroundColor Yellow
```

### 4. Windows Service Script untuk Auto-start XAMPP
Create `install_xampp_service.bat` (Run as Administrator):
```batch
@echo off
echo Installing XAMPP as Windows Service...

REM Install Apache as service
C:\xampp\apache\bin\httpd.exe -k install -n "Apache2.4"

REM Install MySQL as service
C:\xampp\mysql\bin\mysqld.exe --install MySQL --defaults-file=C:\xampp\mysql\bin\my.ini

echo XAMPP services installed!
echo Use 'net start Apache2.4' and 'net start MySQL' to start services
pause
```

## Security & Production Considerations (Windows)

### 1. Environment Security
```powershell
# Generate strong APP_KEY
php artisan key:generate

# Set proper file permissions (Windows)
icacls ".env" /inheritance:r /grant:r "%USERNAME%:(R)"
icacls "storage" /grant "IIS_IUSRS:(OI)(CI)F" /T
icacls "bootstrap\cache" /grant "IIS_IUSRS:(OI)(CI)F" /T
```

### 2. Database Security
```sql
-- Create dedicated database user
CREATE USER 'marketplace_user'@'localhost' IDENTIFIED BY 'secure_random_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON marketplace_db.* TO 'marketplace_user'@'localhost';
FLUSH PRIVILEGES;

-- Remove anonymous users
DELETE FROM mysql.user WHERE User='';

-- Set root password
ALTER USER 'root'@'localhost' IDENTIFIED BY 'strong_root_password';
```

### 3. phpMyAdmin Security
Create `.htaccess` in `C:\xampp\phpMyAdmin`:
```apache
# Restrict access to phpMyAdmin
<RequireAll>
    Require ip 127.0.0.1
    Require ip ::1
    # Add your IP address
    # Require ip xxx.xxx.xxx.xxx
</RequireAll>

# Hide sensitive files
<Files "config.inc.php">
    Require all denied
</Files>
```

### 4. Windows Firewall Configuration
```powershell
# Allow Laravel development server through firewall
New-NetFirewallRule -DisplayName "Laravel Dev Server" -Direction Inbound -Protocol TCP -LocalPort 8000 -Action Allow

# Allow Vite dev server through firewall
New-NetFirewallRule -DisplayName "Vite Dev Server" -Direction Inbound -Protocol TCP -LocalPort 5173 -Action Allow
```

## Troubleshooting Common Issues (Windows)

### 1. Permission Issues
```powershell
# Fix Laravel permissions
icacls "C:\xampp\htdocs\marketplace-project" /grant "Users:(OI)(CI)F" /T
icacls "storage" /grant "Users:(OI)(CI)F" /T
icacls "bootstrap\cache" /grant "Users:(OI)(CI)F" /T

# Fix XAMPP permissions
icacls "C:\xampp" /grant "Users:(OI)(CI)F" /T
```

### 2. PHP Path Issues
```powershell
# Add PHP to PATH permanently
[Environment]::SetEnvironmentVariable("Path", $env:Path + ";C:\xampp\php", [EnvironmentVariableTarget]::Machine)

# Restart PowerShell and test
php --version
```

### 3. Composer Issues
```powershell
# Clear Composer cache
composer clear-cache

# Update Composer itself
composer self-update

# Install with memory limit
php -d memory_limit=-1 C:\composer\composer.exe install

# Fix SSL issues
composer config --global disable-tls true
composer config --global secure-http false
```

### 4. NPM Issues
```powershell
# Clear NPM cache
npm cache clean --force

# Delete node_modules and reinstall
Remove-Item -Recurse -Force node_modules
Remove-Item package-lock.json -ErrorAction SilentlyContinue
npm install

# Fix permission issues
npm install --no-optional
```

### 5. MySQL Connection Issues
```powershell
# Check MySQL status
Get-Service | Where-Object {$_.Name -like "*mysql*"}

# Start MySQL service
net start MySQL

# Check MySQL error log
Get-Content "C:\xampp\mysql\data\*.err" -Tail 50
```

### 6. Port Conflicts (Common Windows Issue)
```powershell
# Check what's using port 80 (Apache)
netstat -ano | findstr :80

# Check what's using port 3306 (MySQL)
netstat -ano | findstr :3306

# Kill process using port (replace PID)
taskkill /PID <PID> /F

# Change Apache port in C:\xampp\apache\conf\httpd.conf
# Listen 8080
# ServerName localhost:8080
```

### 7. Laravel Common Errors
```powershell
# Class not found
composer dump-autoload

# Route not found
php artisan route:clear
php artisan route:cache

# View errors
php artisan view:clear

# Config cached
php artisan config:clear

# Clear all caches
php artisan optimize:clear

# Fix storage link on Windows
php artisan storage:link
# If fails, create manually:
# mklink /D "C:\xampp\htdocs\marketplace-project\public\storage" "C:\xampp\htdocs\marketplace-project\storage\app\public"
```

## Development Workflow (Windows)

### 1. Daily Development Routine
```powershell
# Start development environment (menggunakan batch script)
.\start_dev.bat

# Atau manual
cd C:\xampp\htdocs\marketplace-project

# Pull latest changes (if team project)
git pull origin main

# Update dependencies if needed
composer install
npm install

# Run migrations
php artisan migrate

# Start development servers (if not using batch script)
Start-Process powershell -ArgumentList "-NoExit", "-Command", "php artisan serve"
Start-Process powershell -ArgumentList "-NoExit", "-Command", "npm run dev"

# Your development work here...

# Before committing
php artisan test           # Run tests
npm run build             # Build assets
git add .
git commit -m "Feature: Add product management"
git push origin feature-branch
```

### 2. Backup Script (Windows)
Create `backup.ps1`:
```powershell
$Date = Get-Date -Format "yyyyMMdd_HHmmss"
$ProjectPath = "C:\xampp\htdocs\marketplace-project"
$BackupDir = "$env:USERPROFILE\backups"

# Create backup directory
if (!(Test-Path $BackupDir)) {
    New-Item -ItemType Directory -Path $BackupDir
}

# Backup database
C:\xampp\mysql\bin\mysqldump.exe -u root -p marketplace_db > "$BackupDir\marketplace_db_$Date.sql"

# Backup project files
Compress-Archive -Path "$ProjectPath\*" -DestinationPath "$BackupDir\marketplace_project_$Date.zip"

Write-Host "Backup completed: $Date"
```

### 3. Deployment Checklist (Windows)
```powershell
# 1. Update dependencies
composer install --optimize-autoloader --no-dev
npm ci --production

# 2. Build assets
npm run build

# 3. Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Run migrations
php artisan migrate --force

# 5. Create storage link
php artisan storage:link

# 6. Set proper permissions (Windows/IIS)
icacls "storage" /grant "IIS_IUSRS:(OI)(CI)F" /T
icacls "bootstrap\cache" /grant "IIS_IUSRS:(OI)(CI)F" /T
```

## Windows-Specific Tools & Extensions

### 1. Windows Subsystem for Linux (WSL) - Optional
```powershell
# Enable WSL (sebagai Administrator)
dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-For-Linux /all /norestart
dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart

# Install Ubuntu dari Microsoft Store
# Kemudian bisa menjalankan Linux commands di Windows
```

### 2. Chocolatey Package Manager
```powershell
# Install Chocolatey (sebagai Administrator)
Set-ExecutionPolicy Bypass -Scope Process -Force
[System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072
iex ((New-Object System.Net.WebClient).DownloadString('https://community.chocolatey.org/install.ps1'))

# Install packages via Chocolatey
choco install git nodejs composer php xampp vscode
```

### 3. Windows Terminal Configuration
```json
// settings.json untuk Windows Terminal
{
    "profiles": {
        "list": [
            {
                "name": "Laravel Dev",
                "commandline": "powershell.exe -NoExit -Command \"cd C:\\xampp\\htdocs\\marketplace-project\"",
                "startingDirectory": "C:\\xampp\\htdocs\\marketplace-project",
                "icon": "🚀"
            }
        ]
    }
}
```

Sekarang Anda memiliki panduan lengkap untuk setup development environment Laravel dengan XAMPP, phpMyAdmin, dan semua tools yang diperlukan khusus untuk Windows!

Apakah ada bagian tertentu yang ingin Anda implementasikan terlebih dahulu?
