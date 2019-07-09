<?php


namespace RightsHierarchy;


use Doctrine\Common\Collections\ArrayCollection;

class HierarchyItem
{
    /**
     * @var Right $item
     */
    private $item;

    /**
     * @var array $children
     */
    private $children = [];

    /**
     * @return Right
     */
    public function getItem(): Right
    {
        return $this->item;
    }

    /**
     * @param Right $item
     */
    public function setItem(Right $item)
    {
        $this->item = $item;
    }

    /**
     * @param $signature
     * @param $description
     * @param array|HierarchyItem $children
     * @return HierarchyItem
     */
    public static function create($signature, $description, $children = [])
    {
        $right = Right::create($signature, $description);

        return new self($right, $children);
    }

    /**
     * @param HierarchyItem $child
     */
    public function addChild($child)
    {
        if($this->hasChild($child)) {
            return;
        }

        foreach ($child->getChildren() as $baby){
            if(!$this->hasChild($baby)){
                $this->addChild($baby);
            }
        }
        $this->children[ $child->getItem()->getSignature() ] = $child;
    }

    /**
     * @param RightInterface $children
     */
    public function removeChild($children)
    {
        if(!isset($this->children[ $children->getSignature() ])){
            return;
        }

        unset($this->children[ $children->getSignature() ]);
    }

    /**
     * @param HierarchyItem $child
     * @return bool
     */
    public function hasChild($child):bool
    {
        return isset($this->children[ $child->getItem()->getSignature() ]);
    }

    /**
     * @return array
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    public function __toString()
    {
        return $this->getItem()->getSignature();
    }

    public function __construct(Right $right, array $children)
    {
        $this->setItem($right);

        foreach ($children as $child){
            $this->addChild($child);
        }
    }
}