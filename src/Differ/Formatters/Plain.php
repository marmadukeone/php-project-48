<?php

namespace Differ\Formatters\Plain;

function plain(array $arr, string $parent = ""): string
{
    //var_dump("CURRENT ARRAY\n");
    //var_dump($arr);
    $result = "";
    foreach ($arr as $key => $value) {
        $keyPlusParent = $parent === "" ? $key : $parent . "." . $key;
        //var_dump("KEY:", $parent);
        if (array_key_exists('value', $value)) {
            if (is_array($value['value'])) {
                //$parent = $parent === "" ? $key: $parent . "." . $key;
                $result .= plain($value['value'], $keyPlusParent);
            } else {
                //var_dump("1");
                //var_dump($value['value']);
                //$result .= $spacesWithoutOperator . formatRow($key, $value['value']);
            }
            continue;
        }
        if (is_null($value['old'])) {
            if (is_array($value['new']['value'])) {
                //add + complex
                $result .= formatRowPlain($keyPlusParent, "add", "", "[complex value]");
            } else {
                //add + simple value
                $result .= formatRowPlain($keyPlusParent, "add", "", $value['new']['value']);
            }
            continue;
        }
        if (is_null($value['new'])) {
            //remove (without value)
            $result .= formatRowPlain($keyPlusParent, "remove");
            continue;
        }
        if (!is_null($value['old'] && !is_null($value['new']))) {
            if (is_array($value['old']['value'])) {
                if (is_array($value['new']['value'])) {
                    //complex - complex
                    $result .= formatRowPlain($keyPlusParent, "update", "[complex value]", "[complex value]");
                } else {
                    //complex - value
                    $result .= formatRowPlain($keyPlusParent, "update", "[complex value]", $value['new']['value']);
                }
            } else {
                if (is_array($value['new']['value'])) {
                    //value - complex
                    $result .= formatRowPlain($keyPlusParent, "update", $value['old']['value'], "[complex value]");
                } else {
                    //value - value
                    $result .= formatRowPlain($keyPlusParent, "update", $value['old']['value'], $value['new']['value']);
                }
                //$result .= $spacesWithOperator . formatRow($key, $value['old']['value'], "-");
            }
            continue;
        }
    }
    //var_dump($result);
    if ($parent === "") {
        $result = rtrim($result, "\n");
    }
    return $result;
}
function formatRowPlain(string $property, string $action, mixed $oldValue = null, mixed $newValue = null)
{
    //transform values
    $newValue = formatValue($newValue);
    $oldValue = formatValue($oldValue);
    switch ($action) {
        case "add":
            $output = "Property '{$property}' was added with value: {$newValue}\n";
            return $output;
        case "remove":
            return "Property '{$property}' was removed\n";
        case "update":
            return "Property '{$property}' was updated. From {$oldValue} to {$newValue}\n";
        default:
            return "There is mistake!";
    }
}

function formatValue(mixed $value): string
{
    if (is_null($value)) {
        return 'null';
    }
    if ($value === true) {
        return 'true';
    }
    if ($value === false) {
        return 'false';
    }
    if ($value === "") {
        return "''";
    }
    if ($value === "[complex value]") {
        return $value;
    }
    if (is_int($value)) {
        return $value;
    }
    return "'{$value}'";
}
