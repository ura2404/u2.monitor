<?php
namespace U2\Exception;

class Property extends \U2\Exception{

    // --- --- --- --- --- --- ---
    public function __construct($ob, $propName) {
        $Message = 'U2 Error: class [' .get_class($ob). '] property [' .$propName. '] is not defined';
        parent::__construct($Message);
	}
}
?>