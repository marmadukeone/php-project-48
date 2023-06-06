<?php

namespace Differ\Parsers\Parser;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $pathToFile): ?array
{
    //определяем расширение
    $pathParts = pathinfo($pathToFile);
    $extension = $pathParts['extension'];
    //выбираем исходя из расширения файла как парсить в ассоциативный массив
    if ($extension === 'json') {
        $content = file_get_contents($pathToFile);
        return json_decode($content, true);
    } elseif (($extension === 'yml') || ($extension === 'yaml')) {
        //$content = Yaml::parseFile($pathToFile, Yaml::PARSE_OBJECT_FOR_MAP);
        $content = Yaml::parseFile($pathToFile);
        return $content;
    } else {
        return null;
    }
}
