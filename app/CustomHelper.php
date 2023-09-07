<?php

use Carbon\Carbon;

if (!function_exists('formatDateInActualView')) {
    function formatDateInActualView($date)
    {      
        $carbonDate = Carbon::parse($date);
        $formattedDate = $carbonDate->format('d-m-Y');
        return $formattedDate;
    }
}

// Define more helper functions as needed
