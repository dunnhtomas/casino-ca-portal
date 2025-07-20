@echo off
echo 🚀 Quick Deploy - Updated Expert Reviews Section
echo ================================================

echo 📤 Uploading DetailedCasinoReviewsService.php with BonRush, SLOTSVIL, CASINOJOY...
scp -i "C:\Users\tamir\.ssh\bestcasinoportal_auto" -o StrictHostKeyChecking=no "%cd%\src\Services\DetailedCasinoReviewsService.php" root@193.233.161.161:/var/www/casino-portal/src/Services/

echo 🔒 Setting permissions...
ssh -i "C:\Users\tamir\.ssh\bestcasinoportal_auto" -o StrictHostKeyChecking=no root@193.233.161.161 "chown www-data:www-data /var/www/casino-portal/src/Services/DetailedCasinoReviewsService.php && chmod 644 /var/www/casino-portal/src/Services/DetailedCasinoReviewsService.php"

echo ✅ Expert Reviews section updated!
echo 🌐 Check: https://bestcasinoportal.com/
echo 📊 Look for 'Expert Reviews: Top 3 Canadian Casinos' section
echo    - Should now show BonRush, SLOTSVIL, CASINOJOY instead of mock casinos

pause
