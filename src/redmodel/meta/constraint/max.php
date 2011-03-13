<?php
/**
    'Max' Constraint 
    
    represents a Maximum value for a field
*/
class RedModel_Meta_Constraint_Max extends RedModel_Meta_Constraint {
  
  /**
     Check the field's validity.
     @return true if valid, false if not.
  */
  public function check () {
    $modelName = $this->field->model->name;
    $fieldName = $this->field->name;
    return $this->dispatch($this->value >= $this->field->value,
      "{$this->field->title} can't exceed {$this->value}");
  }
  
}

