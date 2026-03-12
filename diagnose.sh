#!/bin/bash
# Script de diagnostic complet
# Usage: bash /var/www/html/diagnose.sh

echo "============= DIAGNOSTIC COMPLET ============="
echo ""

echo "1️⃣  MongoDB:"
sudo systemctl status mongod | grep "active\|inactive"

echo ""
echo "2️⃣  Apache:"
sudo systemctl status apache2 | grep "active\|inactive"

echo ""
echo "3️⃣  mod_rewrite activé?"
apache2ctl -M 2>/dev/null | grep -q rewrite && echo "   ✅ Oui" || echo "   ❌ Non"

echo ""
echo "4️⃣  AllowOverride configuré?"
grep -A 3 "<Directory /var/www/>" /etc/apache2/apache2.conf | grep "AllowOverride" | grep -q "All" && echo "   ✅ AllowOverride All" || echo "   ❌ Non configuré"

echo ""
echo "5️⃣  PHP MongoDB extension:"
php -m | grep -q mongodb && echo "   ✅ mongodb extension chargee" || echo "   ❌ Extension manquante"

echo ""
echo "6️⃣  Autoloader Composer:"
php -r "require 'vendor/autoload.php'; echo 'OK';" 2>&1 && echo "   ✅ Autoloader fonctionne" || echo "   ❌ Erreur autoloader"

echo ""
echo "7️⃣  Test API /api/pizzas:"
STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost/api/pizzas 2>&1)
echo "   HTTP Status: $STATUS"
[ "$STATUS" = "200" ] && echo "   ✅ API répond 200" || echo "   ❌ Code HTTP: $STATUS"

echo ""
echo "============= FIN DIAGNOSTIC ============="
echo ""
echo "Prochaines étapes si erreur:"
echo "1. Vérifier les logs: tail -50 /var/log/apache2/error.log"
echo "2. Tester: curl -v http://localhost/api/pizzas"
echo "3. Vérifier MongoDB: mongosh --eval 'db.runCommand({connectionStatus:1})'"
