<?php

namespace Differ\Tests;

//require_once __DIR__ .'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;
//use function Differ\Parsers\Parser\parseFile;

class DifferTest extends TestCase
{
       public function testGenDiffJson()
    {
        $pathToFixturesFile1 = __DIR__. "/fixtures/file1.json";
        $pathToFixturesFile2 = __DIR__. "/fixtures/file2.json";
        $pathToTrueResult = __DIR__. "/fixtures/result1";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultGendiff,$resultTrue);

    }
    /*
    public function testGenDiffYml()
    {
        $pathToFixturesFile1 = __DIR__. "/fixtures/yml1.yml";
        $pathToFixturesFile2 = __DIR__. "/fixtures/yml2.yml";
        $pathToTrueResult = __DIR__. "/fixtures/result1";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultGendiff,$resultTrue);
    }
    public function testGenDiffYaml()
    {
        $pathToFixturesFile1 = __DIR__. "/fixtures/yaml1.yaml";
        $pathToFixturesFile2 = __DIR__. "/fixtures/yaml2.yaml";
        $pathToTrueResult = __DIR__. "/fixtures/result1";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultGendiff,$resultTrue);
    }
    */
    public function testGenDiffJsonUpgrate()
    {
        $pathToFixturesFile1 = __DIR__. "/fixtures/file1_2.json";
        $pathToFixturesFile2 = __DIR__. "/fixtures/file2_2.json";
        $pathToTrueResult = __DIR__. "/fixtures/result2";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultGendiff,$resultTrue);
    }
    /* public function testGenDiffYmlUpgrate()
    {
        $pathToFixturesFile1 = __DIR__. "/fixtures/yml1_2.yml";
        $pathToFixturesFile2 = __DIR__. "/fixtures/yml2_2.yml";
        $pathToTrueResult = __DIR__. "/fixtures/result2";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultGendiff,$resultTrue);
    }
    public function testGenDiffYamlUpgrate()
    {
        $pathToFixturesFile1 = __DIR__. "/fixtures/yaml1_2.yaml";
        $pathToFixturesFile2 = __DIR__. "/fixtures/yaml2_2.yaml";
        $pathToTrueResult = __DIR__. "/fixtures/result2";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultGendiff,$resultTrue);
    }
    */
}
