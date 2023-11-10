<?php
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 2) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $randomString = str_shuffle($characters);
        return substr($randomString, 0, $length);
    }
}
