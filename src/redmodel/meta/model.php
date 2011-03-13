<?php
/**
    Model 

    represents a Model's name and a set of fields to store its data.
*/
class RedModel_Meta_Model extends RedModel_Meta {
  
  /**
      Fields for this Model (design time).
      @var array<string=>RedModel_Meta_Field>
  */
  public $fields;
  
  /**
      @var array<string=>string>
  */
  public $input;
  
  /**
      @var object
  */
  public $realModel;
  
  /**
      @var object
  */
  public $bean;
  
  /**
      Append a child field.
      @param mixed $name of object
      @param mixed $value to append
  */
  public function appendChild ($name, $value) {
    $o = RedModel_Meta_Field::fromArray($value);
    $o->name =  $name;
    $o->model = &$this;
    ($o->title = @$o->constraints['title']->value) || $o->title = ucwords(implode(' ',explode('_',$name)));
    $this->fields[$name] = &$o;
  }

  
  /**
      Set user input
      @param array<string=>string> $input from user (probably $_POST)
  */
  public function setInput ($input) {
    $this->input = $input;
    foreach ($input as $k=>$v) foreach ($this->fields as $f) if ($f->name == $k) $f->value=$v;
  }
  
  /**
      Check the Model's validity.
      @return true if valid, false if not.
  */
  public function check () {
    $result=true;
    foreach ($this->fields as $f) {
      if (!$f->check()) $result=false;
    }
    
    RedModel_Event::dispatch($result ? 'model_ok' : 'model_fail', $this);
    return $result;
  }

}
