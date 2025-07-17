@echo off
echo =================================================
echo  Casino Portal Deployment to Ubuntu VPS
echo  Server: 193.233.161.161 (Best Casino Portal VPS)
echo =================================================
echo.

echo Step 1: Installing LAMP stack on Ubuntu VPS...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "apt update && apt upgrade -y && apt install -y nginx mysql-server php8.3-fpm php8.3-mysql php8.3-curl php8.3-gd php8.3-intl php8.3-mbstring php8.3-xml php8.3-zip php8.3-cli php8.3-common php8.3-opcache && echo 'LAMP stack installed successfully!'"

echo.
echo Step 2: Installing Composer...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer && echo 'Composer installed successfully!'"

echo.
echo Step 3: Setting up MySQL database...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "mysql -e \"CREATE DATABASE IF NOT EXISTS casino_portal;\" && mysql -e \"CREATE USER IF NOT EXISTS 'casino_user'@'localhost' IDENTIFIED BY 'CasinoSecure2025!';\" && mysql -e \"GRANT ALL PRIVILEGES ON casino_portal.* TO 'casino_user'@'localhost';\" && mysql -e \"FLUSH PRIVILEGES;\" && echo 'MySQL database configured successfully!'"

echo.
echo Step 4: Creating web directory...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "mkdir -p /var/www/casino-portal && chown -R www-data:www-data /var/www/casino-portal && echo 'Web directory created successfully!'"

echo.
echo Step 5: Uploading project files...
scp -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" -r . root@193.233.161.161:/var/www/casino-portal/

echo.
echo Step 6: Installing PHP dependencies...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "cd /var/www/casino-portal && composer install --no-dev --optimize-autoloader && echo 'PHP dependencies installed successfully!'"

echo.
echo Step 7: Configuring environment...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "cd /var/www/casino-portal && cp .env.example .env && echo 'Environment configured successfully!'"

echo.
echo Step 8: Setting permissions...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "chown -R www-data:www-data /var/www/casino-portal && chmod -R 755 /var/www/casino-portal && echo 'Permissions set successfully!'"

echo.
echo Step 9: Starting services...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "systemctl enable nginx php8.3-fpm mysql && systemctl restart nginx php8.3-fpm mysql && echo 'Services started successfully!'"

echo.
echo Step 10: Testing deployment...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "curl -s -o /dev/null -w '%%{http_code}' http://localhost"

echo.
echo =================================================
echo  Casino Portal Deployment Complete!
echo  Access your site at: http://193.233.161.161
echo =================================================
pause
