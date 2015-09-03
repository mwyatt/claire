<?php
namespace OriginalAppName\Test;

class DatabaseTest extends PHPUnit_Framework_TestCase
{


    public function testConnect()
    {
        $database = new \OriginalAppName\Database(include '../App/credentials' . EXT);
        $database->connect();


        $this->assertEquals(1, 1);
    }
}
