# Quick deployment script
$ErrorActionPreference = "Stop"

Write-Host "🚀 Quick Deploy to 193.233.161.161" -ForegroundColor Green

# Check SSH key
$sshKey = "c:\Users\tamir\.ssh\bestcasinoportal_auto"
if (-not (Test-Path $sshKey)) {
    Write-Host "❌ SSH key not found: $sshKey" -ForegroundColor Red
    exit 1
}

# Test connection
Write-Host "Testing SSH connection..." -ForegroundColor Yellow
try {
    ssh -i $sshKey -o ConnectTimeout=10 -o StrictHostKeyChecking=no root@193.233.161.161 "echo 'Connected'"
    Write-Host "✅ SSH connection successful" -ForegroundColor Green
} catch {
    Write-Host "❌ SSH connection failed" -ForegroundColor Red
    exit 1
}

# Deploy the entire project
Write-Host "Deploying project files..." -ForegroundColor Yellow

# Deploy public folder
scp -i $sshKey -r -o StrictHostKeyChecking=no "./public/*" root@193.233.161.161:/var/www/casino-portal/public/

# Deploy src folder
scp -i $sshKey -r -o StrictHostKeyChecking=no "./src" root@193.233.161.161:/var/www/casino-portal/

# Deploy composer files
scp -i $sshKey -o StrictHostKeyChecking=no "./composer.json" root@193.233.161.161:/var/www/casino-portal/
scp -i $sshKey -o StrictHostKeyChecking=no "./.env" root@193.233.161.161:/var/www/casino-portal/

# Install dependencies
Write-Host "Installing PHP dependencies..." -ForegroundColor Yellow
ssh -i $sshKey -o StrictHostKeyChecking=no root@193.233.161.161 "cd /var/www/casino-portal && composer install --no-dev --optimize-autoloader"

# Set permissions
ssh -i $sshKey -o StrictHostKeyChecking=no root@193.233.161.161 "chown -R www-data:www-data /var/www/casino-portal && chmod -R 755 /var/www/casino-portal"

Write-Host "✅ Deployment complete!" -ForegroundColor Green
Write-Host "🌐 Testing site..." -ForegroundColor Yellow

# Test the site
try {
    $response = Invoke-WebRequest -Uri "http://193.233.161.161" -TimeoutSec 10
    if ($response.StatusCode -eq 200) {
        Write-Host "🎉 Site is responding!" -ForegroundColor Green
    } else {
        Write-Host "⚠️ Site responded with status: $($response.StatusCode)" -ForegroundColor Yellow
    }
} catch {
    Write-Host "❌ Site test failed: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host "`n🔗 Test the site at: http://193.233.161.161" -ForegroundColor Cyan
