<?php

namespace RightsHierarchy;

class Right implements RightInterface
{


    private $signature;

    private $description;


    public static function create($signature, $description)
    {
        $item = new self();
        $item->setSignature($signature);
        $item->setDescription($description);

        return $item;
    }

    /**
     * @return mixed
     */
    public function getSignature():string
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getDescription():string
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



    public function __toString()
    {
        return $this->getDescription();
    }





}