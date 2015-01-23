<?php namespace One;

class ns1
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
