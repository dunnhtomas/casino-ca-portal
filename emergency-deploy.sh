#!/bin/bash

# Casino Portal - Emergency Deployment Script
# Fixes the missing Router.php and deploys all controllers

SERVER="root@193.233.161.161"
SSH_KEY="c:/Users/tamir/.ssh/bestcasinoportal_auto"
LOCAL_PATH="c:/Users/tamir/Downloads/Casino CA SEO"
REMOTE_PATH="/var/www/casino-portal"

echo "🚀 Emergency Deployment: Fixing Router.php Fatal Error"
echo "=================================================="

# Create directories if they don't exist
echo "📁 Creating directories..."
ssh -i "$SSH_KEY" -o StrictHostKeyChecking=no $SERVER "mkdir -p $REMOTE_PATH/src/Core"
ssh -i "$SSH_KEY" -o StrictHostKeyChecking=no $SERVER "mkdir -p $REMOTE_PATH/src/Controllers"

# Deploy Router.php
echo "🔧 Deploying Router.php..."
scp -i "$SSH_KEY" -o StrictHostKeyChecking=no "$LOCAL_PATH/src/Core/Router.php" $SERVER:$REMOTE_PATH/src/Core/

# Deploy Controllers
echo "📝 Deploying Controllers..."
scp -i "$SSH_KEY" -o StrictHostKeyChecking=no "$LOCAL_PATH/src/Controllers/HomeController.php" $SERVER:$REMOTE_PATH/src/Controllers/
scp -i "$SSH_KEY" -o StrictHostKeyChecking=no "$LOCAL_PATH/src/Controllers/CasinoController.php" $SERVER:$REMOTE_PATH/src/Controllers/
scp -i "$SSH_KEY" -o StrictHostKeyChecking=no "$LOCAL_PATH/src/Controllers/ContentController.php" $SERVER:$REMOTE_PATH/src/Controllers/

# Set proper permissions
echo "🔐 Setting permissions..."
ssh -i "$SSH_KEY" -o StrictHostKeyChecking=no $SERVER "chown -R www-data:www-data $REMOTE_PATH"
ssh -i "$SSH_KEY" -o StrictHostKeyChecking=no $SERVER "chmod -R 755 $REMOTE_PATH"

# Test the site
echo "🌐 Testing site..."
RESPONSE=$(curl -s -o /dev/null -w "%{http_code}" https://casinoportal.tamirberkovich.com/)
if [ "$RESPONSE" = "200" ]; then
    echo "✅ Site is working! HTTP $RESPONSE"
else
    echo "❌ Site still has issues. HTTP $RESPONSE"
fi

echo "=================================================="
echo "✅ Deployment complete!"
echo "🔗 Site: https://casinoportal.tamirberkovich.com/"
echo "📝 Reviews: https://casinoportal.tamirberkovich.com/reviews"
echo "🤖 Generator: https://casinoportal.tamirberkovich.com/generate-content"
