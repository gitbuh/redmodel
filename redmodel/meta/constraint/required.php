<?php
/**
    'Required' Constraint 
    
    represents a required field
*/
class RedModel_Meta_Constraint_Required extends RedModel_Meta_Constraint {
  
  /**
     Check the field's validity.
     @return true if valid, false if not.
  */
  public function check () {
    $modelName = $this->field->model->name;
    $fieldName = $this->field->name;
    return $this->dispatch($this->value==false || ($this->field && $this->field->value),
      "{$this->field->title} is required");
  }

}

