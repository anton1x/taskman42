<?php
/**
 * Created by PhpStorm.
 * User: Anton1x
 * Date: 25.06.2019
 * Time: 16:48
 */

namespace App\Hierarchy;


use RightsHierarchy\Hierarchy;
use RightsHierarchy\HierarchyItem;

class ProjectRightsHierarchy extends Hierarchy
{

    public function __construct()
    {
        parent::__construct();

        $this->build();
    }

    public function build()
    {
        $can_view = HierarchyItem::create('PROJECT_CAN_VIEW', 'Просмотр проекта');

        $can_create_topics = HierarchyItem::create('PROJECT_CAN_CREATE_TOPICS', 'Создание тем', [
            $can_view
        ]);

        $can_delete_posts = HierarchyItem::create('PROJECT_CAN_DELETE_POSTS', 'Удаление постов', [
            $can_view
        ]);

        $can_all = HierarchyItem::create('PROJECT_CAN_ALL', 'Всевластие', [
           $can_create_topics,
           $can_delete_posts
        ]);

        $this->addItem($can_view);
        $this->addItem($can_create_topics);
        $this->addItem($can_delete_posts);
        $this->addItem($can_all);

    }


}