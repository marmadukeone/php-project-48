<?php

namespace Differ\Parsers\CommonArray;

function transformToCommonArray(?array $arr1, ?array $arr2): array
{
    /*
    Тут просто записываешь в old->value, new->value или просто value какие-то значение явно. Но фактически,
    эти значения нужно обработать так же через эту же функцию (transformToCommonArray), то есть вызвать рекурсивно.
    Нужно это делать для того, чтобы обрабатывать правильно вложенные массивы.
    */
    $result = [];
    if (!is_null($arr1)) {
        $isNullArr2 = false;
        if (is_null($arr2)) {
            $arr2 = [];
            $isNullArr2 = true;
        }

        foreach ($arr1 as $key => $value) {
            var_dump("KEY:");
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
                    $result[$key]['old']['value'] = transformToCommonArray($value, null);
                    $result[$key]['new']['value'] = $arr2[$key];
                }
                if (!is_array($value) && is_array($arr2[$key])) {
                    var_dump("TADAM");
                    $result[$key]['old']['value'] = $value;
                    $result[$key]['new']['value'] = transformToCommonArray($arr2[$key], null);
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
                if ($isNullArr2) {
                    if (is_array($value)) {
                        $result[$key]['value'] = transformToCommonArray($value, null);
                    } else {
                        $result[$key]['value'] = $value;
                    }
                    continue;
                }

                if (is_array($value)) {
                    $result[$key]['new'] = null;
                    $result[$key]['old']['value'] = transformToCommonArray($value, null);
                } else {
                    $result[$key]['old']['value'] = $value;
                    $result[$key]['new'] = null;
                }
            }
        }
    }

    if (!is_null($arr2)) {
        foreach ($arr2 as $key => $value) {
            if (is_null($arr1)) {
                if (is_array($value)) {
                    $result[$key]['value'] = transformToCommonArray(null, $value);
                } else {
                    $result[$key]['value'] = $value;
                }

                continue;
            }

            if (is_array($value)) {
                $result[$key]['old'] = null;
                $result[$key]['new']['value'] = transformToCommonArray(null, $value);
            } else {
                $result[$key]['old'] = null;
                $result[$key]['new']['value'] = $value;
            }
        }
    }
    ksort($result);
    return $result;
}
