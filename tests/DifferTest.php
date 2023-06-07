<?php

namespace Differ\Tests;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;


class DifferTest extends TestCase
{
    public function testGenDiffJson()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/file1.json";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/file2.json";
        $pathToTrueResult = __DIR__ . "/fixtures/result1";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
    public function testGenDiffYml()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/yml1.yml";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/yml2.yml";
        $pathToTrueResult = __DIR__ . "/fixtures/result1";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
    public function testGenDiffYaml()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/yaml1.yaml";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/yaml2.yaml";
        $pathToTrueResult = __DIR__ . "/fixtures/result1";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
    public function testGenDiffJsonUpgrate()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/file1_2.json";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/file2_2.json";
        $pathToTrueResult = __DIR__ . "/fixtures/result2";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
    public function testGenDiffYmlUpgrate()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/yml1_2.yml";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/yml2_2.yml";
        $pathToTrueResult = __DIR__ . "/fixtures/result2";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
    public function testGenDiffYamlUpgrate()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/yaml1_2.yaml";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/yaml2_2.yaml";
        $pathToTrueResult = __DIR__ . "/fixtures/result2";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
    public function testGenDiffJsonUpgratePlain()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/file1_2.json";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/file2_2.json";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2, "plain");
        $pathToTrueResult = __DIR__ . "/fixtures/result3";
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
    public function testGenDiffJsonUpgrateJson()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/file1_2.json";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/file2_2.json";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2, "json");
        $pathToTrueResult = __DIR__ . "/fixtures/result4";
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
    public function testGenDiffJsonUpgrateData2()
    {
        $pathToFixturesFile1 = __DIR__ . "/fixtures/file3_1.json";
        $pathToFixturesFile2 = __DIR__ . "/fixtures/file3_2.json";
        $pathToTrueResult = __DIR__ . "/fixtures/result5";
        $resultGendiff = genDiff($pathToFixturesFile1, $pathToFixturesFile2);
        $resultTrue = file_get_contents($pathToTrueResult);
        $this->assertEquals($resultTrue, $resultGendiff);
    }
}
