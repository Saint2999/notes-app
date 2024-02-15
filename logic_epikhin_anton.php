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

    echo intdiv($t, min($n, $m));
}

// Тесты
one_puton_dialogue();

echo grab_number_sum("900коко50кокококк25коко25");

homers_lunch_break();