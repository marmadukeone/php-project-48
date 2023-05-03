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
    var_dump($result);
    $result = json_encode($result, JSON_PRETTY_PRINT);
    return $result;
}
function compareJsonArrays($arr1, $arr2, $depth = 0) {
    $result = array();
    $keys1 = array_keys($arr1);
    $keys2 = array_keys($arr2);
    $commonKeys = array_intersect($keys1, $keys2);
    foreach ($commonKeys as $key) {
      if (is_array($arr1[$key]) && is_array($arr2[$key])) {
        $subResult = compareJsonArrays($arr1[$key], $arr2[$key], $depth + 1);
        if (!empty($subResult)) {
          $result[$key] = $subResult;
        }
      } else if ($arr1[$key] === $arr2[$key]) {
        $result[$key] = array("value" => $arr1[$key], "sign" => " ");
      } else {
        $result[$key] = array("value" => array($arr1[$key], $arr2[$key]), "sign" => "+-");
      }
    }
    $uniqueKeys1 = array_diff($keys1, $keys2);
    foreach ($uniqueKeys1 as $key) {
      if (is_array($arr1[$key])) {
        $subResult = compareJsonArrays($arr1[$key], array(), $depth + 1);
        if (!empty($subResult)) {
          $result[$key] = $subResult;
        }
      } else {
        $result[$key] = array("value" => $arr1[$key], "sign" => "-");
      }
    }
    $uniqueKeys2 = array_diff($keys2, $keys1);
    foreach ($uniqueKeys2 as $key) {
      if (is_array($arr2[$key])) {
        $subResult = compareJsonArrays(array(), $arr2[$key], $depth + 1);
        if (!empty($subResult)) {
          $result[$key] = $subResult;
        }
      } else {
        $result[$key] = array("value" => $arr2[$key], "sign" => "+");
      }
    }
    if ($depth == 0) {
      $result = array("{" . "\n" . formatJsonArray($result) . "}");
    }
    return $result;
  }
  
  function formatJsonArray($arr, $depth = 0) {
    $result = "";
    foreach ($arr as $key => $value) {
      if (is_array($value)) {
        $result .= str_repeat(" ", $depth * 4) . $key . ": {" . "\n" . formatJsonArray($value, $depth + 1) . str_repeat(" ", $depth * 4) . "}" . "\n";
      } else if (is_string($value)) {
        $result .= str_repeat(" ", $depth * 4) . $key . ": " . $value . "\n";
      } else if (is_bool($value)) {
        $result .= str_repeat(" ", $depth * 4) . $key . ": " . var_export($value, true) . "\n";
      } else if ($value !== null && is_array($value) && isset($value["sign"]) && isset($value["value"])) {
        $result .= str_repeat(" ", $depth * 4) . $key . ": " . $value["sign"] . " " . json_encode($value["value"]) . "\n";
      } else {
        // Добавляем обработку случая, когда переменная имеет значение null
        $result .= str_repeat(" ", $depth * 4) . $key . ": null\n";
      }
    }
    return $result;
  }
  

/*function newgetDiff($array1, $array2)
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
*/