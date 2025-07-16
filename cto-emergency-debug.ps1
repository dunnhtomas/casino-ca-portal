#!/usr/bin/env pwsh

# =====================================================
# FULL CTO EMERGENCY DEBUG & DEPLOYMENT
# Best Casino Portal - Complete System Recovery
# =====================================================

Write-Host "🚨 EMERGENCY CTO DEBUG MODE ACTIVATED" -ForegroundColor Red
Write-Host "====================================" -ForegroundColor Yellow

# Configuration
$SERVER = "root@193.233.161.161"
$DOMAIN = "bestcasinoportal.com"
$LOCAL_PATH = "c:\Users\tamir\Downloads\Casino CA SEO"
$REMOTE_PATH = "/var/www/casino-portal"

# Test connectivity first
Write-Host "🔍 PHASE 1: CONNECTIVITY DIAGNOSIS" -ForegroundColor Cyan
Write-Host "Testing domain response..." -ForegroundColor White

try {
    $response = Invoke-WebRequest -Uri "https://$DOMAIN/" -TimeoutSec 10 -ErrorAction Stop
    Write-Host "✅ Domain responds: $($response.StatusCode)" -ForegroundColor Green
} catch {
    Write-Host "❌ Domain connection failed: $($_.Exception.Message)" -ForegroundColor Red
}

# Check current error
Write-Host "`n🔍 PHASE 2: ERROR ANALYSIS" -ForegroundColor Cyan
try {
    $content = Invoke-WebRequest -Uri "https://$DOMAIN/" -TimeoutSec 10 -ErrorAction Stop
    if ($content.Content -match "Router\.php.*Failed to open stream") {
        Write-Host "❌ CONFIRMED: Router.php missing on server" -ForegroundColor Red
        Write-Host "   Error: require_once(/var/www/casino-portal/src/Core/Router.php)" -ForegroundColor Yellow
    }
} catch {
    Write-Host "❌ Cannot fetch error details" -ForegroundColor Red
}

# Try SSH connection
Write-Host "`n🔍 PHASE 3: SSH CONNECTIVITY" -ForegroundColor Cyan

$sshKeys = @(
    "c:\Users\tamir\.ssh\bestcasinoportal_auto",
    "c:\Users\tamir\.ssh\kvm_server_key",
    "c:\Users\tamir\.ssh\id_rsa"
)

$workingKey = $null
foreach ($key in $sshKeys) {
    if (Test-Path $key) {
        Write-Host "Testing SSH key: $key" -ForegroundColor White
        try {
            $result = ssh -i $key -o ConnectTimeout=5 -o StrictHostKeyChecking=no $SERVER "echo 'SSH OK'" 2>$null
            if ($result -eq "SSH OK") {
                $workingKey = $key
                Write-Host "✅ SSH key working: $key" -ForegroundColor Green
                break
            }
        } catch {
            Write-Host "❌ SSH key failed: $key" -ForegroundColor Red
        }
    }
}

