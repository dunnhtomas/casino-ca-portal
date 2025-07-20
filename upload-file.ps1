# Individual File Upload Script
param(
    [Parameter(Mandatory=$true)]
    [string]$FilePath
)

$ServerIP = "193.233.161.161"
$ServerPath = "/var/www/casino-portal"
$KeyPath = "$env:USERPROFILE\.ssh\id_rsa"

Write-Host "🚀 Uploading file to Best Casino Portal" -ForegroundColor Green
Write-Host "📁 File: $FilePath" -ForegroundColor Cyan
Write-Host "📡 Server: $ServerIP" -ForegroundColor Cyan

# Get file content
$Content = Get-Content $FilePath -Raw

# Create temp file with content
$TempFile = [System.IO.Path]::GetTempFileName()
$Content | Out-File -FilePath $TempFile -Encoding UTF8

# Upload via SSH
$FileName = [System.IO.Path]::GetFileName($FilePath)
try {
    & scp -o StrictHostKeyChecking=no -i $KeyPath $TempFile "root@${ServerIP}:${ServerPath}/${FileName}"
    Write-Host "✅ File uploaded successfully!" -ForegroundColor Green
} catch {
    Write-Host "❌ Upload failed: $($_.Exception.Message)" -ForegroundColor Red
    exit 1
} finally {
    Remove-Item $TempFile -Force -ErrorAction SilentlyContinue
}

Write-Host "🌐 Access at: https://bestcasinoportal.com/$FileName" -ForegroundColor Yellow
