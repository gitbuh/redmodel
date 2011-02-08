<?php
/**
    Constraint 
    
    represents any "rule" that can be applied to a field,
    such as being "required," of a certain "type," etc.
*/
class RedModel_Meta_Constraint extends RedModel_Meta  {
  
  /**
     Constraint value, for example 'numeric' (design time).
     @var mixed
  */
  public $value=null;
  
  /**
     Field metadata for this constraint (runtime) 
     @var RedModel_Meta_Field
  */
  public $field=null;
  
  /**
     Check the field's validity. (override me)
     @return true if valid, false if not.
  */
  public function check () {
    return true;
  }
  
  public function dispatch ($r, $msg='') {
    RedModel_Event::dispatch('constraint_'.($r?'ok':'fail'), $this, $msg);
    return $r;
  }
  
  public static $registry;
  
  /**
     Register a constraint.
  */
  public static function register ($name) {
    self::$registry[$name] = get_called_class();
  }
  
  /**
     Get a constraint.
  */
  public static function get ($name) {
    ($class = @self::$registry[$name]) || $class = __CLASS__;
    return new $class();
  }
    
}


