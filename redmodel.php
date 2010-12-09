<?php

set_include_path(get_include_path().PATH_SEPARATOR .dirname(__FILE__)); 
spl_autoload_register(function($class){return spl_autoload(str_replace('_', '/', $class));});


class RedModel extends RedModel_SimpleModel {
  
  public $metamodel;
  
  public function __construct () {
    $this->name = $this->metamodel['name'];
    $this->metamodel = RedModel_Meta_Model::fromArray($this->metamodel['fields']);
    $this->metamodel->name = $this->name;
    $this->metamodel->realModel = &$this;
    $this->metamodel->bean = &$this->bean;
    
    RedModel_Event::register('constraint_fail', null, array($this, 'onConstraintFail'));
    RedModel_Event::register('field_fail',      null, array($this, 'onFieldFail'));
    RedModel_Event::register('model_fail',      null, array($this, 'onModelFail'));
    
  }
  
  /**
      called by RedBean before writing data to the database
  */
  public function update () {
    $this->metamodel->setInput($this->bean);
    $this->metamodel->check();
  }
  
  /**
      Get list of field names
  */
  public function getFieldList () {
    $out='';
    foreach ($this->metamodel->fields as $field) $out .= ($out?',':'') . $field->name;
    return $out;
  }
  
  public function onConstraintFail ($eventName, $sender, $message) {
  }
  public function onFieldFail ($eventName, $sender, $message) {
  }
  public function onModelFail ($eventName, $sender, $message) {
    throw new RedModel_Exception("$message: override RedModel::onModelFail, onFieldFail, or onConstraintFail");
  }
  
  /**
      Create
  */
  public static function createBean ($fields) {
    $c = get_called_class();
    $o = new $c();
    $bean = R::dispense($o->metamodel->name);
    $bean->import($fields, $o->getFieldList());
    R::store($bean);
    return $bean;
  }
  
  /**
      Update
  */
  public static function updateBean ($fields) {
    $c = get_called_class();
    $o = new $c();
    $id = $fields['id'];
    $bean = R::load($o->metamodel->name, $id);
    if (!$bean->id) return null;
    $bean->import($fields, $o->getFieldList());
    R::store($bean);
    return $bean;
  }


}

