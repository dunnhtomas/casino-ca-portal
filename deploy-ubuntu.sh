#!/bin/bash

# Casino Portal - Ubuntu VPS Deployment Script
# Optimized for Ubuntu 22.04 LTS with PHP 8.2+

set -e  # Exit on any error

echo "🚀 Starting deployment to Ubuntu VPS..."

# Configuration
REMOTE_USER="root"
REMOTE_HOST="193.233.161.161"
REMOTE_PATH="/var/www/casino-portal"
LOCAL_PATH="."

echo "📋 Deployment Configuration:"
echo "   Remote: $REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH"
echo "   Local:  $LOCAL_PATH"
echo ""

# Step 1: Install PHP and dependencies on Ubuntu VPS
echo "📦 Installing PHP 8.2 and dependencies on Ubuntu VPS..."
ssh $REMOTE_USER@$REMOTE_HOST << 'EOF'
# Update system
apt update && apt upgrade -y

# Install PHP 8.2 and extensions
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update

apt install -y \
    php8.2 \
    php8.2-cli \
    php8.2-fpm \
    php8.2-mysql \
    php8.2-curl \
    php8.2-gd \
    php8.2-mbstring \
    php8.2-xml \
    php8.2-zip \
    php8.2-intl \
    php8.2-bcmath \
    composer \
    nginx \
    mysql-server \
    certbot \
    python3-certbot-nginx \
    git \
    rsync

# Configure PHP-FPM
systemctl enable php8.2-fpm
systemctl start php8.2-fpm

# Configure Nginx
systemctl enable nginx
systemctl start nginx

# Configure MySQL
systemctl enable mysql
systemctl start mysql

echo "✅ PHP 8.2 and dependencies installed successfully"
EOF

# Step 2: Create directory structure
echo "📁 Creating directory structure..."
ssh $REMOTE_USER@$REMOTE_HOST "mkdir -p $REMOTE_PATH && chown -R www-data:www-data $REMOTE_PATH"

# Step 3: Upload files
echo "📤 Uploading project files..."
rsync -avz --delete \
    --exclude='.git' \
    --exclude='node_modules' \
    --exclude='.env.local' \
    --exclude='deploy*.sh' \
    --exclude='setup-ssh.bat' \
    $LOCAL_PATH/ $REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/

# Step 4: Set permissions
echo "🔐 Setting correct permissions..."
ssh $REMOTE_USER@$REMOTE_HOST << EOF
chown -R www-data:www-data $REMOTE_PATH
find $REMOTE_PATH -type f -exec chmod 644 {} \;
find $REMOTE_PATH -type d -exec chmod 755 {} \;
chmod 600 $REMOTE_PATH/.env
EOF

# Step 5: Install Composer dependencies
echo "📦 Installing Composer dependencies..."
ssh $REMOTE_USER@$REMOTE_HOST << EOF
cd $REMOTE_PATH
sudo -u www-data composer install --no-dev --optimize-autoloader
EOF

# Step 6: Configure Nginx
echo "🌐 Configuring Nginx for casino-portal..."
ssh $REMOTE_USER@$REMOTE_HOST << 'EOF'
cat > /etc/nginx/sites-available/casino-portal << 'NGINX_CONF'
server {
    listen 80;
    server_name 193.233.161.161 bestcasinoportal.com www.bestcasinoportal.com;
    root /var/www/casino-portal/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # PHP-FPM configuration
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Static files caching
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Deny access to sensitive files
    location ~ /\. {
        deny all;
    }
}
NGINX_CONF

# Enable the site
ln -sf /etc/nginx/sites-available/casino-portal /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

# Test and reload Nginx
nginx -t && systemctl reload nginx

echo "✅ Nginx configured successfully"
EOF

# Step 7: Setup MySQL database
echo "🗄️ Setting up MySQL database..."
ssh $REMOTE_USER@$REMOTE_HOST << 'EOF'
mysql -e "CREATE DATABASE IF NOT EXISTS casino_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -e "CREATE USER IF NOT EXISTS 'casino_user'@'localhost' IDENTIFIED BY 'CasinoSecure2025!';"
mysql -e "GRANT ALL PRIVILEGES ON casino_portal.* TO 'casino_user'@'localhost';"
mysql -e "FLUSH PRIVILEGES;"
echo "✅ MySQL database setup complete"
EOF

# Step 8: Run database migrations (when we have them)
echo "🔄 Running database setup..."
ssh $REMOTE_USER@$REMOTE_HOST << EOF
cd $REMOTE_PATH
# TODO: Run database migrations here
echo "Database migrations will be added in next phase"
EOF

# Step 9: Setup SSL (Let's Encrypt)
echo "🔒 Setting up SSL certificate..."
ssh $REMOTE_USER@$REMOTE_HOST << 'EOF'
# Only setup SSL if domain is properly configured
if dig +short bestcasinoportal.com | grep -q "193.233.161.161"; then
    certbot --nginx -d bestcasinoportal.com -d www.bestcasinoportal.com --non-interactive --agree-tos --email admin@bestcasinoportal.com
    echo "✅ SSL certificate installed"
else
    echo "⚠️  Domain not pointing to server yet. SSL setup skipped."
    echo "   Configure DNS first: bestcasinoportal.com -> 193.233.161.161"
fi
EOF

# Step 10: Final checks
echo "🔍 Running final deployment checks..."
ssh $REMOTE_USER@$REMOTE_HOST << EOF
cd $REMOTE_PATH

echo "PHP Version:"
php -v | head -1

echo ""
echo "Nginx Status:"
systemctl is-active nginx

echo ""
echo "PHP-FPM Status:"
systemctl is-active php8.2-fpm

echo ""
echo "MySQL Status:"
systemctl is-active mysql

echo ""
echo "Disk Usage:"
df -h /var/www

echo ""
echo "Directory Permissions:"
ls -la $REMOTE_PATH

echo ""
echo "✅ Deployment completed successfully!"
echo "🌐 Site accessible at: http://193.233.161.161"
echo "🔧 Server ready for development"
EOF

echo ""
echo "🎉 Ubuntu VPS deployment complete!"
echo "📋 Next steps:"
echo "   1. Point domain DNS to 193.233.161.161"
echo "   2. Run SSL setup: certbot --nginx -d yourdomain.com"
echo "   3. Begin PHP development phase"
echo ""
