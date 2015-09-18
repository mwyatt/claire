<?php
namespace OriginalAppName\Test;

class ModelTest extends \PHPUnit_Framework_TestCase
{


    public function testCreate()
    {
        $model = new \OriginalAppName\Model;
        $model
            ->setTableName('test')
            ->setFields(['foo', 'bar']);
        // $
        // $model->create()
    }
}
