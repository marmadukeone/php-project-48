<?php

namespace Differ\Formatters\Json;

function toJson(array $arr): string
{
    return json_encode($arr);
}