<?php
/**
    'Type' Constraint 
    
    constrains a field to a particular 'type.'
*/
class RedModel_Meta_Constraint_Type extends RedModel_Meta_Constraint {
  
  /**
     Check the field's validity.
     @return true if valid, false if not.
  */
  public function check () {
    $cval = $this->value;         // constraint value
    $fval = $this->field->value;  // field value
    $modelName = $this->field->model->name;
    $fieldName = $this->field->name;
    $required = $this->field->required;
    
    // if the first character is uppercased, it's a class name
    if ($cval{0} === strtoupper($cval{0})) {
      $prop = strtolower($cval);
      // print_r($this->field->model->bean->export()); die;
      $id = $this->field->model->bean->$prop;
      if (!$id) return $this->dispatch(false, "{$this->field->title} does not exist");
      $r = is_object($id) ? $id : R::findOne($prop, "id = $id");
      if (!$r) return $this->dispatch(false, "{$this->field->title} does not exist");
      $this->field->model->bean->$prop = $r;
      return $this->dispatch(true);
    }
    
    switch ($cval) {
      case 'numeric': case 'number': case 'decimal': case 'real': case 'float':  case 'double': 
        return $this->dispatch(is_numeric($fval),
          "{$this->field->title} must be numeric");
      case 'int': case 'integer': case 'integral':
        return $this->dispatch(is_numeric($fval) && ($fval == round($fval)),
          "{$this->field->title} must be a whole number");
      case 'date':
        if (!$required && !$fval) return $this->dispatch(true); 
        $d=date_parse($fval);
        $ok = $d['year'] && $d['month'];

        if ($ok) { 
          $date = date_create("{$d['year']}-{$d['month']}-{$d['day']} {$d['hour']}:{$d['minute']}:{$d['second']}");
          $date = date_format($date, 'Y-m-d H:i:s');
        }
        $this->field->model->bean->$fieldName = $date;
        
        // print_r($this->field->model->bean->$fieldName);
        return $this->dispatch($ok, "{$this->field->title} must be a valid date");
      case 'time':
        $d=date_parse($fval);
        return $this->dispatch($d['hour'],
          "{$this->field->title} must be a valid time");
      case 'string': case 'text':
        return $this->dispatch($fval === "$fval",
          "{$this->field->title} must be a string");
      case 'file':
        return $this->dispatch(true);
      case 'email':
        if (!$required && !$fval) return $this->dispatch(true); 
        return $this->dispatch(eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",
         $fval), "Must be a valid email address."); 
      case 'phone':
          if (!$required && !$fval) return $this->dispatch(true); 
          return $this->dispatch(
            eregi("^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$", $fval),
            "Must be a valid phone number.");
      case 'color':
          if (!$required && !$fval) return $this->dispatch(true); 
          $color = str_replace("#", "", $fval);
          return $this->dispatch(strlen($color) == 6, "{$this->field->title} must be a valid hex-color.");          
      default:
        throw new RedModel_Exception("Unknown type constraint '$cval'.");
    }
  }
}

