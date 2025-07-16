# Emergency Router.php Fix
# Creates the missing Router.php file directly on server

Write-Host "🚨 EMERGENCY ROUTER.PHP FIX" -ForegroundColor Red

# Test current site status
Write-Host "Testing site status..." -ForegroundColor Yellow
try {
    $response = Invoke-WebRequest -Uri "https://bestcasinoportal.com/" -TimeoutSec 10
    if ($response.Content -match "Router\.php.*Failed to open stream") {
        Write-Host "❌ CONFIRMED: Router.php missing" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ Site unreachable" -ForegroundColor Red
}

# Read local Router.php content
$routerPath = "c:\Users\tamir\Downloads\Casino CA SEO\src\Core\Router.php"
if (Test-Path $routerPath) {
    $routerContent = Get-Content $routerPath -Raw
    Write-Host "✅ Local Router.php found" -ForegroundColor Green
    
    # Create base64 encoded content for safe transfer
    $base64Content = [Convert]::ToBase64String([System.Text.Encoding]::UTF8.GetBytes($routerContent))
    
    # Create deployment script
    $deployScript = @"
<?php
// Emergency Router.php deployment
`$routerContent = base64_decode('$base64Content');
`$targetDir = '/var/www/casino-portal/src/Core';
if (!is_dir(`$targetDir)) {
    mkdir(`$targetDir, 0755, true);
}
file_put_contents('$targetDir/Router.php', `$routerContent);
echo 'Router.php deployed successfully';
?>
"@
    
    # Save deployment script
    $deployScript | Out-File -FilePath "emergency-router-deploy.php" -Encoding UTF8
    Write-Host "✅ Emergency deployment script created: emergency-router-deploy.php" -ForegroundColor Green
    Write-Host "📋 MANUAL STEPS:" -ForegroundColor Cyan
    Write-Host "1. Upload emergency-router-deploy.php to your server's public directory" -ForegroundColor White
    Write-Host "2. Visit: https://bestcasinoportal.com/emergency-router-deploy.php" -ForegroundColor White
    Write-Host "3. Delete the deployment script after use" -ForegroundColor White
    
} else {
    Write-Host "❌ Local Router.php not found at: $routerPath" -ForegroundColor Red
}

Write-Host "`nAlternatively, try SSH deployment..." -ForegroundColor Yellow

# Try SSH deployment
$sshKey = "c:\Users\tamir\.ssh\bestcasinoportal_auto"
if (Test-Path $sshKey) {
    Write-Host "Attempting SSH deployment..." -ForegroundColor White
    try {
        # Test SSH connection
        $sshTest = ssh -i $sshKey -o ConnectTimeout=5 -o StrictHostKeyChecking=no root@193.233.161.161 "echo 'SSH OK'" 2>$null
        if ($sshTest -eq "SSH OK") {
            Write-Host "✅ SSH connection successful" -ForegroundColor Green
            
            # Deploy Router.php
            ssh -i $sshKey -o StrictHostKeyChecking=no root@193.233.161.161 "mkdir -p /var/www/casino-portal/src/Core"
            scp -i $sshKey -o StrictHostKeyChecking=no $routerPath root@193.233.161.161:/var/www/casino-portal/src/Core/
            
            Write-Host "✅ Router.php deployed via SSH" -ForegroundColor Green
            
            # Test site
            Start-Sleep -Seconds 2
            $testResponse = Invoke-WebRequest -Uri "https://bestcasinoportal.com/" -TimeoutSec 10
            if ($testResponse.StatusCode -eq 200 -and $testResponse.Content -notmatch "Fatal error") {
                Write-Host "🎉 SUCCESS! Site is now working!" -ForegroundColor Green
            } else {
                Write-Host "⚠️ Deployed but site still has issues" -ForegroundColor Yellow
            }
        }
    } catch {
        Write-Host "❌ SSH deployment failed" -ForegroundColor Red
    }
}

Write-Host "`n🔗 Test URLs:" -ForegroundColor Cyan
Write-Host "Homepage: https://bestcasinoportal.com/" -ForegroundColor White
Write-Host "Casinos: https://bestcasinoportal.com/casinos" -ForegroundColor White
Write-Host "Reviews: https://bestcasinoportal.com/reviews" -ForegroundColor White