if (-not $workingKey) {
    Write-Host "❌ NO WORKING SSH KEYS - Using alternative deployment" -ForegroundColor Red
    
    # Alternative deployment via FTP/SFTP or direct file creation
    Write-Host "`n🔧 PHASE 4: ALTERNATIVE DEPLOYMENT" -ForegroundColor Cyan
    
    # Create a direct API call to create the Router.php file
    Write-Host "Creating Router.php via direct method..." -ForegroundColor White
    
    # Read our local Router.php
    $routerContent = Get-Content "$LOCAL_PATH\src\Core\Router.php" -Raw
    
    # Create deployment payload
    $deploymentScript = @"
<?php
// Emergency Router.php deployment script
file_put_contents('/var/www/casino-portal/src/Core/Router.php', base64_decode('$(([Convert]::ToBase64String([System.Text.Encoding]::UTF8.GetBytes($routerContent))))'));
echo "Router.php deployed successfully";
?>
"@
    
    # Save deployment script
    $deploymentScript | Out-File -FilePath "$LOCAL_PATH\emergency-router-deploy.php" -Encoding UTF8
    
    Write-Host "✅ Emergency deployment script created" -ForegroundColor Green
    Write-Host "Manual deployment required - upload emergency-router-deploy.php to server" -ForegroundColor Yellow
    
} else {
    Write-Host "`n🚀 PHASE 4: FULL DEPLOYMENT" -ForegroundColor Cyan
    
    # Create directories
    Write-Host "Creating server directories..." -ForegroundColor White
    ssh -i $workingKey -o StrictHostKeyChecking=no $SERVER "mkdir -p $REMOTE_PATH/src/Core $REMOTE_PATH/src/Controllers $REMOTE_PATH/src/Services"
    
    # Deploy Router.php
    Write-Host "Deploying Router.php..." -ForegroundColor White
    scp -i $workingKey -o StrictHostKeyChecking=no "$LOCAL_PATH\src\Core\Router.php" "${SERVER}:$REMOTE_PATH/src/Core/"
    
    # Deploy Controllers
    Write-Host "Deploying Controllers..." -ForegroundColor White
    scp -i $workingKey -o StrictHostKeyChecking=no "$LOCAL_PATH\src\Controllers\*.php" "${SERVER}:$REMOTE_PATH/src/Controllers/"
    
    # Deploy updated index.php
    Write-Host "Deploying fixed index.php..." -ForegroundColor White
    scp -i $workingKey -o StrictHostKeyChecking=no "$LOCAL_PATH\public\index.php" "${SERVER}:$REMOTE_PATH/public/"
    
    # Set permissions
    Write-Host "Setting permissions..." -ForegroundColor White
    ssh -i $workingKey -o StrictHostKeyChecking=no $SERVER "chown -R www-data:www-data $REMOTE_PATH && chmod -R 755 $REMOTE_PATH"
    
    Write-Host "✅ Full deployment completed" -ForegroundColor Green
}

# Test the fix
Write-Host "`n🧪 PHASE 5: VALIDATION" -ForegroundColor Cyan

Start-Sleep -Seconds 2

try {
    $testResponse = Invoke-WebRequest -Uri "https://$DOMAIN/" -TimeoutSec 15 -ErrorAction Stop
    
    if ($testResponse.StatusCode -eq 200 -and $testResponse.Content -notmatch "Fatal error") {
        Write-Host "✅ SUCCESS: Site is working!" -ForegroundColor Green
        Write-Host "🌐 Homepage: https://$DOMAIN/" -ForegroundColor Green
        Write-Host "🎰 Casinos: https://$DOMAIN/casinos" -ForegroundColor Green
        Write-Host "📝 Reviews: https://$DOMAIN/reviews" -ForegroundColor Green
        Write-Host "🤖 Generator: https://$DOMAIN/generate-content" -ForegroundColor Green
    } else {
        Write-Host "❌ Site still has issues" -ForegroundColor Red
        Write-Host "Response: $($testResponse.StatusCode)" -ForegroundColor Yellow
        
        # Show error content
        if ($testResponse.Content.Length -lt 1000) {
            Write-Host "Error content:" -ForegroundColor Yellow
            Write-Host $testResponse.Content -ForegroundColor Red
        }
    }
} catch {
    Write-Host "❌ Validation failed: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host "`n📊 FINAL STATUS REPORT" -ForegroundColor Cyan
Write-Host "=====================" -ForegroundColor White
Write-Host "Domain: $DOMAIN"
Write-Host "Server: $SERVER"
Write-Host "Local Path: $LOCAL_PATH"
Write-Host "Remote Path: $REMOTE_PATH"

if ($workingKey) {
    Write-Host "SSH Key: $workingKey" -ForegroundColor Green
} else {
    Write-Host "SSH Key: NONE WORKING" -ForegroundColor Red
}

Write-Host "`n🎯 NEXT ACTIONS:" -ForegroundColor Cyan
Write-Host "1. Verify site loads without errors"
Write-Host "2. Test all routes (/casinos, /reviews, etc.)"
Write-Host "3. Check AI content generation"
Write-Host "4. Monitor server logs for issues"

Write-Host "`n✅ CTO DEBUG COMPLETE" -ForegroundColor Green
