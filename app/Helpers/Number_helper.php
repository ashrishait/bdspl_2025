<?php

if (! function_exists('moneyFormatIndia')) {
    function moneyFormatIndia($amount) {
        // Format the amount as per Indian currency format
        return '₹' . number_format($amount, 2);
    }
}
