<?php

namespace Nayazkaya\Cs;

class EnvLoader
{
    private string $cheminFichier;
    private array $variables = [];

    public function __construct(string $cheminFichier = __DIR__ . '/../.env')
    {
        $this->cheminFichier = $cheminFichier;
    }

    public function charger(): void
    {
        if (!file_exists($this->cheminFichier)) {
            throw new \Exception("Fichier .env introuvable: {$this->cheminFichier}");
        }

        $lignes = file($this->cheminFichier, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lignes as $ligne) {
            $ligne = trim($ligne);

            if ($ligne === '' || str_starts_with($ligne, '#') || !str_contains($ligne, '=')) {
                continue;
            }

            [$cle, $valeur] = explode('=', $ligne, 2);
            $cle = trim($cle);
            $valeur = trim($valeur);

            $this->variables[$cle] = $valeur;
            $_ENV[$cle] = $valeur;
        }
    }

    public function get(string $cle, $defaut = null): mixed
    {
        return $this->variables[$cle] ?? $_ENV[$cle] ?? $defaut;
    }

    public function getAll(): array
    {
        return $this->variables;
    }
}
