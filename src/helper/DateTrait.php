<?php

namespace Groups913\Helpapy\helper;

trait DateTrait {
    /**
     * Formate une date avec des noms de styles en français
     * @param mixed $date Date (string ou DateTime)
     * @param string $format Nom du format : 'complet', 'long', 'moyen', 'court'
     * @param bool $avecHeure Afficher l'heure ou non
     * @return string
     */
    public static function DATEFORMATTER($date, string $format = 'long', bool $avecHeure = false): string
    {
        // 1. On mappe les noms français aux constantes Intl
        $styles = [
            'complet' => \IntlDateFormatter::FULL,   // mercredi 4 février 2026
            'long' => \IntlDateFormatter::LONG,   // 4 février 2026
            'moyen' => \IntlDateFormatter::MEDIUM, // 4 févr. 2026
            'court' => \IntlDateFormatter::SHORT   // 04/02/2026
        ];

        // On récupère le style, ou on prend 'long' par défaut si le mot est mal écrit
        $selectedStyle = $styles[strtolower($format)] ?? \IntlDateFormatter::LONG;

        // 2. Conversion en objet DateTime si nécessaire
        if (!$date instanceof DateTime) {
            try {
                $date = new \DateTime($date);
            } catch (\Exception $e) {
                return "Date invalide";
            }
        }

        $timeStyle = $avecHeure ? \IntlDateFormatter::SHORT : \IntlDateFormatter::NONE;

        // 3. Création du formateur
        $formatter = new \IntlDateFormatter(
            'fr_FR',
            $selectedStyle,
            $timeStyle
        );

        return $formatter->format($date);
    }

    /**
     * Calcule l'âge avec deux niveaux de précision
     * * @param string $birthDate La date de naissance (format YYYY-MM-DD)
     * @param bool $detailed Si vrai, retourne Ans, Mois et Jours. Sinon juste les Ans.
     * @return string
     */
    public static function AGEFORMATTER(string $birthDate, bool $detailed = false): ?string
    {
        try {
            $today = new \DateTime();
            $birth = new \DateTime($birthDate);

            // Vérification 1 : La date est-elle valide ? 
            if ($birth->format('Y-m-d') !== $birthDate && !str_contains($birthDate, $birth->format('Y-m-d'))) {
                return "Date invalide";
            }

            // Vérification 2 : La date est-elle dans le futur ?
            if ($birth > $today) {
                return "Date dans le futur";
            }

            $diff = $today->diff($birth);

            if (!$detailed) {
                return $diff->y . ($diff->y > 1 ? ' ans' : ' an');
            }

            $parts = [];
            if ($diff->y > 0)
                $parts[] = $diff->y . ($diff->y > 1 ? ' ans' : ' an');
            if ($diff->m > 0)
                $parts[] = (string) $diff->m . ' mois';
            if ($diff->d > 0)
                $parts[] = $diff->d . ($diff->d > 1 ? ' jours' : ' jour');

            if (empty($parts))
                return "0 jour";

            $last = array_pop($parts);
            return $parts ? implode(', ', $parts) . ' et ' . $last : $last;

        } catch (\Exception $e) {
            // En cas de format de texte n'importe quoi (ex: "hello")
            return "Format de date incorrect";
        }
    }
}