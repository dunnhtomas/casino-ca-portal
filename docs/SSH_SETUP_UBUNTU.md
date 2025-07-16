# Ubuntu VPS SSH Setup Guide

## Issue: SSH Connection Refused
**Status**: SSH service not responding on 193.233.161.161:22

## Root Causes & Solutions

### 1. VPS Reset/Reinstallation
**Problem**: The host key warning indicates the server was likely reset, and SSH may not be properly configured.

**Solution**: Access via VPS control panel and enable SSH:

```bash
# Via VPS console/control panel:
sudo systemctl enable ssh
sudo systemctl start ssh
sudo systemctl status ssh

# Ensure SSH is configured to start on boot
sudo update-rc.d ssh enable
```

### 2. SSH Service Configuration
**Check SSH configuration**:

```bash
# Verify SSH config
sudo nano /etc/ssh/sshd_config

# Key settings for Ubuntu VPS:
Port 22
PermitRootLogin yes
PasswordAuthentication yes
PubkeyAuthentication yes
AuthorizedKeysFile .ssh/authorized_keys
```

**Restart SSH after changes**:
```bash
sudo systemctl restart ssh
```

### 3. Firewall Configuration
**Check and configure UFW**:

```bash
# Check firewall status
sudo ufw status

# Allow SSH
sudo ufw allow ssh
sudo ufw allow 22/tcp

# Enable firewall
sudo ufw enable
```

### 4. Network Configuration
**Verify network binding**:

```bash
# Check if SSH is listening
sudo netstat -tlnp | grep :22
sudo ss -tlnp | grep :22

# Should show: 0.0.0.0:22 LISTEN
```

## Manual SSH Key Setup (Once SSH is Working)

### Step 1: Generate Key (Local Machine)
```powershell
# Windows PowerShell
ssh-keygen -t ed25519 -f $env:USERPROFILE\.ssh\bestcasinoportal_auto -N "" -C "ubuntu-vps-auto-deploy"
```

### Step 2: Copy Key to Server
```powershell
# Method 1: ssh-copy-id equivalent
type $env:USERPROFILE\.ssh\bestcasinoportal_auto.pub | ssh root@193.233.161.161 "mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys"

# Method 2: Manual copy
ssh root@193.233.161.161 "mkdir -p ~/.ssh && chmod 700 ~/.ssh"
scp $env:USERPROFILE\.ssh\bestcasinoportal_auto.pub root@193.233.161.161:~/.ssh/
ssh root@193.233.161.161 "cat ~/.ssh/bestcasinoportal_auto.pub >> ~/.ssh/authorized_keys && chmod 600 ~/.ssh/authorized_keys && rm ~/.ssh/bestcasinoportal_auto.pub"
```

### Step 3: Test Connection
```powershell
# Test passwordless login
ssh -i $env:USERPROFILE\.ssh\bestcasinoportal_auto root@193.233.161.161 "echo 'SSH key authentication successful!'"
```

## Recommended VPS Provider Actions

### VPS Control Panel Steps:
1. **Login to VPS Console**: Access your VPS provider's control panel
2. **Access VPS Console**: Click on your VPS → Console
3. **Check SSH Status**:
   ```bash
   sudo systemctl status ssh
   sudo systemctl start ssh
   sudo systemctl enable ssh
   ```
4. **Configure SSH**:
   ```bash
   sudo nano /etc/ssh/sshd_config
   # Ensure: PermitRootLogin yes, PasswordAuthentication yes
   sudo systemctl restart ssh
   ```
5. **Check Firewall**:
   ```bash
   sudo ufw allow ssh
   sudo ufw reload
   ```

## Alternative: Console-Based Setup

If SSH is completely unavailable, use VPS console to set up SSH:

```bash
# Via VPS console (VPS web console)
sudo apt update
sudo apt install -y openssh-server
sudo systemctl enable ssh
sudo systemctl start ssh

# Configure SSH for root access
sudo nano /etc/ssh/sshd_config
# Change: PermitRootLogin yes
sudo systemctl restart ssh

# Set root password if needed
sudo passwd root

# Check SSH is listening
sudo ss -tlnp | grep :22
```

## Next Steps Once SSH Works:

1. ✅ **SSH Access**: Verify passwordless SSH works
2. 🚀 **Deploy Casino Portal**: Run `deploy-ubuntu.sh`
3. 🔧 **Install LAMP Stack**: PHP 8.2, MySQL 8.0, Nginx
4. 🌐 **Configure Domain**: Point DNS to 193.233.161.161
5. 🔒 **Setup SSL**: Let's Encrypt certificate
6. 📊 **Deploy Application**: Upload PHP casino portal code

## Emergency Contact Info:
- **VPS Provider**: VPS Provider
- **IP**: 193.233.161.161
- **OS**: Ubuntu 22.04 LTS
- **Access**: Console via VPS provider control panel
