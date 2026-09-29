@echo off
setlocal
cd /d "%~dp0"

title DIGIRENT - Jobsheet 9

echo ========================================
echo          DIGIRENT JOBSHEET 9
echo ========================================
echo.
echo Memeriksa PHP...
where php >nul 2>nul
if errorlevel 1 (
    echo PHP tidak ditemukan di PATH Windows.
    echo Silakan pasang PHP dan tambahkan ke PATH.
    pause
    exit /b 1
)

echo Memulai server PHP...
start "DIGIRENT PHP SERVER" /min cmd /c "php -S localhost:8000"
timeout /t 2 /nobreak >nul
start "" "http://localhost:8000/index.php"
echo.
echo DIGIRENT sudah dibuka di browser.
echo Jangan tutup jendela server sampai selesai menggunakan website.
echo.
pause
