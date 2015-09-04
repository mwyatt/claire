<?php
namespace OriginalAppName\Test;

class DatabaseTest extends \PHPUnit_Framework_TestCase
{


    public function testConnect()
    {
        $this->assertTrue(new \OriginalAppName\Database(include (string) (__DIR__ . '/') . '../App/credentials.php'));
    }


    public function testCreate()
    {
        return;
        $database = new \OriginalAppName\Database(include (string) (__DIR__ . '/') . '../App/credentials.php');
        $model = new \OriginalAppName\Model\Test($database);
        $entity = new \OriginalAppName\Entity\Test;
        $entity->testKey = 1;
        $entity->testValue = 2;
        $model->create([$entity]);
        $this->assertEquals(1, count($model->getLastInsertIds()));
    }


    public function testUpdate()
    {
        $database = new \OriginalAppName\Database(include (string) (__DIR__ . '/') . '../App/credentials.php');
        $model = new \OriginalAppName\Model\Test($database);
        $model->readId([1, 3, 5]);
        foreach ($model->getData() as $entity) {
            $entity->testValue++;
        }
        $model->update($model->getData());
        $this->assertEquals(1, $model->getRowCount());
    }


    public function testDelete()
    {
        $database = new \OriginalAppName\Database(include (string) (__DIR__ . '/') . '../App/credentials.php');
        $model = new \OriginalAppName\Model\Test($database);
        $model->readId([3, 5]);
        $model->delete($model->getData());
        $this->assertEquals(1, $model->getRowCount());
    }
}
