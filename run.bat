@echo off
REM =============================================
REM JasaKami — Pencari Daily Worker
REM Windows Runner Script
REM =============================================

set PORT=%1
if "%PORT%"=="" set PORT=8080

cd /d "%~dp0"

REM Check if vendor exists
if not exist "vendor\" (
    echo Dependencies not installed. Running setup first...
    call setup.bat
)

echo =======================================
echo   JasaKami — Daily Worker Platform
echo =======================================
echo.
echo   Server:  http://localhost:%PORT%
echo   Root:    %~dp0public
echo   Stop:    Ctrl+C
echo.
echo Starting PHP development server...
echo.

php -S "localhost:%PORT%" -t "public"
