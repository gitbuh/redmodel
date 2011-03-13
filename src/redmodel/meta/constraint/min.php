<?php
/**
    'Min' Constraint 
    
    represents a minimum value for a field
*/
class RedModel_Meta_Constraint_Min extends RedModel_Meta_Constraint {
  
  /**
     Check the field's validity.
     @return true if valid, false if not.
  */
  public function check () {
    $modelName = $this->field->model->name;
    $fieldName = $this->field->name;
    return $this->dispatch($this->value <= $this->field->value,
      "{$this->field->title} must be at least {$this->value}");
  }
  
}

