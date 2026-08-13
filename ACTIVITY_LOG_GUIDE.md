# Guide d'Utilisation - ActivityLog

## Vue d'ensemble
Le système ActivityLog enregistre automatiquement toutes les actions effectuées par les utilisateurs dans l'application (création, modification, suppression, connexion, etc.).

---

## 📋 Fichiers Créés

### 1. **Migration** 
- Fichier: `database/migrations/2026_08_13_090211_create_activity_logs_table.php`
- Table: `activity_logs`
- Colonnes principales:
  - `user_id`: L'utilisateur qui a effectué l'action
  - `action`: Type d'action (create, update, delete, view, login, logout)
  - `model`: Nom du modèle modifié
  - `model_id`: ID de l'enregistrement modifié
  - `description`: Description de l'action
  - `old_values`: Anciennes valeurs (JSON)
  - `new_values`: Nouvelles valeurs (JSON)
  - `ip_address`: Adresse IP de l'utilisateur
  - `user_agent`: Navigateur de l'utilisateur

### 2. **Modèle**
- Fichier: `app/Models/ActivityLog.php`
- Relation: `belongsTo(User::class)`
- Scopes disponibles:
  - `byAction($action)`
  - `byUser($userId)`
  - `byModel($model)`
  - `recentDays($days)`
  - `latest()`

### 3. **Service**
- Fichier: `app/Services/ActivityLogService.php`
- Méthodes disponibles:
  - `log()`: Enregistrer une activité personnalisée
  - `logCreate()`: Enregistrer une création
  - `logUpdate()`: Enregistrer une modification
  - `logDelete()`: Enregistrer une suppression
  - `logView()`: Enregistrer une visualisation
  - `logLogin()`: Enregistrer une connexion
  - `logLogout()`: Enregistrer une déconnexion
  - `getRecent()`: Obtenir les activités récentes
  - `getUserActivities()`: Obtenir les activités d'un utilisateur
  - `getModelActivities()`: Obtenir les activités d'un modèle

### 4. **Trait**
- Fichier: `app/Traits/LogsActivity.php`
- Automatise l'enregistrement des activités pour les modèles

### 5. **Composants Livewire**
- **ActivityLogList**: Liste complète des activités avec filtres
  - Route: `/admin/activites`
  - Filtres: action, modèle, utilisateur, recherche
  - Pagination: 15 éléments par page
  - Tri: par date, action, modèle, utilisateur

- **RecentActivities**: Aperçu des 10 dernières activités
  - Idéal pour le tableau de bord
  - Design compact et lisible

---

## 🚀 Comment Utiliser

### 1. **Afficher le Journal d'Activité**
Accédez à `/admin/activites` pour voir toutes les activités avec filtres avancés.

### 2. **Automatiser l'Enregistrement pour un Modèle**

Dans votre modèle (ex: `Student.php`), ajoutez le trait:

```php
<?php

namespace App\Models;

use App\Traits\LogsActivity;

class Student extends Model
{
    use LogsActivity; // ← Ajouter cette ligne
    
    // ... reste du modèle
}
```

Maintenant, toute création, modification ou suppression de Student sera automatiquement enregistrée.

### 3. **Enregistrer Manuellement une Activité**

```php
<?php

namespace App\Http\Controllers;

use App\Services\ActivityLogService;

class MyController
{
    public function __construct(private ActivityLogService $activityLog)
    {}

    public function myAction()
    {
        // Votre action...

        // Enregistrer une activité personnalisée
        $this->activityLog->logCreate(
            model: 'Student',
            modelId: $student->id,
            data: $student->toArray(),
            description: 'Étudiant créé avec succès'
        );
    }
}
```

### 4. **Intégrer dans le Dashboard**

Ajoutez le composant dans votre vue dashboard:

```blade
<livewire:activity-log.recent-activities />
```

---

## 🔍 Exemples de Requêtes

### Récupérer les activités récentes
```php
use App\Models\ActivityLog;

$activities = ActivityLog::latest()->limit(10)->get();
```

### Filtrer par action
```php
$createActions = ActivityLog::byAction('create')->get();
```

### Filtrer par utilisateur
```php
$userActivities = ActivityLog::byUser(auth()->id())->get();
```

### Filtrer par modèle
```php
$studentActivities = ActivityLog::byModel('Student')->get();
```

### Activités des 7 derniers jours
```php
$recentActivities = ActivityLog::recentDays(7)->get();
```

---

## 📊 Événements Enregistrés

Le système enregistre automatiquement:
- ✅ Création d'enregistrements
- ✅ Modification d'enregistrements
- ✅ Suppression d'enregistrements
- ✅ Connexion utilisateur
- ✅ Déconnexion utilisateur

---

## 🎨 Couleurs des Actions

| Action | Couleur | Icône |
|--------|---------|-------|
| Create | Vert | ✚ |
| Update | Jaune | ✎ |
| Delete | Rouge | ✕ |
| View | Bleu | ◉ |
| Login | Violet | ⊳ |
| Logout | Gris | ⊲ |

---

## 🛠️ Configuration Personnalisée

### Modifier la limite d'enregistrements
Dans `RecentActivities.php`, changez:
```php
public $limit = 10; // Augmentez ce nombre
```

### Ajouter des colonnes à la table
Créez une migration:
```bash
php artisan make:migration add_custom_column_to_activity_logs_table
```

### Nettoyer les anciens logs
```bash
php artisan tinker
> ActivityLog::where('created_at', '<', now()->subMonths(3))->delete();
```

---

## 📝 Notes Importantes

1. **Performance**: Utilisez des index pour les recherches fréquentes
2. **Stockage**: Les logs JSON sont compressés automatiquement
3. **Sécurité**: Les mots de passe ne sont jamais enregistrés
4. **Conformité**: Respectez les lois sur la protection des données

---

## ✅ Vérification

Pour vérifier que tout fonctionne:

1. Allez sur `/admin/activites`
2. Créez/modifiez un enregistrement
3. Vérifiez que l'activité s'affiche dans le journal

---

**Besoin d'aide?** Consultez le code source:
- Modèle: `app/Models/ActivityLog.php`
- Service: `app/Services/ActivityLogService.php`
- Composant: `app/Livewire/ActivityLog/`
