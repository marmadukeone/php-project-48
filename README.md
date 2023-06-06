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

This module will help you to read YAML/YML/JSON, create common array from 2 arrays.

## The module have 2 functions:
1. parseFile(string $pathToFile)
2. transformToCommonArray(?array $arr1, ?array $arr2)




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


## README ABOUT FORMATTERS MODULE
⛔️todo

## The module have 3 functions:
1. stylish($arr, $depht = 2)
2. plain($arr, $parent = "")
3. toJson(array $arr)

### stylish($arr, $depht = 2)
This function output diff from common array in format like json;

#### Example of using
⛔️todo

### plain($arr, $parent = "")
⛔️todo

#### Example of using
⛔️todo

### toJson(array $arr)
⛔️todo
#### Example of using
⛔️todo

## TODO
7. Добавьте в ридми аскинему с примером работы пакета ⛔️


## ❤️❤️❤️ VLAD THE BEST ❤️❤️❤️
