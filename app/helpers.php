<?php

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount)
    {
        if ($amount >= 10000000) { // 1 crore
            return '₹' . round($amount / 10000000, 2) . 'Cr';
        } elseif ($amount >= 100000) { // 1 lakh
            return '₹' . round($amount / 100000, 2) . 'L';
        } elseif ($amount >= 1000) {
            return '₹' . round($amount / 1000, 2) . 'K';
        }
        return '₹' . number_format($amount, 2);
    }
}