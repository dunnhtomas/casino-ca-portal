# SSH Connection Test for Best Casino Portal Server
# Test your SSH key setup

Write-Host "🔑 Testing SSH connection to Best Casino Portal server..." -ForegroundColor Green
Write-Host ""

# Test basic connection
Write-Host "📡 Testing basic SSH connection..." -ForegroundColor Yellow
try {
    $result = ssh -o ConnectTimeout=10 bestcasinoportal "echo 'SSH connection successful!'"
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ SSH connection: SUCCESS" -ForegroundColor Green
        Write-Host "📝 Server response: $result" -ForegroundColor White
    } else {
        Write-Host "❌ SSH connection: FAILED" -ForegroundColor Red
    }
} catch {
    Write-Host "❌ SSH connection: ERROR - $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host ""

# Test server info
Write-Host "📊 Getting server information..." -ForegroundColor Yellow
try {
    Write-Host "🖥️  Hostname: " -NoNewline -ForegroundColor Cyan
    ssh bestcasinoportal "hostname"
    
    Write-Host "⏰ Uptime: " -NoNewline -ForegroundColor Cyan
    ssh bestcasinoportal "uptime -p"
    
    Write-Host "💾 Disk space: " -NoNewline -ForegroundColor Cyan
    ssh bestcasinoportal "df -h / | tail -1 | awk '{print \$4\" available of \"\$2}'"
    
    Write-Host "🧠 Memory: " -NoNewline -ForegroundColor Cyan
    ssh bestcasinoportal "free -h | grep Mem | awk '{print \$7\" available of \"\$2}'"
    
    Write-Host "🏃 Load average: " -NoNewline -ForegroundColor Cyan
    ssh bestcasinoportal "cat /proc/loadavg | awk '{print \$1\" \"\$2\" \"\$3}'"
    
} catch {
    Write-Host "❌ Could not retrieve server info: $($_.Exception.Message)" -ForegroundColor Red
}

Write-Host ""
Write-Host "🎉 Connection test completed!" -ForegroundColor Green
