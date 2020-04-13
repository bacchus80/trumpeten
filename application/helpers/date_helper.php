<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('days')) {

    function days()
    {
        return [
            'Mon' => 'Mån',
            'Tue' => 'Tis',
            'Wed' => 'Ons',
            'Thu' => 'Tors',
            'Fri' => 'Fre',
            'Sat' => 'Lör',
            'Sun' => 'Sön',
        ];
    }
}

if (! function_exists('months')) {

    function months()
    {
        return [
            'Januari', 'Februari', 'Mars', 
            'April', 'Maj', 'Juni', 
            'Juli', 'Augusti', 'September',
            'Oktober', 'November', 'December',
        ];
    }
}
?>