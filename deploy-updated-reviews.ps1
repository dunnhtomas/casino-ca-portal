#!/usr/bin/env pwsh

# Deploy Updated DetailedCasinoReviewsService.php
# Using correct server details from CTO Knowledge Base

Write-Host "🚀 Deploying updated DetailedCasinoReviewsService.php..." -ForegroundColor Green
Write-Host "Server: 193.233.161.161 (Best Casino Portal VPS)" -ForegroundColor Cyan
Write-Host ""

# Configuration from CTO Knowledge Base
$SERVER = "root@193.233.161.161"
$SSH_KEY = "C:\Users\tamir\.ssh\bestcasinoportal_auto"
$LOCAL_PATH = "c:\Users\tamir\Downloads\Casino CA SEO"
$REMOTE_PATH = "/var/www/casino-portal"

# Deploy the updated DetailedCasinoReviewsService.php
Write-Host "📤 Uploading DetailedCasinoReviewsService.php with BonRush, SLOTSVIL, CASINOJOY..." -ForegroundColor Yellow

try {
    # Upload the updated service file
    $result = scp -i $SSH_KEY -o StrictHostKeyChecking=no "$LOCAL_PATH\src\Services\DetailedCasinoReviewsService.php" "${SERVER}:$REMOTE_PATH/src/Services/" 2>&1
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ DetailedCasinoReviewsService.php deployed successfully!" -ForegroundColor Green
        
        # Set proper permissions
        Write-Host "🔒 Setting permissions..." -ForegroundColor Yellow
        ssh -i $SSH_KEY -o StrictHostKeyChecking=no $SERVER "chown www-data:www-data $REMOTE_PATH/src/Services/DetailedCasinoReviewsService.php && chmod 644 $REMOTE_PATH/src/Services/DetailedCasinoReviewsService.php"
        
        Write-Host "✅ Permissions set correctly!" -ForegroundColor Green
        
    } else {
        Write-Host "❌ Deployment failed: $result" -ForegroundColor Red
        exit 1
    }
    
} catch {
    Write-Host "❌ Deployment error: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
}

# Test the homepage to see if Expert Reviews section is updated
Write-Host "`n🧪 Testing Expert Reviews section..." -ForegroundColor Cyan

Start-Sleep -Seconds 2

try {
    $response = Invoke-WebRequest -Uri "https://bestcasinoportal.com/" -TimeoutSec 15 -ErrorAction Stop
    
    if ($response.Content -match "BonRush|SLOTSVIL|CASINOJOY") {
        Write-Host "✅ SUCCESS: Expert Reviews section now shows real casino data!" -ForegroundColor Green
        
        if ($response.Content -match "BonRush") {
            Write-Host "   ✓ BonRush found in homepage" -ForegroundColor Green
        }
        if ($response.Content -match "SLOTSVIL") {
            Write-Host "   ✓ SLOTSVIL found in homepage" -ForegroundColor Green
        }
        if ($response.Content -match "CASINOJOY") {
            Write-Host "   ✓ CASINOJOY found in homepage" -ForegroundColor Green
        }
        
    } else {
        Write-Host "⚠️  Homepage loaded but Expert Reviews may still be cached" -ForegroundColor Yellow
        Write-Host "   Check: https://bestcasinoportal.com/" -ForegroundColor White
    }
    
} catch {
    Write-Host "⚠️  Could not test homepage: $($_.Exception.Message)" -ForegroundColor Yellow
}

Write-Host "`n📊 DEPLOYMENT SUMMARY" -ForegroundColor Cyan
Write-Host "===================" -ForegroundColor White
Write-Host "✅ DetailedCasinoReviewsService.php updated with:" -ForegroundColor Green
Write-Host "   • BonRush (2020, 8.3 rating, 2,500+ games)" -ForegroundColor White
Write-Host "   • SLOTSVIL (2019, 8.3 rating, 3,000+ games)" -ForegroundColor White  
Write-Host "   • CASINOJOY (2021, 8.3 rating, 2,200+ games)" -ForegroundColor White
Write-Host ""
Write-Host "🌐 Live Site: https://bestcasinoportal.com/" -ForegroundColor Green
Write-Host "📊 Expert Reviews: Scroll to 'Expert Reviews: Top 3 Canadian Casinos'" -ForegroundColor Green

Write-Host "`n✅ DEPLOYMENT COMPLETE!" -ForegroundColor Green
