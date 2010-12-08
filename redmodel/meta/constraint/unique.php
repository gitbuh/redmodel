<?php
/**
    'Unique' Constraint 
    
    represents a unique field
*/
class RedModel_Meta_Constraint_Unique extends RedModel_Meta_Constraint {
  
  /**
     Check the field's validity.
     @return true if valid, false if not.
  */
  public function check () {
    $bean = $this->field->model->bean;
    $modelName = $this->field->model->name;
    $fieldName = $this->field->name;
    $test = R::findOne($modelName, "$fieldName=? and id<>?", array($bean->$fieldName, $bean->id));
    return $this->dispatch(!$test, "{$this->field->title} must be unique");
  }

}

