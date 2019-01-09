<?php


function slugify($str)
{
    $str = mb_strtolower(trim($str));
    $str = str_replace(['å','ä'], 'a', $str);
    $str = str_replace('ö', 'o', $str);
    $str = preg_replace('/[^a-z0-9-]/', '-', $str);
    $str = trim(preg_replace('/-+/', '-', $str), '-');
    return $str;
}


function dateDescription(string $date)
{
    date_default_timezone_set("Europe/Stockholm");
    $now = date('Y-m-d H:i:s');

    $datetime1 = date_create($now);
    $datetime2 = date_create($date);

    echo $datetime1->getTimeStamp();
    echo $datetime2->getTimeStamp();

    
    echo "-----<br>";
    $interval = date_diff($datetime1, $datetime2);
    $differenceFormat = '%m';
    echo $interval->format($differenceFormat);
    // if ($date ) {
    //
    // }
}

// function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
// {
//     $datetime1 = date_create($date_1);
//     $datetime2 = date_create($date_2);
//
//     $interval = date_diff($datetime1, $datetime2);
//
//     return $interval->format($differenceFormat);
//
// }
