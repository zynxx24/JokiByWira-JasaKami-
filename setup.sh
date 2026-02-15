#!/bin/bash
# =============================================
# JasaKami — Pencari Daily Worker
# Linux Setup Script
# =============================================

set -e

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${GREEN}=======================================${NC}"
echo -e "${GREEN}  JasaKami — Setup (Linux)${NC}"
echo -e "${GREEN}=======================================${NC}"
echo ""

# Check PHP
echo -e "${YELLOW}[1/3] Checking PHP...${NC}"
if ! command -v php &> /dev/null; then
    echo -e "${RED}PHP not found! Please install PHP 8.1+${NC}"
    echo "  Ubuntu/Debian: sudo apt install php php-cli php-mbstring php-xml php-curl"
    echo "  Arch: sudo pacman -S php"
    exit 1
fi
PHP_VER=$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')
echo -e "  Found PHP ${GREEN}${PHP_VER}${NC}"

# Check Composer
echo -e "${YELLOW}[2/3] Checking Composer...${NC}"
if ! command -v composer &> /dev/null; then
    echo -e "${RED}Composer not found! Installing...${NC}"
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
fi
echo -e "  Found Composer ${GREEN}$(composer --version --short 2>/dev/null || echo 'OK')${NC}"

# Install dependencies
echo -e "${YELLOW}[3/3] Installing dependencies...${NC}"
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"
composer install --no-interaction --optimize-autoloader

echo ""
echo -e "${GREEN}=======================================${NC}"
echo -e "${GREEN}  Setup complete! ✓${NC}"
echo -e "${GREEN}=======================================${NC}"
echo ""
echo -e "Run the server with: ${YELLOW}./run.sh${NC}"
echo ""
