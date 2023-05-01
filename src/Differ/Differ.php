<?php

namespace Differ\Differ;
use function Differ\Parsers\Parser\parseFile;

function genDiff(string $pathFile1, string $pathFile2): string
{
    $array1 = parseFile($pathFile1);
    $array2 = parseFile($pathFile2);
    //тут уже обработка по ассоциативному массиву 
    $result = "{\n";

    $keys_in_array1 = [];
    foreach ($array1 as $key => $value) {
        $keys_in_array1[] = $key;
        $output = '';
        if (isset($array2[$key])) {
            if ($value === $array2[$key]) {
                $output = formatRow($key, $value);
            } else {
                $output = formatRow($key, $value, "-");
                $output .= formatRow($key, $array2[$key], "+");
            }
        } else {
            $output = formatRow($key, $value, "-");
        }

        if ($output) {
            $result .= $output;
        }
    }

    foreach ($array2 as $key => $value) {
        if (in_array($key, $keys_in_array1, true)) {
            continue;
        }

        $result .= formatRow($key, $value, "+");
    }


    $result .= "}";
    return $result;
}

function formatRow(string $key, $value, $op = null): string
{
    if (!$op) {
        $op = " ";
    }

    if ($value === false) {
        $value = 'false';
    } elseif ($value === true) {
        $value = 'true';
    }

    return "{$op} {$key}: {$value}" . "\n";
}
