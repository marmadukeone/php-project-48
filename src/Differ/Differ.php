<?php

namespace Differ\Differ;

use function Differ\Parsers\Parser\parseFile;

function genDiff(string $pathFile1, string $pathFile2): string
{
    $array1 = parseFile($pathFile1);
    $array2 = parseFile($pathFile2);
    //тут уже обработка по ассоциативному массиву
    var_dump("START");
    $result = newgetDiff($array1, $array2);
    var_dump("END -- THIS RESULT:");
    var_dump($result);
    return $result;
}

function newgetDiff($array1, $array2)
{
    var_dump("I' INSIDE");
    $resArr = [];
    foreach ($array1 as $key => $value) {
        if (isset($array2[$key])) {
            //есть такой ключ
            if (is_array($value)) {
                //это массив
                $resArr[$key][] = newgetDiff($value, $array2[$key]);
            } else {
                //это не массив
                //сравниваем значение
                if ($value === $array2[$key]) {
                    //значения равны
                    $resArr[$key] = 'have key, eq values';
                } else {
                    //значения не равны
                    $resArr[$key] = 'have key, no eq values';
                }
            }
        } else {
            //нет такого ключа
            $resArr[$key] = 'no key in 2';
        }
    }
    foreach ($array2 as $key => $value) {
        if (!in_array($key, $resArr)) {
            $resArr[$key] = "no key in 1";
        }
    }
    var_dump("INSIDE RESULT IS:");
    var_dump($resArr);
    var_dump('END INSIDE');
    return $resArr;
}


function getDiff($array1, $array2)
{
    var_dump("START");
    $result = "{\n";
        //фнкция - формирует массив ключей с учетом наличия ключа в другом + -
        //если валие!=массив - то вызов другой функции кт уже сравнивает валие -- определяет +-
        //    
    $keys_in_array1 = [];
    //$resarr = [];
    foreach ($array1 as $key => $value) {
            $keys_in_array1[] = $key;
            //счетчик отступов
            $output = '';
            if (isset($array2[$key])) {
                //ключ есть в массиве 2
                if (is_array($value)) {
                    //значение это массив
                    //добавляет в аутпут просто результат пока
                    $output .= getDiff($array1[$key], $array2[$key]);
                } else {
                    //значение это не массив
                    if ($value === $array2[$key]) {
                        $output = formatRow($key, $value);
                    } else {
                        $output = formatRow($key, $value, "-");
                        $output .= formatRow($key, $array2[$key], "+");
                    }
                }
            } else {
                //ключа нет во втором массиве
                $output = formatRow($key, $value, "-");
            }
            if ($output) {
                $result .= $output;
            }
        }
        //тут наоборот уже условие
        // убираем ключи второго массива которые уже есть
        foreach ($array2 as $key => $value) {
            if (in_array($key, $keys_in_array1, true)) {
                continue;
            }
            //добавляет к строке
            $result .= formatRow($key, $value, "+");
        }
        $result .= "}";
        var_dump($result);
        var_dump("END");
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
