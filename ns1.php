<?php namespace One;

class Alpha
{
    public function __construct()
    {
        echo "Alpha constructor: ".__NAMESPACE__;
    }

    public function getName()
    {
        return getcwd();
    }
}
