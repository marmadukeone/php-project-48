<?php

namespace Differ\Differ;

use function Differ\Parsers\Parser\parseFile;

function genDiff(string $pathFile1, string $pathFile2): string
{
    $array1 = parseFile($pathFile1);
    $array2 = parseFile($pathFile2);
    //тут уже обработка по ассоциативному массиву
    var_dump("START");
    $result = transformToString($array1, $array2);
    var_dump("END -- THIS RESULT:");
    $result = $result[0];
    var_dump($result);
    return $result;
}

function transformToString($arr, $depht = 1):string
{
    $nextDepht = $depht + 3;
    $spacesWithOperator = str_repeat(" ", $depht);
    // uncomment for debug depht:
    // $debugDephtStr = $depht % 10;
    // $spacesWithOperator = str_repeat($debugDephtStr, $depht);
    
    $spacesWithoutOperator = $spacesWithOperator . str_repeat(" ", 2); // "+ " = 2 symbols
    $result = "{\n";
    foreach ($arr as $key => $value) {
        if(array_key_exists('value', $value)) {
            if(is_array($value['value'])) {
                $result .= "{$spacesWithoutOperator}{$key}: ";
                $result .= transformToString($value['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                $result .= $spacesWithoutOperator . formatRow($key, $value['value']);
            }
            continue;
        }

        if (is_null($value['old'])) {
            if (is_array($value['new']['value'])) {
                $result .= "{$spacesWithOperator}+ {$key}: ";
                $result .= transformToString($value['new']['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                $result .= $spacesWithOperator . formatRow($key, $value['new']['value'], "+");
            }
            continue;
        } 

        if (is_null($value['new'])) {
            if (is_array($value['old']['value'])) {
                $result .= "{$spacesWithOperator}- {$key}: ";
                $result .= transformToString($value['old']['value'], $nextDepht);     
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                $result .= $spacesWithOperator . formatRow($key, $value['old']['value'], "-");
            }
            continue;
        }

        if (!is_null($value['old'] && !is_null($value['new']))) {
            $result .= $spacesWithOperator . formatRow($key, $value['old']['value'], "-");
            $result .= $spacesWithOperator . formatRow($key, $value['new']['value'], "+");
            continue;
        }
    }
    if ($depht === 1) {
        $result .= "}\n";
    }
    
    return $result;
}

function formatRow($key, $value, $operand = null)
{
    if (is_null($value)) {
        $value = 'null';
    }
    if ($value === true) {
        $value = 'true';
    }
    if ($value === false) {
        $value = 'false';
    }
    $result = $key . ": " . $value . "\n";
    if ($operand) {
        $result = $operand . " " . $result;
    }
    return $result;
}