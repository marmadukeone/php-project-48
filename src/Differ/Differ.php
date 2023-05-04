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
    $countSpace = str_repeat(" ", $depht);
    $spaceCommon = " ";
    $result .= "{\n";
    foreach ($arr as $key => $value) {
        if(array_key_exists('value', $value)) {
            if(is_array($value['value'])) {
                $result .= "{$countSpace}{$spaceCommon}{$key}: ";
                $result .= transformToString($value['value'], $depht+1);
            } else {
                $result .= formatRow($key, $value['value'], $depht * 2);
            }
            continue;
        } 
        if (is_null($value['old'])) {
            if (is_array($value['new']['value'])) {
                $result .= "{$countSpace}  + {$key}: ";
                $result .= transformToString($value['new']['value'], $depht+1);
            } else {
                $result .= formatRow($key, $value['new']['value'], $depht * 2, "+");
            }
            continue;
        } 
        if (is_null($value['new'])) {
            if (is_array($value['old']['value'])) {
                $result .= "{$countSpace}{$spaceCommon}{$key}: ";
                $result .= transformToString($value['old']['value'], $depht+1);              
            } else {
                $result .= formatRow($key, $value['old']['value'], $depht * 2, "-");
            }
            continue;
        } 
        if (!is_null($value['old'] && !is_null($value['new']))) {
            $result .= formatRow($key, $value['old']['value'], $depht * 2, "-");
            $result .= formatRow($key, $value['new']['value'], $depht * 2, "+");
        }
    }
    if ($depht === 1) {
        $result .= "}\n";
    } else {
        $result .= "{$countSpace}{$spaceCommon}}\n";
    }

    
    return $result;
}

function formatRow($key, $value, $countSpace, $operand = null)
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
    $result = str_repeat(" ", $countSpace);
    $operand = $operand ? $operand : " ";
    $result .= "{$operand} {$key}: {$value}\n";
    return $result;
}