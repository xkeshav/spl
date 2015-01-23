<?php namespace One\Beta;

//Warning: The use statement with non-compound name 'One' has no effect in /opt/lampp/htdocs/spl/ns2.php on line 1

$Alpha = new Alpha();
var_dump($Alpha);

namespace Beta;

class Beta
{
    public function __construct()
    {
        echo "Alpha constructor".__NAMESPACE__;
    }

}


?>