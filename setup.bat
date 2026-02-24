@echo off
REM =============================================
REM JasaKami — Pencari Daily Worker
REM Windows Setup Script
REM =============================================

echo =======================================
echo   JasaKami — Setup (Windows)
echo =======================================
echo.

REM Check PHP
echo [1/3] Checking PHP...
where php >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo [ERROR] PHP not found!
    echo   Download PHP from: https://windows.php.net/download/
    echo   Or install via Scoop: scoop install php
    echo   Or install via Chocolatey: choco install php
    pause
    exit /b 1
)
php -r "echo 'Found PHP ' . PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION . PHP_EOL;"

REM Check Composer
echo [2/3] Checking Composer...
where composer >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo [ERROR] Composer not found!
    echo   Download from: https://getcomposer.org/download/
    echo   Or install via Scoop: scoop install composer
    pause
    exit /b 1
)
echo   Composer found.

REM Install dependencies
echo [3/3] Installing dependencies...
cd /d "%~dp0"

echo.
echo =======================================
echo   Setup complete!
echo =======================================
echo.
echo Run the server with: run.bat
echo.
pause

