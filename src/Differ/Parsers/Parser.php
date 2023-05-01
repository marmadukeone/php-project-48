<?php

namespace Differ\Parsers\Parser;

function parseFile(string $pathToFile): array
{
    $content = file_get_contents($pathToFile);
    //определяем расширение
    $pathParts = pathinfo($pathToFile);
    $extension = $pathParts['extension'];
    //выбираем исходя из расширения файла как парсить в ассоциативный массив
    if ($extension === 'json') {
        return json_decode($content, true);
    } elseif (($extension === 'yml') || ($extension === 'yaml')) {
        return [];
    } else {
        return [];
    }
}