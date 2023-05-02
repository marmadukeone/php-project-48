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
        var_dump(json_decode($content, true));
        return json_decode($content, true);
    } elseif (($extension === 'yml') || ($extension === 'yaml')) {
       // var_dump("KUKU");
        $content = Yaml::parseFile($pathToFile, Yaml::PARSE_OBJECT_FOR_MAP);
        //var_dump($content);
        return get_object_vars($content);
    } else {
        return null;
    }
}