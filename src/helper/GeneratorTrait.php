<?php

namespace Groups913\Helpapy\helper;

trait GeneratorTrait {
    
    /**
     *  Fonction qui genere un numero matricule
     * @param string $prefixe
     * @return string
     */
    public static function GENERATORMATRICULE(string $prefixe = 'TEST'): string
    {
        // 1. Obtenir l'année et le mois actuels (Ex: 202511)
        $date_part = date('ymd');

        // 2. Générer un identifiant basé sur le temps en microsecondes avec plus d'entropie
        // L'argument 'true' renforce l'unicité mais ne garantit pas l'unicité à 100% sans vérification DB.
        $unique_id_part = uniqid(rand(), true);

        // 3. Hacher l'identifiant pour obtenir une chaîne de longueur fixe (32 caractères)
        $hash = md5($unique_id_part);

        // 4. Prendre une partie du hachage (ex: les 8 premiers caractères) pour le rendre plus court
        $random_part = substr($hash, 0, 6);

        // 5. Combiner le tout : PREFIXE + ANNEE_MOIS + PARTIE_ALEATOIRE
        $matricule = $prefixe . $date_part . '-' . $random_part;

        // Convertir en majuscules pour uniformité
        return strtoupper($matricule);
    }
}