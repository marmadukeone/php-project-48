<?php

namespace Differ\Differ;

use function Differ\Parsers\Parser\parseFile;

function genDiff(string $pathFile1, string $pathFile2)
{

    $array1 = parseFile($pathFile1);
    $array2 = parseFile($pathFile2);
    //тут уже обработка по ассоциативному массиву
    $commonArray = transformToCommonArray($array1, $array2);
    var_dump("YAAAAAAA");
    print_r($commonArray);
    $result = transformToString($commonArray);

    // return [];

    return $result;
}

function transformToCommonArray(array $arr1, array $arr2): array
{
    $result = [];
    foreach ($arr1 as $key => $value) {
        if (array_key_exists($key, $arr2)) {
            //ключ есть в обоих
            if (is_array($value) && is_array($arr2[$key])) {
                //вложенные
                $temp = transformToCommonArray($value, $arr2[$key]);
                //var_dump("TEMP::", $temp);
                if (!empty($temp)) {
                    $result[$key]['value'] = $temp;
                }
            } else {
                if ($value !== $arr2[$key]) {
                    //значения не совпадают
                    $result[$key]['old']['value'] = $value;
                    $result[$key]['new']['value'] = $arr2[$key];
                } else {
                    //совпадают - простовалию
                    $result[$key]['value'] = $value;
                }
            }
            //ну что как на это отреагирует влад?
            unset($arr2[$key]);
        } else {
            //нету во втором
            $result[$key]['value']['old']['value'] = $value;
            $result[$key]['value']['new'] =  null;
        }
    }
    foreach ($arr2 as $key => $value) {
        //нету в первом
        $result[$key]['old'] = null;
        $result[$key]['new']['value'] = $value;
    }
    return $result;
}



function transformToString($arr, $depht = 1): string
{
    $nextDepht = $depht + 3;
    $spacesWithOperator = str_repeat(" ", $depht);
    // uncomment for debug depht:
    // $debugDephtStr = $depht % 10;
    // $spacesWithOperator = str_repeat($debugDephtStr, $depht);

    $spacesWithoutOperator = $spacesWithOperator . str_repeat(" ", 2); // "+ " = 2 symbols
    $result = "{\n";
    //var_dump(is_array($arr));

    foreach ($arr as $key => $value) {
        var_dump("KEY:::", $key);
        var_dump("VALUE IS ARRAY?", is_array($value));
        //var_dump($value);
        if (!is_array($value)) {
            var_dump("TYT");
            $result .= $spacesWithoutOperator . formatRow($key, $value);
            continue;
        } else {
            if (array_key_exists('value', $value)) {
                var_dump("0");

                if (is_array($value['value'])) {
                    var_dump("1");
                    $result .= "{$spacesWithoutOperator}{$key}: ";
                    $result .= transformToString($value['value'], $nextDepht);
                    $result .= $spacesWithoutOperator . "}\n";
                } else {
                    var_dump("2");
                    if(is_null($value)) {
                        var_dump("DA YA EMPTY");
                    } else{
                        var_dump("YA NE EMPTY");
                        $result .= $spacesWithOperator . formatRow($key, $value['value'], "??");
                    }
                    
                }
                continue;
            } else {
                var_dump("NO KEY VALUE");
                // var_dump("HUI");
                // var_dump($value['old']);
                // var_dump(is_null($value['old']));
                // var_dump("HUI2");
                // var_dump($value['old'] == null);
                //continue;
            }
        }
        var_dump($value['old'] == null);
        if (is_null($value['old'])) {
            var_dump("3");
            if (is_array($value['new']['value'])) {
                var_dump("4");
                $result .= "{$spacesWithOperator}+ {$key}: ";
                $result .= transformToString($value['new']['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                var_dump("5");
                $result .= $spacesWithOperator . formatRow($key, $value['new']['value'], "+");
            }
            continue;
        }

        if (is_null($value['new'])) {
            var_dump("6");
            if (is_array($value['old']['value'])) {
                var_dump("7");
                $result .= "{$spacesWithOperator}- {$key}: ";
                $result .= transformToString($value['old']['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                var_dump("8");
                $result .= $spacesWithOperator . formatRow($key, $value['old']['value'], "-");
            }
            continue;
        }

        if (!is_null($value['old'] && !is_null($value['new']))) {
            var_dump("9");
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