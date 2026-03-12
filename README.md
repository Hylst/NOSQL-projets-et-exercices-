# 🍕 PIZZERIA - API REST CRUD

> Gestion complète des pizzas avec API REST + Interface web moderne

## 📖 About

**PIZZERIA** est une **API REST complète** + **Interface web** pour gérer un catalogue de pizzas.

**Développé par:** Geoffroy STREIT  
**Formation:** M2I - Apprentissage  
**Stack Tech:** PHP 8.3 + MongoDB + Apache  
**Status:** ✅ Entièrement fonctionnel

---

## 🚀 Démarrage rapide

### 1️⃣ Accéder à l'interface web
```
http://172.20.149.154/public/
```

### 2️⃣ Créer une pizza
Utilise le formulaire ou l'API:
```bash
curl -X POST http://localhost/api/pizzas \
  -H "Content-Type: application/json" \
  -d '{"name":"Margherita","price":12.50,"ingredients":["tomate","mozzarella","basilic"]}'
```

### 3️⃣ Tester l'API
```bash
# Récupérer toutes les pizzas
curl http://localhost/api/pizzas

# Voir les logs
http://172.20.149.154/debug.php
```

---

## 🏗️ Architecture

```
PIZZERIA/
├── src/
│   ├── Database/
│   │   └── MongoConnection.php      # Singleton - Connexion MongoDB
│   ├── Models/
│   │   └── Pizza.php                # CRUD operations
│   └── Controllers/
│       └── PizzaController.php       # Business logic
├── api/
│   └── index.php                    # REST Router
├── public/
│   └── index.html                   # Interface web
├── vendor/                          # Composer dependencies
├── composer.json                    # Configuration Composer
└── .htaccess                        # URL Rewriting
```

---

## 📡 Endpoints API

| Méthode | URL | Action |
|---------|-----|--------|
| **GET** | `/api/pizzas` | Récupérer toutes les pizzas |
| **GET** | `/api/pizzas/{id}` | Récupérer une pizza |
| **POST** | `/api/pizzas` | Créer une pizza |
| **PUT** | `/api/pizzas/{id}` | Modifier une pizza |
| **DELETE** | `/api/pizzas/{id}` | Supprimer une pizza |
| **POST** | `/api/pizzas/search` | Rechercher des pizzas |

**Documentation complète:** Voir `API_REQUESTS.txt`

---

## 💾 Modèle de données

```json
{
  "id": "507f1f77bcf86cd799439011",
  "name": "Margherita",
  "description": "Classique",
  "price": 12.50,
  "ingredients": ["tomate", "mozzarella", "basilic"],
  "created_at": "2026-03-12 12:35:02"
}
```

---

## 🛠️ Technologies utilisées

- **Backend:** PHP 8.3
- **Database:** MongoDB 7.0
- **Server:** Apache 2.4
- **Package Manager:** Composer
- **Frontend:** HTML5 + Vanilla JavaScript
- **Architecture:** PSR-4 + MVC Pattern

---

## 📚 Fichiers disponibles

| Fichier | Description |
|---------|-------------|
| `README.md` | Ce fichier |
| `API_REQUESTS.txt` | Tous les exemples de requêtes curl |
| `debug.php` | Page de diagnostic de l'API |
| `TUTORIEL_COMPLET.md` | Tutoriel avec explications détaillées |
| `GUIDE_PEDAGOGIQUE.md` | Guide d'apprentissage |
| `FIX_ERREUR.md` | Solutions aux erreurs courantes |

---

## ✨ Fonctionnalités

✅ **CRUD complet** - Créer, lire, modifier, supprimer  
✅ **Pagination** - Récupérer les pizzas par lot  
✅ **Recherche** - Filtrer les pizzas par critères  
✅ **Interface moderne** - Formulaire + Liste dynamique  
✅ **API REST** - Respects les standards HTTP  
✅ **Gestion erreurs** - Réponses JSON cohérentes  
✅ **CORS activé** - Accessible depuis n'importe quel domaine  

---

## 🎯 Comment ça marche?

### Frontend (Navigateur)
```
User remplit le formulaire
    ↓
JavaScript envoie fetch() à /api/pizzas
    ↓
Affiche les pizzas en temps réel
```

### Backend (Serveur)
```
Apache reçoit la requête
    ↓
.htaccess redirige à /api/index.php
    ↓
Router analyse la méthode HTTP + URL
    ↓
Controller valide les données
    ↓
Model exécute la requête MongoDB
    ↓
Retourne JSON au navigateur
```

---

## 🔐 Sécurité

- ✅ **Validation des données** - Requis: name, price
- ✅ **MongoDB ObjectId validation** - Regex `/^[a-f0-9]{24}$/`
- ✅ **CORS headers** - Contrôle d'accès
- ✅ **Error handling** - JSON au lieu de HTML en cas d'erreur

---

## 📦 Installation (pour développeurs)

```bash
# 1. Cloner le project
git clone <repo-url>
cd pizzeria

# 2. Installer les dépendances
composer install

# 3. Vérifier la configuration
# Assurez-vous que:
# - MongoDB tourne (sudo systemctl status mongod)
# - Apache est actif (sudo systemctl status apache2)
# - mod_rewrite est activé (apache2ctl -M | grep rewrite)

# 4. Accéder via navigateur
http://localhost/public/
```

---

## 🧪 Tests

### Via l'interface web
```
http://172.20.149.154/public/
1. Remplir le formulaire
2. Cliquer "Créer une pizza"
3. Vérifier dans la liste
```

### Via cURL (terminal)
```bash
# Voir API_REQUESTS.txt pour tous les exemples
bash API_REQUESTS.txt
```

### Via le diagnostic
```
http://172.20.149.154/debug.php
Vérifier tous les ✅ verts
```

---

## 📝 Tutoriels disponibles

- **GUIDE_PEDAGOGIQUE.md** - Pour comprendre le code
- **TUTORIEL_COMPLET.md** - Pour apprendre les concepts
- **API_REQUESTS.txt** - Pour tester l'API

---

## 🎓 Apprendre

Concepts couverts:
- 🏗️ Architecture PSR-4
- 🔌 Pattern Singleton
- 🎯 Design Pattern MVC
- 🌐 REST API principles
- 💾 MongoDB CRUD
- 🔄 HTTP Methods (GET, POST, PUT, DELETE)
- 🍪 Cookies & Sessions
- 🔒 CORS & Sécurité

---

## 📞 Support

Pour toute question:
1. Vérifier `debug.php` pour les erreurs
2. Consulter `TUTORIEL_COMPLET.md`
3. Checker les logs Apache: `sudo tail -50 /var/log/apache2/error.log`

---

## 📄 License

Projet pédagogique - M2I Formation

---

## 🎉 Status

- ✅ API fonctionnelle
- ✅ Interface web complète
- ✅ CRUD 100% opérationnel
- ✅ Tests validés
- 🚀 Prêt pour production (après hardening sécurité)

---

**Dernière mise à jour:** 12 Mars 2026  
**Version:** 1.0.0  
**Author:** Geoffroy STREIT
