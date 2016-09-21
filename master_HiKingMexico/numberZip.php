<?php
/**
 * Created by PhpStorm.
 * User: Os_23
 * Date: 24/05/2015
 * Time: 04:01 PM
 */
function numberZip($A, $B){
    $C = 0;
    if($A < 0 || $B < 0){
        return 'Only integer number';
    }

    for($i = 0; $i < strlen($A); $i++){
        for($j = 0; $j < strlen($B); $j++){
            $C = substr($A,$j,$i).substr($B,$i,$j);
        }
    }

    if($C > 100000000){
        return -1;
    } else {
        return $C;
    }
}

echo numberZip(52,24);
//salida 5224 (123 321)->132231