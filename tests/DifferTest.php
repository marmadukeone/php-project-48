<?php

namespace Differ\Tests;

//require_once __DIR__ .'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $pathToFixturesFile1 = __DIR__. "/fixtures/file1.json";
        
        $pathToFixturesFile2 = __DIR__. "/fixtures/file2.json";
        $pathToTrueResult1 = __DIR__. "/fixtures/result1";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = $content1 = file_get_contents($pathToTrueResult1);
        $this->assertEquals($resultGendiff,$resultTrue);
    }

}
