<?php
namespace Exception;

class Property extends Exception{

    // --- --- --- --- --- --- ---
    public function __construct($ob, $propName) {
        $Message = 'U2 Error: class [' .get_class($ob). '] property [' .$propName. '] is not defined';
        parent::__construct($Message);
	}
}
?>