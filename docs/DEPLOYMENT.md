# 🚀 Deployment Guide

## Server Details
- **Host:** 193.233.161.161
- **SSH Key:** C:\Users\tamir\.ssh\bestcasinoportal_auto
- **Document Root:** /var/www/casino-portal/public
- **Live URL:** https://bestcasinoportal.com/

## Deployment Process

### 1. SSH Deployment Script
```powershell
.\ssh-deploy.ps1 deploy
```

### 2. Manual SCP Upload
```bash
scp -i "C:\Users\tamir\.ssh\bestcasinoportal_auto" -r src/ root@193.233.161.161:/var/www/casino-portal/
```

### 3. Composer Autoload
```bash
ssh -i "C:\Users\tamir\.ssh\bestcasinoportal_auto" root@193.233.161.161 "cd /var/www/casino-portal && composer dump-autoload"
```

## File Permissions
```bash
chmod -R 755 /var/www/casino-portal/
chown -R www-data:www-data /var/www/casino-portal/
```

## Environment Setup
- PHP 8.3 with FPM
- Nginx with SSL (Let's Encrypt)
- MySQL 8.0+
- Composer for dependency management