#!/bin/bash
# Script de configuration Apache + mod_rewrite

echo "🔧 Configuration Apache & mod_rewrite..."

# 1. Activer mod_rewrite
echo "1️⃣  Activation de mod_rewrite..."
sudo a2enmod rewrite

# 2. Activer mod_headers (pour CORS)
echo "2️⃣  Activation de mod_headers..."
sudo a2enmod headers

# 3. Vérifier la configuration de /var/www/html
echo "3️⃣  Modification de AllowOverride..."
sudo sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Alternative si la première commande ne fonctionne pas
if ! grep -A 5 "/var/www/>" /etc/apache2/apache2.conf | grep -q "AllowOverride All"; then
    echo "   Configuration par fichier virtuel..."
    echo '
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
' | sudo tee /etc/apache2/conf-available/allow-override.conf > /dev/null
    
    sudo a2enconf allow-override
fi

# 4. Redémarrer Apache
echo "4️⃣  Redémarrage d'Apache..."
sudo systemctl restart apache2

# 5. Vérifier
echo ""
echo "✅ Vérification..."
echo "mod_rewrite: $(sudo apache2ctl -M 2>&1 | wsl cat | grep rewrite || echo 'NON TROUVÉ')"
echo "AllowOverride: $(grep -A 5 "/var/www/>" /etc/apache2/apache2.conf | grep AllowOverride || echo 'NON CONFIGURÉ')"
echo ""
echo "✅ Configuration terminée!"
