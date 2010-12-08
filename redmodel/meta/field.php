<?php
/**
    Field 

    represents a field's name and value, and a set of
    constraints to be placed on the field's data.
*/
class RedModel_Meta_Field extends RedModel_Meta {

  public function __construct () {
  }

  /**
      Field name, for example 'height' (design time).
      @var string
  */
  public $name='';
  
  /**
      Field title, for example 'Your Height' (design time).
      @var string
  */
  public $title='';
  
  /**
      Field value (passed from user), for example '10.4' (runtime).
      @var string
  */
  public $value='';
  
  /**
      Constraints for this field (design time).
      @var array<int=>RedModel_Meta_Constraint>
  */
  public $constraints;
  
  /**
      Model this field belongs to.
      @var RedModel_Meta_Model
  */
  public $model=null;
  
  /**
      Append a child field.
      @param mixed $name of object
      @param mixed $value to append
  */
  public function appendChild ($name, $value) {
    $o = RedModel_Meta_Constraint::get($name);
    $o->name  = $name;
    $o->value = &$value;
    $o->field = &$this;
    $this->constraints[$name] = $o;
  }
  
  /**
      Check the field's validity.
      @return true if valid, false if not.
  */
  public function check () {
    $result=true;
    foreach ($this->constraints as $c) if (!$c->check()) $result=false;
    RedModel_Event::dispatch($result ? 'field_ok' : 'field_fail', $this);
    return $result;
  }

}

