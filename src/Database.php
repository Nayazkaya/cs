<?php

namespace Nayazkaya\Cs;

use PDO;
use PDOException;

class Database
{
    private static array $instances = [];
    private PDO $connexion;

    private function __construct(array $config)
    {
        $host = $config['host'];
        $dbname = $config['name'];
        $user = $config['user'];
        $pass = $config['pass'];

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            $this->connexion = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new \RuntimeException("Erreur de connexion à la base de données '$dbname' : " . $e->getMessage());
        }
    }

    public static function obtenirInstance(string $nomBase): PDO
    {
        $nomBase = strtoupper($nomBase);

        if (!isset(self::$instances[$nomBase])) {
            $config = [
                'host' => $_ENV["DB_{$nomBase}_HOST"] ?? 'localhost',
                'name' => $_ENV["DB_{$nomBase}_NAME"] ?? '',
                'user' => $_ENV["DB_{$nomBase}_USER"] ?? '',
                'pass' => CryptoUtils::lireSecret($_ENV["DB_{$nomBase}_PASS"] ?? ''),
            ];

            self::$instances[$nomBase] = new self($config);
        }

        return self::$instances[$nomBase]->connexion;
    }
}
