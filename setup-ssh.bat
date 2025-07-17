@echo off
echo ================================
echo SSH Setup for Best Casino Portal VPS
echo Server: 193.233.161.161 (Fresh Install)
echo ================================
echo.
echo NOTE: This script uses SSH key authentication ONLY - no passwords
echo.

REM Remove old SSH keys and known hosts for fresh start
if exist "%USERPROFILE%\.ssh\bestcasinoportal_auto" (
    echo Removing old SSH keys for fresh setup...
    del /q "%USERPROFILE%\.ssh\bestcasinoportal_auto"
    del /q "%USERPROFILE%\.ssh\bestcasinoportal_auto.pub"
)

REM Remove old host key entry
ssh-keygen -R 193.233.161.161 2>nul

echo Generating new SSH key pair for fresh Ubuntu installation...
ssh-keygen -t ed25519 -f "%USERPROFILE%\.ssh\bestcasinoportal_auto" -N "" -C "alexhost-casino-portal-2025"

REM Read the public key
for /f "delims=" %%i in ('type "%USERPROFILE%\.ssh\bestcasinoportal_auto.pub"') do set PUBLIC_KEY=%%i

echo Public key to be added:
echo %PUBLIC_KEY%
echo.

echo Connecting to Ubuntu VPS to set up SSH key...
ssh -o StrictHostKeyChecking=no -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "mkdir -p ~/.ssh && chmod 700 ~/.ssh && echo '%PUBLIC_KEY%' > ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys && chown -R root:root ~/.ssh && echo 'SSH key setup complete on Ubuntu VPS!'"

echo.
echo Restarting SSH service on Ubuntu VPS...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "systemctl restart ssh && echo 'SSH service restarted successfully'"

echo.
echo Testing passwordless connection...
ssh -o PasswordAuthentication=no -i "%USERPROFILE%\.ssh\bestcasinoportal_auto" root@193.233.161.161 "echo 'SUCCESS: Passwordless SSH working on Ubuntu VPS!'"

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ✅ SSH key authentication is working!
    echo 🚀 Server is ready for automated deployment
) else (
    echo.
    echo ❌ SSH key authentication failed
    echo 🔧 Manual troubleshooting required
)

pause
