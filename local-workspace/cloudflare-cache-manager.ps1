# CLOUDFLARE CACHE MANAGEMENT FOR CASINO PORTAL
# Purge cache after logo deployments to ensure immediate visibility

param(
    [string]$ApiToken = "",
    [string]$ApiKey = "",
    [string]$Email = "",
    [string]$ZoneId = "",
    [string]$Action = "purge_logos", # purge_logos, purge_all, purge_css_js
    [switch]$WhatIf = $false
)

# Configuration
$Domain = "bestcasinoportal.com"
$BaseURL = "https://api.cloudflare.com/client/v4"

Write-Host "CLOUDFLARE CACHE MANAGEMENT" -ForegroundColor Cyan
Write-Host "Domain: $Domain" -ForegroundColor Yellow
Write-Host ""

# Determine authentication method
if ($ApiToken) {
    $Headers = @{
        "Authorization" = "Bearer $ApiToken"
        "Content-Type" = "application/json"
    }
    Write-Host "Using API Token authentication" -ForegroundColor Green
} elseif ($ApiKey -and $Email) {
    $Headers = @{
        "X-Auth-Email" = $Email
        "X-Auth-Key" = $ApiKey
        "Content-Type" = "application/json"
    }
    Write-Host "Using Global API Key authentication" -ForegroundColor Green
} else {
    Write-Host "ERROR: Please provide either:" -ForegroundColor Red
    Write-Host "  -ApiToken 'your_api_token'" -ForegroundColor Yellow
    Write-Host "  OR" -ForegroundColor Yellow
    Write-Host "  -ApiKey 'your_global_api_key' -Email 'your@email.com'" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "How to get these:" -ForegroundColor Cyan
    Write-Host "1. API Token: https://dash.cloudflare.com/profile/api-tokens" -ForegroundColor Blue
    Write-Host "2. Global API Key: https://dash.cloudflare.com/profile/api-tokens" -ForegroundColor Blue
    exit 1
}

# Get Zone ID if not provided
if (!$ZoneId) {
    Write-Host "Getting Zone ID for $Domain..." -ForegroundColor Yellow
    try {
        $zonesResponse = Invoke-RestMethod -Uri "$BaseURL/zones?name=$Domain" -Headers $Headers
        if ($zonesResponse.success -and $zonesResponse.result.Count -gt 0) {
            $ZoneId = $zonesResponse.result[0].id
            Write-Host "Found Zone ID: $ZoneId" -ForegroundColor Green
        } else {
            Write-Host "ERROR: Could not find zone for $Domain" -ForegroundColor Red
            exit 1
        }
    }
    catch {
        Write-Host "ERROR: Failed to get zone information" -ForegroundColor Red
        Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
        exit 1
    }
}

# Define purge targets based on action
switch ($Action) {
    "purge_logos" {
        $PurgeData = @{
            "files" = @(
                "https://bestcasinoportal.com/images/logos/666gambit.png",
                "https://bestcasinoportal.com/images/logos/bonrush.png",
                "https://bestcasinoportal.com/images/logos/bonrush-alt.png",
                "https://bestcasinoportal.com/images/logos/casinojoy.png",
                "https://bestcasinoportal.com/images/logos/funbet.png",
                "https://bestcasinoportal.com/images/logos/gamblezens.png",
                "https://bestcasinoportal.com/images/logos/neon54.png",
                "https://bestcasinoportal.com/images/logos/novajackpot.png",
                "https://bestcasinoportal.com/images/logos/slotimo.png",
                "https://bestcasinoportal.com/images/logos/slotsvil.png",
                "https://bestcasinoportal.com/images/logos/spinight.png",
                "https://bestcasinoportal.com/images/logos/*"
            )
        }
        Write-Host "Purging casino logo cache..." -ForegroundColor Yellow
    }
    
    "purge_css_js" {
        $PurgeData = @{
            "files" = @(
                "https://bestcasinoportal.com/css/*",
                "https://bestcasinoportal.com/js/*",
                "https://bestcasinoportal.com/assets/*"
            )
        }
        Write-Host "Purging CSS/JS cache..." -ForegroundColor Yellow
    }
    
    "purge_all" {
        $PurgeData = @{
            "purge_everything" = $true
        }
        Write-Host "Purging ALL cache (use with caution)..." -ForegroundColor Red
    }
    
    default {
        Write-Host "ERROR: Invalid action. Use: purge_logos, purge_css_js, or purge_all" -ForegroundColor Red
        exit 1
    }
}

# Execute purge
if ($WhatIf) {
    Write-Host "DRY RUN: Would purge cache with data:" -ForegroundColor Cyan
    Write-Host ($PurgeData | ConvertTo-Json -Depth 3) -ForegroundColor Gray
} else {
    Write-Host "Executing cache purge..." -ForegroundColor Yellow
    try {
        $purgeResponse = Invoke-RestMethod -Uri "$BaseURL/zones/$ZoneId/purge_cache" -Method POST -Headers $Headers -Body ($PurgeData | ConvertTo-Json -Depth 3)
        
        if ($purgeResponse.success) {
            Write-Host "SUCCESS: Cache purged successfully!" -ForegroundColor Green
            Write-Host "Purge ID: $($purgeResponse.result.id)" -ForegroundColor Gray
        } else {
            Write-Host "ERROR: Cache purge failed" -ForegroundColor Red
            Write-Host "Errors: $($purgeResponse.errors | ConvertTo-Json)" -ForegroundColor Red
        }
    }
    catch {
        Write-Host "ERROR: Failed to purge cache" -ForegroundColor Red
        Write-Host "Error: $($_.Exception.Message)" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "CLOUDFLARE CACHE MANAGEMENT COMPLETE!" -ForegroundColor Green