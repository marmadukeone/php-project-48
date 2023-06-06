<?php

namespace Differ\Differ;

use function Differ\Parsers\Parser\parseFile;
use function Differ\Parsers\CommonArray\transformToCommonArray;
use function Differ\Formatters\Stylish\stylish;
use function Differ\Formatters\Plain\plain;
use function Differ\Formatters\Json\toJson;

function genDiff(string $pathFile1, string $pathFile2, $formater = "stylish")
{
    $array1 = parseFile($pathFile1);
    $array2 = parseFile($pathFile2);
    var_dump($array2);
    $commonArray = transformToCommonArray($array1, $array2);
    //var_dump($commonArray);
    switch($formater) {
        case "stylish": {
            $result = stylish($commonArray);
            break;
        }
        case "plain": {
            $result = plain($commonArray);
            break;
        }
        case "json": {
            $result = toJson($commonArray);
            break;
        }
        default: {
            return "Error. Incorrect type of formatter";
        }
    }
    return $result;
}
