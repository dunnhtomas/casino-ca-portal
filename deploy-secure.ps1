# PowerShell Script for Secure Casino Portal Deployment
# SSH Key Authentication Only - NO PASSWORDS

Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "  SECURE Casino Portal Deployment (SSH Key Only)" -ForegroundColor Green
Write-Host "  Server: 193.233.161.161 (Best Casino Portal VPS)" -ForegroundColor Yellow
Write-Host "  Authentication: SSH Key ONLY - NO PASSWORDS" -ForegroundColor Red
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ""

# SSH Configuration
$SSHKey = "$env:USERPROFILE\.ssh\bestcasinoportal_auto"
$SSHOpts = @(
    "-o", "PasswordAuthentication=no",
    "-o", "PubkeyAuthentication=yes", 
    "-o", "IdentitiesOnly=yes",
    "-i", $SSHKey,
    "-o", "StrictHostKeyChecking=no"
)
$Server = "root@193.233.161.161"

# Check SSH key exists
if (-not (Test-Path $SSHKey)) {
    Write-Host "ERROR: SSH key not found at $SSHKey" -ForegroundColor Red
    Write-Host "Please run setup-ssh.bat first to generate SSH keys" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}

# Test SSH authentication
Write-Host "Testing SSH key authentication..." -ForegroundColor Yellow
$testResult = & ssh @SSHOpts $Server "echo 'SSH Key Authentication: SUCCESS'"
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: SSH key authentication failed" -ForegroundColor Red
    Write-Host "Please check your SSH key setup" -ForegroundColor Yellow
    Read-Host "Press Enter to exit"
    exit 1
}
Write-Host "✅ SSH key authentication verified!" -ForegroundColor Green
Write-Host ""

# Deployment steps
$steps = @(
    @{
        Name = "Updating system packages"
        Command = "apt update && apt upgrade -y"
    },
    @{
        Name = "Installing LAMP stack"
        Command = "apt install -y nginx mysql-server php8.3-fpm php8.3-mysql php8.3-curl php8.3-gd php8.3-intl php8.3-mbstring php8.3-xml php8.3-zip php8.3-cli php8.3-common php8.3-opcache certbot python3-certbot-nginx"
    },
    @{
        Name = "Installing Composer"
        Command = "curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer"
    },
    @{
        Name = "Configuring MySQL database"
        Command = "mysql -e 'CREATE DATABASE IF NOT EXISTS casino_portal;' && mysql -e 'CREATE USER IF NOT EXISTS `"casino_user`"@`"localhost`" IDENTIFIED BY `"CasinoSecure2025!`";' && mysql -e 'GRANT ALL PRIVILEGES ON casino_portal.* TO `"casino_user`"@`"localhost`";' && mysql -e 'FLUSH PRIVILEGES;'"
    },
    @{
        Name = "Creating web directory"
        Command = "mkdir -p /var/www/casino-portal && chown -R www-data:www-data /var/www/casino-portal"
    }
)

foreach ($step in $steps) {
    Write-Host "Step $($steps.IndexOf($step) + 1): $($step.Name)..." -ForegroundColor Yellow
    $result = & ssh @SSHOpts $Server $step.Command
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ $($step.Name) completed successfully" -ForegroundColor Green
    } else {
        Write-Host "❌ $($step.Name) failed" -ForegroundColor Red
    }
    Write-Host ""
}

# Upload files using SCP
Write-Host "Step 6: Uploading project files (SSH key secured)..." -ForegroundColor Yellow
$scpOpts = @(
    "-o", "PasswordAuthentication=no",
    "-o", "PubkeyAuthentication=yes",
    "-o", "IdentitiesOnly=yes", 
    "-i", $SSHKey,
    "-r"
)
& scp @scpOpts . "$($Server):/var/www/casino-portal/"
if ($LASTEXITCODE -eq 0) {
    Write-Host "✅ File upload completed successfully" -ForegroundColor Green
} else {
    Write-Host "❌ File upload failed" -ForegroundColor Red
}
Write-Host ""

# Continue with remaining steps
$finalSteps = @(
    @{
        Name = "Installing PHP dependencies"
        Command = "cd /var/www/casino-portal && composer install --no-dev --optimize-autoloader"
    },
    @{
        Name = "Setting up environment configuration"
        Command = "cd /var/www/casino-portal && if [ ! -f .env ]; then cp .env .env; fi"
    },
    @{
        Name = "Setting proper permissions"
        Command = "chown -R www-data:www-data /var/www/casino-portal && chmod -R 755 /var/www/casino-portal"
    }
)

foreach ($step in $finalSteps) {
    Write-Host "Step $($finalSteps.IndexOf($step) + 7): $($step.Name)..." -ForegroundColor Yellow
    $result = & ssh @SSHOpts $Server $step.Command
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ $($step.Name) completed successfully" -ForegroundColor Green
    } else {
        Write-Host "❌ $($step.Name) failed" -ForegroundColor Red
    }
    Write-Host ""
}

# Configure Nginx
Write-Host "Step 10: Configuring Nginx..." -ForegroundColor Yellow
$nginxConfig = @"
server {
    listen 80;
    listen [::]:80;
    server_name 193.233.161.161 bestcasinoportal.com www.bestcasinoportal.com;
    root /var/www/casino-portal/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "strict-origin-when-cross-origin" always;

    location / {
        try_files \`$uri \`$uri/ /index.php?\`$query_string;
    }

    location ~ \.php\`$ {
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \`$realpath_root\`$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.ht {
        deny all;
    }

    # Cache static assets
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)\`$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }
}
"@

$nginxCommand = "cat > /etc/nginx/sites-available/casino-portal << 'EOF'`n$nginxConfig`nEOF"
& ssh @SSHOpts $Server $nginxCommand

# Enable site and services
Write-Host "Step 11: Enabling site and services..." -ForegroundColor Yellow
& ssh @SSHOpts $Server "ln -sf /etc/nginx/sites-available/casino-portal /etc/nginx/sites-enabled/ && rm -f /etc/nginx/sites-enabled/default && nginx -t && systemctl enable nginx php8.3-fpm mysql && systemctl restart nginx php8.3-fpm mysql"

# Test deployment
Write-Host "Step 12: Testing deployment..." -ForegroundColor Yellow
$testResult = & ssh @SSHOpts $Server "curl -s -o /dev/null -w 'HTTP Status: %{http_code}' http://localhost"
Write-Host $testResult -ForegroundColor Green

Write-Host ""
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "🔐 SECURE Casino Portal Deployment Complete!" -ForegroundColor Green
Write-Host "🚀 Access your site at: http://193.233.161.161" -ForegroundColor Yellow
Write-Host "🔑 All connections secured with SSH key authentication" -ForegroundColor Green  
Write-Host "❌ Password authentication is DISABLED" -ForegroundColor Red
Write-Host "=================================================" -ForegroundColor Cyan

Read-Host "Press Enter to exit"
