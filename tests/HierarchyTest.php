<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use RightsHierarchy\Hierarchy;
use RightsHierarchy\HierarchyItem;

class HierarchyTest extends TestCase
{

    private $hierarchy;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->hierarchy = new Hierarchy();
    }


    public function testSomething()
    {
        $this->assertTrue(true);
    }


    public function testHierarchyStructure()
    {

        $can_view = HierarchyItem::create('CAN_VIEW', 'Blabla');

        $can_manage = HierarchyItem::create('CAN_MANAGE', 'Can manage', [$can_view]);

        $can_admin = HierarchyItem::create('CAN_ADMIN', 'Can admin', [$can_manage]);

        $this->hierarchy->addItem(
            $can_view
        );

        $this->hierarchy->addItem(
            $can_manage
        );

        $this->hierarchy->addItem(
            $can_admin
        );

        $this->assertCount(0, $this->hierarchy->getItem($can_view->getItem()->getSignature())->getChildren());


        $this->assertEquals(
            ['CAN_VIEW' => $can_view, 'CAN_MANAGE' => $can_manage] ,
            $this->hierarchy->getItem(
                $can_admin->getItem()->getSignature()
            )->getChildren()
        );
    }
}
