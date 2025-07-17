#!/bin/bash
# Best Casino Portal - Server Deployment Script
# Run this script to deploy code to your VPS server

# Server Configuration
SERVER_HOST="193.233.161.161"
SERVER_USER="root"
SERVER_PATH="/var/www/casino-portal"
LOCAL_PATH="."

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}🚀 Best Casino Portal Deployment Script${NC}"
echo -e "${YELLOW}📡 Server: $SERVER_HOST${NC}"
echo -e "${YELLOW}📁 Target: $SERVER_PATH${NC}"
echo ""

# Function to run commands on server
run_remote() {
    ssh bestcasinoportal "$1"
}

# Function to upload files
upload_files() {
    echo -e "${YELLOW}📤 Uploading files...${NC}"
    rsync -avz --exclude='.git' --exclude='node_modules' --exclude='.env' --exclude='*.log' \
          "$LOCAL_PATH/" bestcasinoportal:"$SERVER_PATH/"
}

# Function to set permissions
set_permissions() {
    echo -e "${YELLOW}🔒 Setting permissions...${NC}"
    run_remote "chmod -R 755 $SERVER_PATH"
    run_remote "chmod -R 777 $SERVER_PATH/storage"
    run_remote "chmod -R 777 $SERVER_PATH/cache"
}

# Function to install dependencies
install_dependencies() {
    echo -e "${YELLOW}📦 Installing PHP dependencies...${NC}"
    run_remote "cd $SERVER_PATH && composer install --optimize-autoloader --no-dev"
}

# Function to restart services
restart_services() {
    echo -e "${YELLOW}🔄 Restarting services...${NC}"
    run_remote "systemctl reload nginx"
    run_remote "systemctl restart php8.2-fpm"
}

# Main deployment function
deploy() {
    echo -e "${GREEN}Starting deployment...${NC}"
    
    upload_files
    set_permissions
    install_dependencies
    restart_services
    
    echo -e "${GREEN}✅ Deployment completed successfully!${NC}"
    echo -e "${YELLOW}🌐 Visit: https://bestcasinoportal.com${NC}"
}

# Quick commands
case "$1" in
    "upload")
        upload_files
        ;;
    "deps")
        install_dependencies
        ;;
    "perms")
        set_permissions
        ;;
    "restart")
        restart_services
        ;;
    "full"|"")
        deploy
        ;;
    *)
        echo "Usage: $0 [upload|deps|perms|restart|full]"
        echo "  upload  - Upload files only"
        echo "  deps    - Install dependencies only"
        echo "  perms   - Set permissions only"
        echo "  restart - Restart services only"
        echo "  full    - Full deployment (default)"
        ;;
esac
