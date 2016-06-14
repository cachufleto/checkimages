<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14/06/2016
 * Time: 15:11
 */
class BaseClass {
    function __construct() {
        print "In BaseClass constructor\n";
    }
}

class SubClass extends BaseClass {
    function __construct() {
        parent::__construct();
        print "In SubClass constructor\n";
    }
}

class OtherSubClass extends BaseClass {
    // Constructeur hérité de la classe BaseClass
}

// Dans le constructeur de la classe BaseClass
echo '<br>BaseClass()<br>';
$obj = new BaseClass();
// Dans le constructeur de la classe BaseClass
// In SubClass constructor
echo '<br>SubClass()<br>';
$obj = new SubClass();

// Dans le constructeur de la classe BaseClass
echo '<br>OtherSubClass()<br>';
$obj = new OtherSubClass();