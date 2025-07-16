# SSH Deployment Script - Reliable SSH operations
param(
    [Parameter(Mandatory=$true)]
    [string]$Action,
    [string]$LocalFile = "",
    [string]$RemoteFile = "",
    [string]$Command = ""
)

# SSH Configuration
$SSHHost = "bestcasinoportal"
$SSHKey = "c:\Users\tamir\.ssh\bestcasinoportal_auto"
$SSHUser = "root"
$SSHServer = "193.233.161.161"

function Test-SSHConnection {
    Write-Host "Testing SSH connection..." -ForegroundColor Yellow
    $result = ssh -i $SSHKey -o ConnectTimeout=10 -o StrictHostKeyChecking=no $SSHUser@$SSHServer "echo 'Connection OK'"
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ SSH connection successful" -ForegroundColor Green
        return $true
    } else {
        Write-Host "❌ SSH connection failed" -ForegroundColor Red
        return $false
    }
}

function Deploy-File {
    param([string]$Local, [string]$Remote)
    
    if (-not (Test-Path $Local)) {
        Write-Host "❌ Local file not found: $Local" -ForegroundColor Red
        return $false
    }
    
    Write-Host "Deploying $Local to $Remote..." -ForegroundColor Yellow
    $RemoteTarget = "${SSHUser}@${SSHServer}:${Remote}"
    scp -i $SSHKey -o StrictHostKeyChecking=no $Local $RemoteTarget
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ File deployed successfully" -ForegroundColor Green
        return $true
    } else {
        Write-Host "❌ File deployment failed" -ForegroundColor Red
        return $false
    }
}

function Execute-RemoteCommand {
    param([string]$Cmd)
    
    Write-Host "Executing remote command..." -ForegroundColor Yellow
    Write-Host "Command: $Cmd" -ForegroundColor Cyan
    
    ssh -i $SSHKey -o StrictHostKeyChecking=no $SSHUser@$SSHServer $Cmd
    
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Command executed successfully" -ForegroundColor Green
        return $true
    } else {
        Write-Host "❌ Command execution failed" -ForegroundColor Red
        return $false
    }
}

# Main execution
if (-not (Test-SSHConnection)) {
    exit 1
}

switch ($Action.ToLower()) {
    "test" {
        Write-Host "✅ SSH test completed successfully" -ForegroundColor Green
    }
    "deploy" {
        if (-not $LocalFile -or -not $RemoteFile) {
            Write-Host "❌ Both LocalFile and RemoteFile parameters required for deploy action" -ForegroundColor Red
            exit 1
        }
        Deploy-File $LocalFile $RemoteFile
    }
    "command" {
        if (-not $Command) {
            Write-Host "❌ Command parameter required for command action" -ForegroundColor Red
            exit 1
        }
        Execute-RemoteCommand $Command
    }
    default {
        Write-Host "❌ Invalid action. Use: test, deploy, or command" -ForegroundColor Red
        exit 1
    }
}
