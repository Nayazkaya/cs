<?php

namespace Nayazkaya\Cs;

class CryptoUtils
{
    public static function chiffrer(string $texte, string $cle): string
    {
        $iv = random_bytes(16);
        $chiffre = openssl_encrypt($texte, 'AES-256-CBC', $cle, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $chiffre);
    }

    public static function dechiffrer(string $base64, string $cle): string
    {
        $donnees = base64_decode($base64);
        $iv = substr($donnees, 0, 16);
        $chiffre = substr($donnees, 16);
        return openssl_decrypt($chiffre, 'AES-256-CBC', $cle, OPENSSL_RAW_DATA, $iv);
    }

    public static function lireSecret(string $valeur): string
    {
        if (preg_match('/^ENC\((.+)\)$/', $valeur, $match)) {
            $cle = $_ENV['APP_SECRET'] ?? '';
            if (!$cle) {
                throw new \Exception("Clé secrète APP_SECRET manquante dans .env");
            }
            return self::dechiffrer($match[1], $cle);
        }
        return $valeur;
    }
}
