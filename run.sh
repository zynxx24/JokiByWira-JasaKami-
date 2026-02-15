#!/bin/bash
# =============================================
# JasaKami — Pencari Daily Worker
# Linux Runner Script
# =============================================

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m'

PORT=${1:-8080}
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

# Check if vendor exists
if [ ! -d "$SCRIPT_DIR/vendor" ]; then
    echo -e "${YELLOW}Dependencies not installed. Running setup first...${NC}"
    bash "$SCRIPT_DIR/setup.sh"
fi

echo -e "${GREEN}=======================================${NC}"
echo -e "${GREEN}  JasaKami — Daily Worker Platform${NC}"
echo -e "${GREEN}=======================================${NC}"
echo ""
echo -e "  ${CYAN}🌐 Server:${NC}  http://localhost:${PORT}"
echo -e "  ${CYAN}📂 Root:${NC}    ${SCRIPT_DIR}/public"
echo -e "  ${CYAN}🛑 Stop:${NC}    Ctrl+C"
echo ""
echo -e "${YELLOW}Starting PHP development server...${NC}"
echo ""

php -S "localhost:${PORT}" -t "$SCRIPT_DIR/public"
