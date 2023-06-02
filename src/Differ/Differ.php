<?php

namespace Differ\Differ;

use function Differ\Parsers\Parser\parseFile;
use function Differ\Parsers\Stylish\stylish;
use function Differ\Parsers\CommonArray\transformToCommonArray;

function genDiff(string $pathFile1, string $pathFile2, $formater = "stylish")
{
    $array1 = parseFile($pathFile1);
    $array2 = parseFile($pathFile2);
    $commonArray = transformToCommonArray($array1, $array2);
    if ($formater === "stylish") {
        $result = stylish($commonArray);
    }
    return $result;
}
