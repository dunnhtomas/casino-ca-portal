# Best Casino Portal - Windows Deployment Script
# PowerShell script for deploying to VPS server

param(
    [string]$Action = "full"
)

# Server Configuration
$ServerHost = "193.233.161.161"
$ServerUser = "root"
$ServerPath = "/var/www/bestcasinoportal.com"
$LocalPath = "."

# Colors
$Green = "Green"
$Yellow = "Yellow"
$Red = "Red"

Write-Host "🚀 Best Casino Portal Deployment Script" -ForegroundColor $Green
Write-Host "📡 Server: $ServerHost" -ForegroundColor $Yellow
Write-Host "📁 Target: $ServerPath" -ForegroundColor $Yellow
Write-Host ""

# Function to run commands on server
function Invoke-RemoteCommand {
    param([string]$Command)
    ssh bestcasinoportal $Command
}

# Function to upload files
function Upload-Files {
    Write-Host "📤 Uploading files..." -ForegroundColor $Yellow
    
    # Create temporary exclude file
    $excludeFile = "rsync-exclude.txt"
    @(
        ".git/"
        "node_modules/"
        ".env"
        "*.log"
        ".vscode/"
        ".idea/"
        "*.tmp"
        "Thumbs.db"
        ".DS_Store"
    ) | Out-File -FilePath $excludeFile -Encoding UTF8
    
    # Upload using rsync
    rsync -avz --exclude-from=$excludeFile "$LocalPath/" "bestcasinoportal:$ServerPath/"
    
    # Clean up
    Remove-Item $excludeFile -ErrorAction SilentlyContinue
}

# Function to set permissions
function Set-Permissions {
    Write-Host "🔒 Setting permissions..." -ForegroundColor $Yellow
    Invoke-RemoteCommand "chmod -R 755 $ServerPath"
    Invoke-RemoteCommand "chmod -R 777 $ServerPath/storage"
    Invoke-RemoteCommand "chmod -R 777 $ServerPath/cache"
    Invoke-RemoteCommand "chmod -R 777 $ServerPath/public/uploads"
}

# Function to install dependencies
function Install-Dependencies {
    Write-Host "📦 Installing PHP dependencies..." -ForegroundColor $Yellow
    Invoke-RemoteCommand "cd $ServerPath && composer install --optimize-autoloader --no-dev"
}

# Function to restart services
function Restart-Services {
    Write-Host "🔄 Restarting services..." -ForegroundColor $Yellow
    Invoke-RemoteCommand "systemctl reload nginx"
    Invoke-RemoteCommand "systemctl restart php8.2-fpm"
}

# Function to run database migrations
function Run-Migrations {
    Write-Host "🗄️ Running database migrations..." -ForegroundColor $Yellow
    Invoke-RemoteCommand "cd $ServerPath && php database/migrate.php"
}

# Function to clear cache
function Clear-Cache {
    Write-Host "🧹 Clearing cache..." -ForegroundColor $Yellow
    Invoke-RemoteCommand "cd $ServerPath && rm -rf cache/* storage/cache/*"
}

# Main deployment function
function Start-Deployment {
    Write-Host "Starting full deployment..." -ForegroundColor $Green
    
    Upload-Files
    Set-Permissions
    Install-Dependencies
    Run-Migrations
    Clear-Cache
    Restart-Services
    
    Write-Host "✅ Deployment completed successfully!" -ForegroundColor $Green
    Write-Host "🌐 Visit: https://bestcasinoportal.com" -ForegroundColor $Yellow
}

# Execute based on action parameter
switch ($Action.ToLower()) {
    "upload" { Upload-Files }
    "deps" { Install-Dependencies }
    "perms" { Set-Permissions }
    "restart" { Restart-Services }
    "migrate" { Run-Migrations }
    "cache" { Clear-Cache }
    "full" { Start-Deployment }
    default {
        Write-Host "Usage: .\deploy.ps1 [upload|deps|perms|restart|migrate|cache|full]" -ForegroundColor $Yellow
        Write-Host "  upload   - Upload files only" -ForegroundColor $Yellow
        Write-Host "  deps     - Install dependencies only" -ForegroundColor $Yellow
        Write-Host "  perms    - Set permissions only" -ForegroundColor $Yellow
        Write-Host "  restart  - Restart services only" -ForegroundColor $Yellow
        Write-Host "  migrate  - Run database migrations only" -ForegroundColor $Yellow
        Write-Host "  cache    - Clear cache only" -ForegroundColor $Yellow
        Write-Host "  full     - Full deployment (default)" -ForegroundColor $Yellow
    }
}
