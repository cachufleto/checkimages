<?php
/**
 * Created by PhpStorm.
 * User: Carlos PAZ DUPRIEZ
 * Date: 31/05/2016
 * Time: 13:07
 */
namespace Site;

use App\Bdd;

class Import extends Bdd
{
    var $_lib = [];

    public function __construct(){
        $this->_lib = file_contents_libelles();
    }

}