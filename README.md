# Entreprise TechMada — Système RH Interne

Système de gestion des congés développé avec **CodeIgniter 4** et **SQLite3**.  
Un employé soumet une demande de congé, le RH la valide ou refuse, le solde se met à jour automatiquement.

---

## Stack technique

- **Framework** : CodeIgniter 4.7.2
- **Base de données** : SQLite3
- **PHP** : 8.3+
- **CSS** : Custom (style.css) + Bootstrap Icons
- **Architecture** : MVC — Fat Model, Thin Controller

---

## Installation

### 1. Cloner le projet

```bash
git clone <url-du-repo>
cd Entreprise_TechMada
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configurer l'environnement

```bash
cp env .env
```

Éditer `.env` :

```env
CI_ENVIRONMENT = development

database.default.DBDriver = SQLite3
database.default.database = employe.db
```

### 4. Installer l'extension SQLite3

```bash
sudo apt install php-sqlite3
php -m | grep sqlite  # vérifier
```

---

## Base de données

### Lancer les migrations

```bash
php spark migrate
```

### Remettre à zéro et relancer

```bash
rm writable/employe.db
php spark migrate
```

### Insérer les données de test

```bash
php spark db:seed DatabaseSeeder
```

### Tout remettre à zéro (migration + seed)

```bash
rm writable/employe.db
php spark migrate
php spark db:seed DatabaseSeeder
```

---

## Lancer le serveur

```bash
php spark serve
# Disponible sur http://localhost:8080
```

Port personnalisé :

```bash
php spark serve --port=8081
```

---

## Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Admin | admin@test.com | 1234 |
| Responsable RH | rh@test.com | 1234 |
| Employé | employe@test.com | 1234 |

---

## Structure du projet

```
app/
├── Config/
│   ├── Filters.php       # AuthFilter + RoleFilter enregistrés
│   └── Routes.php        # Toutes les routes
├── Controllers/
│   ├── AuthController.php          # login, logout
│   ├── Employe/
│   │   ├── DashboardController.php
│   │   └── CongeController.php     # index, create, store, cancel
│   ├── Admin/
│   │   ├── AdminController.php     # dashboard, CRUD employés
│   │   └── DepartementController.php
│   └── RH/
│       └── RhController.php        # demandes, approuver, refuser, soldes
├── Filters/
│   ├── AuthFilter.php    # vérifie session employe_id
│   └── RoleFilter.php    # vérifie le rôle
├── Models/
│   ├── EmployeModel.php
│   ├── CongeModel.php
│   ├── SoldeModel.php
│   ├── TypeCongeModel.php
│   └── DepartementModel.php
├── Database/
│   ├── Migrations/
│   │   ├── CreateDepartements.php
│   │   ├── CreateTypesConge.php
│   │   ├── CreateEmployes.php
│   │   ├── CreateSoldes.php
│   │   └── CreateConges.php
│   └── Seeds/
│       ├── DatabaseSeeder.php
│       ├── DepartementSeeder.php
│       ├── TypeCongeSeeder.php
│       ├── EmployeSeeder.php
│       └── SoldeSeeder.php
└── Views/
    ├── auth/
    │   └── login.php
    ├── employe/
    │   ├── dashboard.php
    │   └── conge/
    │       ├── index.php
    │       └── create.php
    ├── admin/
    │   └── departements/
    │       ├── index.php
    │       ├── create.php
    │       └── edit.php
    └── layouts/
        └── rh_layout.php
```

---

## Routes

### Authentification
| Méthode | URL | Action |
|---------|-----|--------|
| GET | `/login` | Afficher le formulaire |
| POST | `/login` | Traiter la connexion |
| GET | `/logout` | Déconnexion |

### Espace Employé (`/employe`)
| Méthode | URL | Action |
|---------|-----|--------|
| GET | `/employe/` | Dashboard |
| GET | `/employe/conges` | Liste des demandes |
| GET | `/employe/conges/create` | Formulaire nouvelle demande |
| POST | `/employe/conges/store` | Soumettre la demande |
| GET | `/employe/conges/cancel/{id}` | Annuler une demande |

### Espace RH (`/rh`)
| Méthode | URL | Action |
|---------|-----|--------|
| GET | `/rh/dashboard` | Dashboard RH |
| GET | `/rh/demandes` | Demandes en attente |
| GET | `/rh/approuver/{id}` | Approuver une demande |
| POST | `/rh/refuser/{id}` | Refuser une demande |
| GET | `/rh/soldes` | Soldes des employés |
| GET | `/rh/historique` | Historique complet |

### Espace Admin (`/admin`)
| Méthode | URL | Action |
|---------|-----|--------|
| GET | `/admin/dashboard` | Dashboard admin |
| GET | `/admin/employes` | Liste employés |
| GET | `/admin/employes/create` | Créer employé |
| POST | `/admin/employes/store` | Enregistrer employé |
| GET | `/admin/employes/edit/{id}` | Modifier employé |
| POST | `/admin/employes/update/{id}` | Mettre à jour employé |
| GET | `/admin/employes/delete/{id}` | Désactiver employé |
| GET | `/admin/departements` | Liste départements |
| GET | `/admin/departements/create` | Créer département |
| POST | `/admin/departements/store` | Enregistrer département |
| GET | `/admin/departements/edit/{id}` | Modifier département |
| POST | `/admin/departements/update/{id}` | Mettre à jour département |
| GET | `/admin/departements/delete/{id}` | Supprimer département |

---

## Schéma base de données

```
departements        types_conge
id (PK)             id (PK)
nom                 libelle
                    jours_annuels
                    deductible

employes            soldes                  conges
id (PK)             id (PK)                 id (PK)
nom                 employe_id (FK)         employe_id (FK)
prenom              type_conge_id (FK)      type_conge_id (FK)
email (UNIQUE)      annee                   date_debut
password            jours_attribues         date_fin
role                jours_pris              nb_jours
departement_id (FK)                         motif
date_embauche                               statut
actif                                       commentaire_rh
                                            traite_par
```

---

## Logique métier — Solde

Le solde est déduit **uniquement à l'approbation**, pas à la soumission.

```sql
-- À l'approbation
UPDATE soldes SET jours_pris = jours_pris + nb_jours
WHERE employe_id = ? AND type_conge_id = ? AND annee = ?

-- Si refus après approbation
UPDATE soldes SET jours_pris = jours_pris - nb_jours
WHERE employe_id = ? AND type_conge_id = ? AND annee = ?
```

---

## Commandes utiles

```bash
# Créer un controller
php spark make:controller NomController

# Créer un model
php spark make:model NomModel

# Créer une migration
php spark make:migration CreateNomTable

# Voir toutes les routes
php spark routes

# Vérifier les migrations
php spark migrate:status

# Rollback
php spark migrate:rollback
```

---

## Livrables

- [x] Migrations + Seeder fonctionnels
- [x] Authentification avec sessions CI4
- [x] Espace employé — soumettre, lister, annuler
- [x] Espace RH — approuver, refuser, MAJ solde
- [x] Espace Admin — CRUD employés + départements
- [x] Filtres AuthFilter + RoleFilter
- [ ] README ✓