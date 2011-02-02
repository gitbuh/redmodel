<?php
/**
    Abstact class representing part of a metamodel
*/
class RedModel_Meta extends ArrayObject {

  public $name;
  
  /**
      Populate from array.
      @param mixed $value to append
  */
  public static function fromArray ($a) {
    $class = get_called_class();
    $obj = new $class();
    foreach ($a as $k=>$v) $obj->appendChild($k, $v);
    return $obj;
  }
  
  /**
      Append a child metamodel class.
      @param mixed $name of object
      @param mixed $value to append
  */
  public function appendChild ($name, $value) { 
    throw new RedModel_Exception (__CLASS__.'::'.__FUNCTION__.' is abstract.');
  }

}

