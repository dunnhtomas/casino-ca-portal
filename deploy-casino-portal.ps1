# Casino Portal Deployment Script for Ubuntu VPS
# Alexhost.com - Fresh Ubuntu 24.04 LTS Installation

Write-Host "🚀 Deploying Best Casino Portal to Ubuntu VPS..." -ForegroundColor Green
Write-Host "Server: 193.233.161.161 (alexhost.com)" -ForegroundColor Cyan
Write-Host ""

# Step 1: Update Ubuntu and install LAMP stack
Write-Host "📦 Installing LAMP stack (PHP 8.3, MySQL 8.0, Nginx)..." -ForegroundColor Yellow
ssh bestcasinoportal @"
set -e
echo '🔄 Updating Ubuntu packages...'
apt update && apt upgrade -y

echo '📦 Installing Nginx, PHP 8.3, MySQL...'
apt install -y nginx mysql-server php8.3-fpm php8.3-mysql php8.3-curl php8.3-gd php8.3-intl php8.3-mbstring php8.3-xml php8.3-zip php8.3-cli php8.3-common php8.3-opcache

echo '🔧 Installing Composer...'
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

echo '🔧 Configuring MySQL...'
mysql -e "CREATE DATABASE casino_portal;"
mysql -e "CREATE USER 'casino_user'@'localhost' IDENTIFIED BY 'CasinoSecure2025!';"
mysql -e "GRANT ALL PRIVILEGES ON casino_portal.* TO 'casino_user'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"

echo '🌐 Configuring Nginx for casino portal...'
cat > /etc/nginx/sites-available/casino-portal << 'EOF'
server {
    listen 80;
    server_name 193.233.161.161 bestcasinoportal.com;
    root /var/www/casino-portal/public;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

ln -sf /etc/nginx/sites-available/casino-portal /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

echo '🔄 Starting services...'
systemctl enable nginx php8.3-fpm mysql
systemctl restart nginx php8.3-fpm mysql

echo '✅ LAMP stack installation complete!'
"@

# Step 2: Upload casino portal files
Write-Host ""
Write-Host "📂 Uploading casino portal files..." -ForegroundColor Yellow

# Create project directory on server
ssh bestcasinoportal "mkdir -p /var/www/casino-portal && chown -R www-data:www-data /var/www/casino-portal"

# Upload all project files
scp -r * bestcasinoportal:/var/www/casino-portal/

# Step 3: Install PHP dependencies and configure
Write-Host ""
Write-Host "🔧 Installing PHP dependencies and configuring..." -ForegroundColor Yellow
ssh bestcasinoportal @"
cd /var/www/casino-portal

echo '📦 Installing Composer dependencies...'
composer install --no-dev --optimize-autoloader

echo '🔧 Setting up environment...'
cp .env.example .env
sed -i 's/DB_HOST=localhost/DB_HOST=localhost/' .env
sed -i 's/DB_DATABASE=casino_portal/DB_DATABASE=casino_portal/' .env
sed -i 's/DB_USERNAME=root/DB_USERNAME=casino_user/' .env
sed -i 's/DB_PASSWORD=/DB_PASSWORD=CasinoSecure2025!/' .env

echo '🗄️ Running database migrations...'
# We'll add migration commands here once we create them

echo '🔒 Setting proper permissions...'
chown -R www-data:www-data /var/www/casino-portal
chmod -R 755 /var/www/casino-portal
chmod -R 775 /var/www/casino-portal/storage /var/www/casino-portal/cache

echo '✅ Casino portal deployment complete!'
"@

# Step 4: Test deployment
Write-Host ""
Write-Host "🧪 Testing deployment..." -ForegroundColor Yellow
$response = ssh bestcasinoportal "curl -s -o /dev/null -w '%{http_code}' http://localhost"

if ($response -eq "200") {
    Write-Host "✅ Casino portal is live and responding!" -ForegroundColor Green
    Write-Host "🌐 Visit: http://193.233.161.161" -ForegroundColor Cyan
} else {
    Write-Host "⚠️  Server responded with code: $response" -ForegroundColor Yellow
    Write-Host "🔧 Check Nginx error logs for details" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "🎰 Best Casino Portal deployment complete!" -ForegroundColor Green
Write-Host "🚀 Server ready for casino.ca replica development!" -ForegroundColor Cyan
