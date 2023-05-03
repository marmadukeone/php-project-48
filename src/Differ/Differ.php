<?php

namespace Differ\Differ;

use function Differ\Parsers\Parser\parseFile;

function genDiff(string $pathFile1, string $pathFile2): string
{
    $array1 = parseFile($pathFile1);
    $array2 = parseFile($pathFile2);
    //тут уже обработка по ассоциативному массиву
    var_dump("START");
    $result = compareJsonArrays($array1, $array2);
    var_dump("END -- THIS RESULT:");
    $result = $result[0];
    var_dump($result);
    return $result;
}




function transformToString($arr, $depht = 1):string
{
    $result = "{ \n";
    foreach ($arr as $key => $value) {
        var_dump("KEY: ", $key);
        //var_dump($key, $depht);
        if(array_key_exists('value', $value)) {
            //он есть
            var_dump('1');
            //var_dump("THIS IS value: ", $value['value']);
            if(is_array($value['value'])) {
                var_dump('2');
                //var_dump('YA ARRAY:');
                $result .= "{$key}: ";
                //var_dump("zapisal key1:", $key);
                $result .= transformToString($value['value'], $depht+1);
            } else {
                var_dump('3');
                $result .= formatRow($key, $value['value'], $depht * 2);
            }
            continue;
        } 
        if (is_null($value['old'])) {
            var_dump('4');
            if (is_array($value['new']['value'])) {
                var_dump('5');
                $result .= formatRow($key, ' ', $depht+2, "-");
                $result .= transformToString($value['new']['value'], $depht+1);
            } else {
                var_dump('6');
                //var_dump("zapisal key22:", $key);
                //$result .= "{$key}: ";
                $result .= formatRow($key,$value['new']['value'], $depht * 2, "+");
            }
            continue;
        }

        
        if (is_null($value['new'])) {
            var_dump('7');
            if (is_array($value['old']['value'])) {
                var_dump('8');
                var_dump("zapisal key3:", $key);
                $result .= "{$key}: ";
                $result .= transformToString($value['old']['value'], $depht+1);              
            } else {
                var_dump('9');
                $result .= formatRow($key,$value['old']['value'], $depht * 2, "-");
            }
            continue;
        }

        
        
        
        
        /*
        if (is_array($value['old']['value'])) {
            $result .= "{$key}: ";
            $result .= transformToString($value['old']['value'], $depht+1);
            continue;
        } else {
            $result .= formatRow($key,$value['old']['value'], $depht * 2, "-");
            continue;
        }
        if (is_array($value['new']['value'])) {
            $result .= "{$key}: ";
            $result .= transformToString($value['new']['value'], $depht+1);
            continue;
        } else {  
            $result .= formatRow($key,$value['new']['value'], $depht * 2, "+");
            continue;
        }
        */        
    }
    $result .= "}\n";
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