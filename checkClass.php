<?php namespace check;

/**
* PHP Class CheckClass
* @author    Felipe Nascimento <felipenmoura@gmail.com>
* @link
* @version  3.0
*/
class CheckClass
{
    /**
     * This is set before
     * @public firstDir
     * @static
     */
    public static $first;
    public static $firstDir;

    /**
     * Public function setFirstDir
     * @return void
     * @param  mixed $val
     */
    public function setFirstDir($val)
    {
        $this->firstDir = $val;
    }

    /**
     * Public function getFirstDir
     * @return firstDir
     */
    public function getFirstDir()
    {
        return $this->firstDir;
    }

    /* constructor method */
    public function __construct()
    {
        echo "First value:". self::$first;
    }
}

CheckClass::$first = '/opt/lampp/';
$obj = new CheckClass();
var_dump($obj);
