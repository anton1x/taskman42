<?php


namespace RightsHierarchy;


use Doctrine\Common\Collections\ArrayCollection;

class Hierarchy
{

    /**
     * @var array
     */
    private $hierarchy;

    public function __construct()
    {
        $this->hierarchy = new ArrayCollection();
    }



    /**
     * @param string|HierarchyItem $signature
     * @return HierarchyItem
     */
    public function getItem($signature)
    {
        if(!$this->hierarchy->containsKey($signature))
            return;
        return $this->hierarchy[ $signature ];
    }


    public function getHierarchy()
    {
        return $this->hierarchy;
    }


    public function addItem(HierarchyItem $item)
    {
        $signature = $item->getItem()->getSignature();
        $this->hierarchy[ $signature ] = $item;
        return $this->hierarchy[ $signature ];
    }

    public function getChoices()
    {
        $result = [];

        foreach ($this->getHierarchy() as $key => $value){
            $result[$value->getItem()->getSignature()] = $value->getItem()->getDescription();
        }

        return $result;
    }

}