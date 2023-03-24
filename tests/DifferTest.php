<?php

namespace Differ\Tests;

//require_once __DIR__ .'/../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $this->assertEquals(1,1);
    }

    /*
    public function testDiffer(): void
    {
        $res = genDiff("/fixtures/file1.json", "fixtures/file1.json");
        echo $res;
        //$this->assertTrue();
    }
    */

}

//$test = new DifferTest;
//$test->testDiffer();