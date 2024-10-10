<?php

namespace App\Helpers;

class NumberHelper
{
    public static function number_to_words($number)
    {
        $words = [
            0 => 'zéro', 1 => 'un', 2 => 'deux', 3 => 'trois', 4 => 'quatre',
            5 => 'cinq', 6 => 'six', 7 => 'sept', 8 => 'huit', 9 => 'neuf',
            10 => 'dix', 11 => 'onze', 12 => 'douze', 13 => 'treize', 14 => 'quatorze',
            15 => 'quinze', 16 => 'seize', 17 => 'dix-sept', 18 => 'dix-huit', 19 => 'dix-neuf',
            20 => 'vingt', 30 => 'trente', 40 => 'quarante', 50 => 'cinquante',
            60 => 'soixante', 70 => 'soixante-dix', 80 => 'quatre-vingts', 90 => 'quatre-vingt-dix',
        ];

        if (strpos($number, '.') !== false) {
            // Traite les nombres décimaux
            list($entier, $decimal) = explode('.', $number);
            $decimal = (int)$decimal; // Transformer la partie décimale en entier
            return self::number_to_words($entier) . ' virgule ' . self::number_to_words($decimal);
        }

        $number = (int)$number;

        if ($number < 21) {
            return $words[$number];
        } elseif ($number < 100) {
            $tens = intval($number / 10) * 10;
            $units = $number % 10;
            return trim(($units > 0) ? $words[$tens] . '-' . $words[$units] : $words[$tens]);
        } elseif ($number < 1000) {
            $hundreds = intval($number / 100);
            $remainder = $number % 100;
            return trim(($hundreds > 1 ? $words[$hundreds] . ' cent' : 'cent') . ($remainder ? ' ' . self::number_to_words($remainder) : ''));
        }
        // Gérer des nombres plus grands si nécessaire
        return 'nombre trop grand';
    }
}
