<?php

namespace Differ\Parsers\Stylish;

function stylish($arr, $depht = 2): string
{
    $nextDepht = $depht + 4;
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
                $result .= stylish($value['value'], $nextDepht);
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
                $result .= stylish($value['new']['value'], $nextDepht);
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
                $result .= stylish($value['old']['value'], $nextDepht);
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
                $result .= stylish($value['old']['value'], $nextDepht);
                $result .= $spacesWithoutOperator . "}\n";
            } else {
                $result .= $spacesWithOperator . formatRow($key, $value['old']['value'], "-");
            }
            if (is_array($value['new']['value'])) {
                //var_dump("PIDRAS");
                $result .= "{$spacesWithOperator}- {$key}: ";
                $result .= stylish($value['new']['value'], $nextDepht);
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
    if ($depht === 2) {
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
    //костылек чтобы ты заплакала - если валию сука === "" (то есть это не нулл, это пустая строка)
    if ($value === "") {
        $result = $key . ":" . "\n";
    } else {
        $result = $key . ": " . $value . "\n";
    }
    if ($operand) {
        $result = $operand . " " . $result;
    }
    return $result;
}
