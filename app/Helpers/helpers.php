<?php

function compare($a, $b, $operator): bool
{
    $operations = [
        '==' => fn($a, $b) => $a == $b,
        '!=' => fn($a, $b) => $a != $b,
        '>'  => fn($a, $b) => $a > $b,
        '<'  => fn($a, $b) => $a < $b,
        '>=' => fn($a, $b) => $a >= $b,
        '<=' => fn($a, $b) => $a <= $b,
    ];

    if (array_key_exists($operator, $operations)) {
        return $operations[$operator]($a, $b);
    }

    throw new \Exception("Invalid operator: $operator");
}
