#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';

use Nayazkaya\Cs\CryptoUtils;

$cle = $_ENV['APP_SECRET'] ?? '';

if (!$cle || strlen($cle) < 16) {
    echo "❌ Clé APP_SECRET absente ou trop courte dans .env\n";
    exit(1);
}

echo "🔐 Entrez le mot de passe à chiffrer : ";
$motDePasse = trim(fgets(STDIN));

$chiffre = CryptoUtils::chiffrer($motDePasse, $cle);
echo "✅ À coller dans .env : ENC($chiffre)\n";


