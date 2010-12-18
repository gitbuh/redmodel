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
    $bean = $this->field->model->bean;
    $ctx = @$this->field->constraints['context'];
    $update = $ctx ? strpos(",,{$ctx->value},", ',update,') : true;
    return $this->dispatch(
      (!$this->value) || ($this->field && $this->field->value) || ($bean->id && !$update),
      "{$this->field->title} is required"
    );
  }

}

