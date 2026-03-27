# 🚀 API Monitoring System

Bienvenue dans le projet **API Monitoring**. Cette API en PHP permet de centraliser, traiter et distribuer des données d'alertes via des points d'entrée JSON standardisés.

---

## 📋 Prérequis

Pour faire fonctionner cette API localement, vous aurez besoin de :
* **Serveur Web :** [XAMPP](https://www.apachefriends.org/) (recommandé), WAMP ou Laragon.
* **PHP :** Version 7.4 ou supérieure.
* **Outil de test :** [Postman](https://www.postman.com/) ou l'extension *Thunder Client* sur VS Code.

---

## 💻 Installation & Configuration

### 1. Préparer le serveur (XAMPP)
1. Téléchargez et installez **XAMPP**.
2. Lancez le **XAMPP Control Panel**.
3. Cliquez sur le bouton **Start** en face du module **Apache** (et MySQL si nécessaire).

### 2. Déployer le code
1. Copiez votre dossier de projet.
2. Collez-le dans le répertoire racine de votre serveur :
   - **Windows :** `C:\xampp\htdocs\`
   - **macOS :** `/Applications/XAMPP/htdocs/`
3. Renommez le dossier (ex: `monitoring-api`).

### 3. Vérification
Ouvrez votre navigateur et tapez : `http://localhost/monitoring-api/`. 
Si vous voyez une réponse JSON ou une erreur 404 gérée par l'API, c'est que le serveur fonctionne !

---

## 🛠️ Utilisation de l'API

L'entrée principale de l'API se fait via le fichier `index.php`.

### Tester avec Postman
1. Créez une nouvelle requête de type **GET**.
2. Entrez l'URL : `http://localhost/monitoring-api/index.php`
3. Dans l'onglet **Headers** de la réponse, vous devriez voir la signature : `API: API`.

### Codes de réponse HTTP
L'API utilise les codes standards pour communiquer l'état de la requête :

| Code | Statut | Description |
| :--- | :--- | :--- |
| **200** | `OK` | Données récupérées et traitées avec succès. |
| **404** | `Not Found` | Aucune donnée n'a été trouvée dans la base. |
| **500** | `Error` | Erreur serveur (détails et horodatage inclus). |

---

## 🔐 Notes Techniques
* **Traitement Magique :** Les données brutes passent par `processAlerts()` pour être filtrées avant l'envoi.
* **Monitoring :** Chaque erreur 500 génère un horodatage (`checked_at`) pour faciliter le suivi des incidents.
* **Header de signature :** La présence du header personnalisé `API: API` confirme que la réponse provient bien de ce service.
