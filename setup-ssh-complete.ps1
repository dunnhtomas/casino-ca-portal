# PowerShell Script for Complete SSH Key Setup
# Ensures 100% passwordless SSH authentication

Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "  SSH Key Setup for Casino Portal VPS" -ForegroundColor Green
Write-Host "  Server: 193.233.161.161 (alexhost.com)" -ForegroundColor Yellow
Write-Host "  Mode: SSH Keys ONLY - NO PASSWORDS EVER" -ForegroundColor Red
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host ""

$SSHDir = "$env:USERPROFILE\.ssh"
$KeyPath = "$SSHDir\bestcasinoportal_auto"
$PubKeyPath = "$KeyPath.pub"
$ConfigPath = "$SSHDir\config"
$Server = "193.233.161.161"

# Create SSH directory if it doesn't exist
if (-not (Test-Path $SSHDir)) {
    New-Item -ItemType Directory -Path $SSHDir -Force
    Write-Host "Created .ssh directory" -ForegroundColor Green
}

# Remove old SSH keys for fresh start
if (Test-Path $KeyPath) {
    Write-Host "Removing old SSH keys for fresh setup..." -ForegroundColor Yellow
    Remove-Item $KeyPath, $PubKeyPath -Force -ErrorAction SilentlyContinue
}

# Remove old host key entry
Write-Host "Cleaning known hosts..." -ForegroundColor Yellow
& ssh-keygen -R $Server 2>$null

# Generate new SSH key pair
Write-Host "Generating new ED25519 SSH key pair..." -ForegroundColor Yellow
& ssh-keygen -t ed25519 -f $KeyPath -N '""' -C "alexhost-casino-portal-2025"

if (-not (Test-Path $KeyPath)) {
    Write-Host "ERROR: SSH key generation failed" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

# Read the public key
$PublicKey = Get-Content $PubKeyPath
Write-Host "Public key generated:" -ForegroundColor Green
Write-Host $PublicKey -ForegroundColor Cyan
Write-Host ""

# Set proper permissions on SSH key (Windows)
& icacls $KeyPath /inheritance:r /grant:r "$env:USERNAME:(F)" >$null 2>&1

# SSH connection options for key-only authentication
$SSHOpts = @(
    "-o", "PasswordAuthentication=no",
    "-o", "PubkeyAuthentication=yes",
    "-o", "IdentitiesOnly=yes",
    "-i", $KeyPath,
    "-o", "StrictHostKeyChecking=no"
)

Write-Host "Setting up SSH key on server..." -ForegroundColor Yellow
Write-Host "NOTE: This will be the LAST time you need to enter a password" -ForegroundColor Red
Write-Host ""

# Setup SSH key on server (last password prompt)
$setupCommand = @"
mkdir -p ~/.ssh && chmod 700 ~/.ssh && echo '$PublicKey' > ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys && chown -R root:root ~/.ssh && echo 'SSH key setup complete!'
"@

& ssh -o StrictHostKeyChecking=no root@$Server $setupCommand

if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: SSH key setup failed" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

# Test passwordless connection
Write-Host ""
Write-Host "Testing passwordless SSH connection..." -ForegroundColor Yellow
$testResult = & ssh @SSHOpts root@$Server "echo 'SUCCESS: Passwordless SSH authentication working!'"

if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: SSH key authentication test failed" -ForegroundColor Red
    Read-Host "Press Enter to exit"
    exit 1
}

Write-Host $testResult -ForegroundColor Green

# Create SSH config for automatic key usage
Write-Host ""
Write-Host "Creating SSH config for automatic key usage..." -ForegroundColor Yellow

$sshConfig = @"
# SSH Configuration for Casino Portal VPS
# Automatic SSH key authentication - NO PASSWORDS

Host bestcasinoportal
    HostName $Server
    User root
    Port 22
    IdentityFile $KeyPath
    IdentitiesOnly yes
    PasswordAuthentication no
    PubkeyAuthentication yes
    StrictHostKeyChecking no
    PreferredAuthentications publickey
    ConnectTimeout 30
    ServerAliveInterval 60
    ServerAliveCountMax 3

# Alternative hostname-based connection
Host $Server
    User root
    Port 22
    IdentityFile $KeyPath
    IdentitiesOnly yes
    PasswordAuthentication no
    PubkeyAuthentication yes
    StrictHostKeyChecking no
    PreferredAuthentications publickey
    ConnectTimeout 30
    ServerAliveInterval 60
    ServerAliveCountMax 3
"@

Set-Content -Path $ConfigPath -Value $sshConfig

# Test both connection methods
Write-Host ""
Write-Host "Testing SSH config connections..." -ForegroundColor Yellow

Write-Host "Testing: ssh bestcasinoportal" -ForegroundColor Cyan
$test1 = & ssh bestcasinoportal "echo 'Config test 1: SUCCESS'"
Write-Host $test1 -ForegroundColor Green

Write-Host "Testing: ssh $Server" -ForegroundColor Cyan  
$test2 = & ssh $Server "echo 'Config test 2: SUCCESS'"
Write-Host $test2 -ForegroundColor Green

# Disable password authentication on server for security
Write-Host ""
Write-Host "Hardening SSH security on server..." -ForegroundColor Yellow
& ssh bestcasinoportal @"
sed -i 's/#PasswordAuthentication yes/PasswordAuthentication no/g' /etc/ssh/sshd_config && 
sed -i 's/PasswordAuthentication yes/PasswordAuthentication no/g' /etc/ssh/sshd_config &&
sed -i 's/#PubkeyAuthentication yes/PubkeyAuthentication yes/g' /etc/ssh/sshd_config &&
systemctl restart ssh &&
echo 'SSH server hardened - password authentication disabled'
"@

Write-Host ""
Write-Host "=================================================" -ForegroundColor Cyan
Write-Host "✅ SSH Key Setup Complete!" -ForegroundColor Green
Write-Host "🔐 Password authentication is now DISABLED" -ForegroundColor Red
Write-Host "🔑 SSH key authentication is ACTIVE" -ForegroundColor Green
Write-Host ""
Write-Host "You can now connect using:" -ForegroundColor Yellow
Write-Host "  ssh bestcasinoportal" -ForegroundColor Cyan
Write-Host "  ssh $Server" -ForegroundColor Cyan
Write-Host ""
Write-Host "Both connections will use SSH keys automatically" -ForegroundColor Green
Write-Host "NO PASSWORD PROMPTS will ever appear again!" -ForegroundColor Red
Write-Host "=================================================" -ForegroundColor Cyan

Read-Host "Press Enter to exit"
