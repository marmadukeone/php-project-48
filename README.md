## Badges

### Hexlet tests and linter status:

[![Actions Status](https://github.com/marmadukeone/php-project-48/workflows/hexlet-check/badge.svg)](https://github.com/marmadukeone/php-project-48/actions)

### CodeClimat Maointainability

[![Maintainability](https://api.codeclimate.com/v1/badges/a74afdf2d4a9c6d51805/maintainability)](https://codeclimate.com/github/marmadukeone/php-project-48/maintainability)

### Codeclimate TestCovarage

[![Test Coverage](https://api.codeclimate.com/v1/badges/a74afdf2d4a9c6d51805/test_coverage)](https://codeclimate.com/github/marmadukeone/php-project-48/test_coverage)

### Bagde for GA

[![hello-world](https://github.com/marmadukeone/php-project-48/actions/workflows/hello-world.yml/badge.svg?branch=main)](https://github.com/marmadukeone/php-project-48/actions/workflows/hello-world.yml)

## README ABOUT PARSER MODULE

This module will help you to read YAML/YML/JSON, create common array from 2 arrays, output result as like neested json.

## The module have 3 functions:
1. parseFile(string $pathToFile)
2. transformToCommonArray(?array $arr1, ?array $arr2)
3. stylish($arr, $depht = 2)

### parseFile(string $pathToFile), 
It is get a path to JSON/YML/YAML file and return content as array

🔍 **If function can't support extension of file it will output null**

#### Example of using

Input file:

> {
> "host": "hexlet.io",
> "timeout": 50,
> "proxy": "123.234.53.22",
> "follow": false
> }

Result:
>array(3) {
>  ["timeout"]=>
>  int(20)
>  ["verbose"]=>
>  bool(true)
>  ["host"]=>
> string(9) "hexlet.io"
>}

### transformToCommonArray(?array $arr1, ?array $arr2)
This function create common array on keys fron 2 arrays. I'm lazy and will not write more, but this function was reason of my heahache about 2 weeks. 

#### Example of using
⛔️todo

### stylish($arr, $depht = 2)
This function output diff from common array in format like json;

#### Example of using
⛔️todo



## QUESTIONS

1.

## TODO
1. Напишите тесты ✅
2. Сделайте фикстуру yaml со вложенностью, по аналогии с описанным выше json ✅
3. Реализуйте нахождение различий для файлов, имеющих вложенные структуры ⛔️
4. Реализуйте форматер выводящий внутреннее дерево как показано сверху. Назовите его stylish ⛔️
5. Добавьте текущий форматер как форматер по умолчанию для библиотеки. Это значит, что данный форматер применяется, если не указан какой-то другой ⛔️
6. Укажите stylish как форматер по умолчанию в исполняемом файле ⛔️
7. Добавьте в ридми аскинему с примером работы пакета ⛔️


## ❤️❤️❤️ VLAD THE BEST ❤️❤️❤️
