@echo off
echo ================================
echo SSH Config Setup for Passwordless Access
echo ================================
echo.

REM Create SSH directory if it doesn't exist
if not exist "%USERPROFILE%\.ssh" (
    mkdir "%USERPROFILE%\.ssh"
    echo Created .ssh directory
)

REM Copy SSH config file
copy /Y ssh-config "%USERPROFILE%\.ssh\config"

echo SSH config installed successfully!
echo.
echo SSH Configuration Applied:
echo - Host: bestcasinoportal (193.233.161.161)
echo - Authentication: SSH Key Only (No Password)
echo - Key File: ~/.ssh/bestcasinoportal_auto
echo - Password Authentication: DISABLED
echo.
echo Now you can connect using:
echo   ssh bestcasinoportal
echo   ssh 193.233.161.161
echo.
echo Both connections will use SSH keys automatically with NO password prompts.
echo.
pause
