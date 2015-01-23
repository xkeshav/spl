<?php namespace NS;

   class H {

        public $v = 'now';
        public static $v_ = 'static';

        public function pm() {
           printf("<br/>public %s; variable v:%s", __METHOD__, $this->v);
        }

        public function getList()
        {
            printf("<br/> %s; Variable md5: %s", __METHOD__, md5($this->v));
        }

        public static function gl_()
        {
           printf("<br/> %s ; var: %s ; static: %s", __METHOD__, $this->v, self::$v_);
           self::getList();
        }


    }


$o = new H;
var_dump($o); // object(NS\H)[1]  public 'v' => string 'var' (length=3)

//I want to use namespace with help of documentation http://php.net/manual/en/language.namespaces.basics.php
// with Unqualified name
//$o_ = new getList(); // Fatal error: Class 'NS\getList' not found
//Qualified name
//$o_ = new H\getList(); // Fatal error: Class 'NS\H\getList' not found
//Fully qualified name,
//$o_ = new NS\H\getList(); // Fatal error: Class 'NS\NS\H\getList' not found

//How to call public method of a class within namespace?

