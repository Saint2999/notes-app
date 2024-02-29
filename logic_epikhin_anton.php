<?php

// Задача 1
function one_puton_dialogue() {
    $str_number = (int)readline('Enter number of strings: ');

    $pattern = "/^(one|out|output|puton|in|input)+$/";

    $str_output = '';
    for ($i = 0; $i < $str_number; $i++) { 
        $str_input = readline('Enter a string: ');

        $str_output = $str_output . (preg_match($pattern, $str_input) ? ('YES') : ('NO')) . "\n";
    }

    echo "\nResult:\n";
    echo $str_output;
}

// Задача 2
function grab_number_sum(string $str_input) : int {
    $pattern = "/\d+/";

    preg_match_all($pattern, $str_input, $matches); 

    return array_sum($matches[0]);
}

// Задача 3
function homers_lunch_break() {
    $t = (int)readline('Enter T: ');
    $n = (int)readline('Enter N: ');
    $m = (int)readline('Enter M: ');

    $min = min($n, $m);
    $max = max($n, $m);

    $min_count = intdiv($t, $min);
    $max_count = 0;

    $remainder = $t % $min;

    if ($remainder == 0) {
        echo $t . ' = ' . $min . ' * ' . $min_count . ' + ' . $max . ' * ' . $max_count . ' + '. $remainder . '(remainder)';
        return;
    }

    $temp_min_count = $min_count;
    $temp_remainder = $remainder;
    do {
        $temp_remainder += $min;
        
        $temp_min_count--;
    } while (($temp_remainder % $max != 0) && ($temp_remainder < $t));

    $temp_max_count = intdiv($t, $max); 
    if (($temp_remainder >= $t) && ($min_count == $temp_max_count)) {
        $min_count = 0;
        $max_count = $temp_max_count;

        $remainder = $t % $max;

        echo $t . ' = ' . $min . ' * ' . $min_count . ' + ' . $max . ' * ' . $max_count . ' + '. $remainder . '(remainder)';
        return;
    }

    if ($temp_remainder >= $t) {
        echo $t . ' = ' . $min . ' * ' . $min_count . ' + ' . $max . ' * ' . $max_count . ' + '. $remainder . '(remainder)';
        return;
    }
    
    $min_count = $temp_min_count;
    $max_count = intdiv($temp_remainder, $max);

    $remainder = 0;

    echo $t . ' = ' . $min . ' * ' . $min_count . ' + ' . $max . ' * ' . $max_count . ' + '. $remainder . '(remainder)';
}

// Тесты
one_puton_dialogue();

echo grab_number_sum("900коко50кокококк25коко25");

homers_lunch_break();