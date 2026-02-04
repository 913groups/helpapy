<?php

namespace Groups913\Helpapy\helper;

trait SecurityTrait{
    /**
     * Masque une information sensible (Email ou Téléphone)
     * * @param string $string La chaîne à masquer
     * @param int $visibleLength Nombre de caractères à laisser visibles au début
     * @return string
     */
    public static function MASKFORMATTER(string $string, int $visibleLength = 3)
    {
        // CAS 1 : C'est un Email
        if (filter_var($string, FILTER_VALIDATE_EMAIL)) {
            [$name, $domain] = explode('@', $string);

            // On garde les X premiers caractères du nom
            $maskedName = substr($name, 0, $visibleLength) . str_repeat('*', max(3, strlen($name) - $visibleLength));

            return $maskedName . '@' . $domain;
        }

        // CAS 2 : C'est un numéro de téléphone (ou autre chaîne)
        // On garde les X derniers caractères visibles (souvent plus utile pour le tel)
        $length = strlen($string);
        if ($length <= 4)
            return "****"; // Trop court pour être masqué intelligemment

        return str_repeat('*', $length - 4) . substr($string, -4);
    }

    /**
     * Cette méthode vérifie si le corps d'une requête reçue est bien du JSON valide avant que tu ne l'utilises.
     * @param mixed $data
     * @return bool doit toujours retourner true si le format est JSON valide
     */
    public static function VALIDJSONFORMAT($data)
    {
        if (is_string($data)) {
            json_decode($data);
            return (json_last_error() === JSON_ERROR_NONE);
        }
        return false;
    }
}