<?php

namespace Differ\Differ;

function genDiff(string $pathFile1, string $pathFile2): string {
    $content1 = file_get_contents($pathFile1);
    $content2 = file_get_contents($pathFile2);

    $json1 = json_decode($content1, true);
    $json2 = json_decode($content2, true);

    $result = "{\n";

    $keys_in_json1 = [];
    foreach ($json1 as $key => $value) {
        $keys_in_json1[] = $key;
        $output = '';
        if (isset($json2[$key])) {
            if ($value === $json2[$key]) {
                $output = formatRow($key, $value);
            } else {
                $output = formatRow($key, $value, "-");
                $output .= formatRow($key, $json2[$key], "+");
            }
        } else {
            $output = formatRow($key, $value, "-");
        }

        if ($output) {
            $result .= $output;
        }
    }

    foreach ($json2 as $key => $value) {
        if (in_array($key, $keys_in_json1, true)) {
            continue;
        }

        $result .= formatRow($key, $value, "+");
    }


    $result .= "}";
    return $result;
}

function formatRow(string $key, $value, $op = null): string {
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
