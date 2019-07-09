<?php

namespace RightsHierarchy;

interface RightInterface
{
    public function getSignature():string;
    public function getDescription():string;

}