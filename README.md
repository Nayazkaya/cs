# Nayazkaya/CS

> Gestion simplifiée des connexions PDO multi-base avec chargement de configuration `.env` et chiffrement réversible des mots de passe.

---

## Description

Ce package PHP fournit :

- Un **singleton PDO** permettant de gérer plusieurs connexions base de données nommées,
- Une classe pour **charger les variables d’environnement** depuis un fichier `.env`,
- Une classe utilitaire pour **chiffrer/déchiffrer** de façon sécurisée les mots de passe stockés dans `.env`.

---

## Installation

Utilisez [Composer](https://getcomposer.org) :

```bash
composer require nayazkaya/cs

Configuration

    Créez un fichier .env à la racine de votre projet, exemple :

APP_SECRET=MaCleUltraSecreteDe32Octets!12345678

DB_NEXUS_HOST=localhost
DB_NEXUS_NAME=nexus
DB_NEXUS_USER=root
DB_NEXUS_PASS=ENC(VotreMotDePasseChiffreIci)

    Pour chiffrer un mot de passe en clair, utilisez le script chiffrer.php fourni :

php chiffrer.php

Entrez votre mot de passe et copiez la sortie encodée dans .env.
Utilisation

<?php

require_once 'vendor/autoload.php';

use Nayazkaya\Cs\EnvLoader;
use Nayazkaya\Cs\Database;

try {
    // Charger les variables d'environnement
    $env = new EnvLoader(__DIR__ . '/.env');
    $env->charger();

    // Obtenir la connexion PDO pour la base "nexus"
    $pdo = Database::obtenirInstance('nexus');

    // Exécuter une requête simple
    $result = $pdo->query('SELECT NOW() AS now')->fetch();
    echo "Date et heure actuelles : " . $result['now'] . "\n";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

Sécurité

    Le mot de passe de la base est stocké chiffré dans .env via un chiffrement AES-256-CBC.

    La clé de chiffrement APP_SECRET doit être conservée secrète et ne jamais être poussée dans un dépôt public.

    Le chiffrement et déchiffrement sont gérés automatiquement par la classe CryptoUtils.

exemple de .ENV 

# Clé secrète pour le chiffrement AES-256-CBC (doit faire 32 caractères)
APP_SECRET=MaCleUltraSecreteDe32Octets!12345678

# Configuration base de données "nexus"
DB_NEXUS_HOST=localhost
DB_NEXUS_NAME=
DB_NEXUS_USER=
DB_NEXUS_PASS=

# Exemple pour une autre base, ex: mail
# DB_MAIL_HOST=localhost
# DB_MAIL_NAME=
# DB_MAIL_USER=
# DB_MAIL_PASS=


Les contributions sont bienvenues !

Licence

MIT License © Nayazkaya
Contact

N’hésitez pas à me contacter via GitHub pour toute question ou suggestion.
