@echo off
echo =================================================
echo  SECURE Casino Portal Deployment (SSH Key Only)
echo  Server: 193.233.161.161 (Best Casino Portal VPS)
echo  Authentication: SSH Key ONLY - NO PASSWORDS
echo =================================================
echo.

REM Check if SSH key exists
if not exist "%USERPROFILE%\.ssh\bestcasinoportal_auto" (
    echo ERROR: SSH key not found at %USERPROFILE%\.ssh\bestcasinoportal_auto
    echo Please run setup-ssh.bat first to generate SSH keys
    pause
    exit /b 1
)

REM Set SSH options for key-only authentication
set SSH_OPTS=-o PasswordAuthentication=no -o PubkeyAuthentication=yes -o IdentitiesOnly=yes -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" -o StrictHostKeyChecking=no
set SCP_OPTS=-o PasswordAuthentication=no -o PubkeyAuthentication=yes -o IdentitiesOnly=yes -i "%USERPROFILE%\.ssh\bestcasinoportal_auto"

echo Testing SSH key authentication...
ssh %SSH_OPTS% root@193.233.161.161 "echo 'SSH Key Authentication: SUCCESS'"
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: SSH key authentication failed
    echo Please check your SSH key setup
    pause
    exit /b 1
)
echo ✅ SSH key authentication verified!
echo.

echo Step 1: Updating system packages...
ssh %SSH_OPTS% root@193.233.161.161 "apt update && apt upgrade -y"

echo.
echo Step 2: Installing LAMP stack...
ssh %SSH_OPTS% root@193.233.161.161 "apt install -y nginx mysql-server php8.3-fpm php8.3-mysql php8.3-curl php8.3-gd php8.3-intl php8.3-mbstring php8.3-xml php8.3-zip php8.3-cli php8.3-common php8.3-opcache certbot python3-certbot-nginx"

echo.
echo Step 3: Installing Composer...
ssh %SSH_OPTS% root@193.233.161.161 "curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer"

echo.
echo Step 4: Configuring MySQL database...
ssh %SSH_OPTS% root@193.233.161.161 "mysql -e 'CREATE DATABASE IF NOT EXISTS casino_portal;' && mysql -e 'CREATE USER IF NOT EXISTS \"casino_user\"@\"localhost\" IDENTIFIED BY \"CasinoSecure2025!\";' && mysql -e 'GRANT ALL PRIVILEGES ON casino_portal.* TO \"casino_user\"@\"localhost\";' && mysql -e 'FLUSH PRIVILEGES;'"

echo.
echo Step 5: Creating web directory...
ssh %SSH_OPTS% root@193.233.161.161 "mkdir -p /var/www/casino-portal && chown -R www-data:www-data /var/www/casino-portal"

echo.
echo Step 6: Uploading project files (SSH key secured)...
scp %SCP_OPTS% -r . root@193.233.161.161:/var/www/casino-portal/

echo.
echo Step 7: Installing PHP dependencies...
ssh %SSH_OPTS% root@193.233.161.161 "cd /var/www/casino-portal && composer install --no-dev --optimize-autoloader"

echo.
echo Step 8: Setting up environment configuration...
ssh %SSH_OPTS% root@193.233.161.161 "cd /var/www/casino-portal && if [ ! -f .env ]; then cp .env .env; fi"

echo.
echo Step 9: Setting proper permissions...
ssh %SSH_OPTS% root@193.233.161.161 "chown -R www-data:www-data /var/www/casino-portal && chmod -R 755 /var/www/casino-portal"

echo.
echo Step 10: Configuring Nginx...
ssh %SSH_OPTS% root@193.233.161.161 "cat > /etc/nginx/sites-available/casino-portal << 'EOF'
server {
    listen 80;
    listen [::]:80;
    server_name 193.233.161.161 bestcasinoportal.com www.bestcasinoportal.com;
    root /var/www/casino-portal/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options \"SAMEORIGIN\" always;
    add_header X-Content-Type-Options \"nosniff\" always;
    add_header X-XSS-Protection \"1; mode=block\" always;
    add_header Referrer-Policy \"strict-origin-when-cross-origin\" always;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php\$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.ht {
        deny all;
    }

    # Cache static assets
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control \"public, immutable\";
    }
}
EOF"

echo.
echo Step 11: Enabling site and services...
ssh %SSH_OPTS% root@193.233.161.161 "ln -sf /etc/nginx/sites-available/casino-portal /etc/nginx/sites-enabled/ && rm -f /etc/nginx/sites-enabled/default && nginx -t && systemctl enable nginx php8.3-fpm mysql && systemctl restart nginx php8.3-fpm mysql"

echo.
echo Step 12: Testing deployment...
ssh %SSH_OPTS% root@193.233.161.161 "curl -s -o /dev/null -w 'HTTP Status: %%{http_code}' http://localhost && echo ''"

echo.
echo =================================================
echo  🔐 SECURE Casino Portal Deployment Complete!
echo  🚀 Access your site at: http://193.233.161.161
echo  🔑 All connections secured with SSH key authentication
echo  ❌ Password authentication is DISABLED
echo =================================================
pause
