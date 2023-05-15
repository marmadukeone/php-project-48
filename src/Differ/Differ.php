<?php

namespace Differ\Differ;

use function Differ\Parsers\Parser\parseFile;

function genDiff(string $pathFile1, string $pathFile2)
{
    $array1 = parseFile($pathFile1);
    $array2 = parseFile($pathFile2);
    $commonArray = transformToCommonArray($array1, $array2);
    ///print_r($commonArray);
    //return [];
    $result = transformToString($commonArray);
    return $result;
}

function transformToCommonArray(array $arr1, array $arr2): array
{
    /*
    Тут просто записываешь в old->value, new->value или просто value какие-то значение явно. Но фактически,
    эти значения нужно обработать так же через эту же функцию (transformToCommonArray), то есть вызвать рекурсивно. 
    Нужно это делать для того, чтобы обрабатывать правильно вложенные массивы.
    */
    $result = [];
    foreach ($arr1 as $key => $value) {
        if (array_key_exists($key, $arr2)) {
            //ключ есть в обоих
            if (is_array($value) && is_array($arr2[$key])) {
                //вложенные
                $temp = transformToCommonArray($value, $arr2[$key]);
                //var_dump("1");
                //print_r($temp);
                if (!empty($temp)) {
                    $result[$key]['value'] = $temp;
                }
            }
            if (is_array($value) && !is_array($arr2[$key])) {
                //если первый массив, а второй не массив
                //var_dump("11");
                $result[$key]['old']['value'] = transformToCommonArray($value, []);
                $result[$key]['new']['value'] = $arr2[$key];

            }
            if (!is_array($value) && is_array($arr2[$key])) {
                //var_dump("2");
                //$result[$key]['old']['value'] = transformToCommonArray($value, []);
                //$result[$key]['new']['value'] = $arr2[$key];
            }

            //старое если
            if (!is_array($value) && !is_array($arr2[$key])) {
                //если не оба массивы - просто сравниваем значение
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
            if (is_array($value)) {
                //var_dump("ARRAY old");
                if (empty($arr2)) {
                    $result[$key]['value'] = transformToCommonArray($value, []);
                } else {
                    $result[$key]['old']['value'] = transformToCommonArray($value, []);
                }
            } else {
                if (empty($arr2)) {
                    $result[$key]['value'] = $value;
                } else {
                    $result[$key]['old']['value'] = $value;
                }

                //$result[$key]['new'] = null;
            }
        }
    }
    foreach ($arr2 as $key => $value) {
        //нету в первом
        if (is_array($value)) {
            //var_dump("ARRAY new");
            //$result[$key]['old'] = null;
            if (empty($arr1)) {
                $result[$key]['value'] = transformToCommonArray([], $value);
            } else {
                $result[$key]['new']['value'] = transformToCommonArray([], $value);
            }

        } else {
            //$result[$key]['old'] = null;
            if (empty($arr1)) {
                $result[$key]['value'] = $value;
            } else {
                $result[$key]['new']['value'] = $value;
            }

        }

    }
    ksort($result);
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

    foreach ($arr as $key => $value) {
        //var_dump("KEY:", $key);
        if (array_key_exists('value', $value)) {
            if (is_array($value['value'])) {
                $result .= "{$spacesWithoutOperator}{$key}: ";
                $result .= transformToString($value['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                //var_dump("KYKY");
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
                //var_dump("PEDIK");
                $result .= "{$spacesWithOperator}- {$key}: ";
                $result .= transformToString($value['old']['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                $result .= $spacesWithOperator . formatRow($key, $value['old']['value'], "-");
            }
            continue;
        }

        if (!is_null($value['old'] && !is_null($value['new']))) {
            if (is_array($value['old']['value'])) {
                //old array
                //var_dump("VLAD-PEDIK da");
                $result .= "{$spacesWithOperator}- {$key}: ";
                $result .= transformToString($value['old']['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                $result .= $spacesWithOperator . formatRow($key, $value['old']['value'], "-");
                

            }
            if (is_array($value['new']['value'])) {
                //var_dump("PIDRAS");
                $result .= "{$spacesWithOperator}- {$key}: ";
                $result .= transformToString($value['new']['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                //var_dump("KUKUHUEV");
                $result .= $spacesWithOperator . formatRow($key, $value['new']['value'], "+");
            }

            //$result .= $spacesWithOperator . formatRow($key, $value['old']['value'], "-");
            //$result .= $spacesWithOperator . formatRow($key, $value['new']['value'], "+");
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

    //if ($value === 'value')
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