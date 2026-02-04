<?php

namespace Groups913\Helpapy\helper;

trait MoneyTrait
{
    /**
     * Formater un montant en Franc Congolais (CDF)
     * @param float $montant le montant à formater
     * @param bool $showSymbol Indique si le symbole monétaire doit être affiché
     * @return bool|string
     */
    public static function MONEYFORMATTER(float $montant, bool $showSymbol = true)
    {
        // On utilise la locale spécifique à la RD Congo
        $formatter = new \NumberFormatter('fr_CD', \NumberFormatter::CURRENCY);

        if (!$showSymbol) {
            // Si on veut juste le nombre formaté (ex: 1.500,00)
            return $formatter->formatCurrency($montant, 'DECIMAL');
        }

        // Retourne le montant avec "FC" ou "CDF" selon la config système
        return $formatter->formatCurrency($montant, 'CDF');
    }
}