<?php
/**
    class for automatically creating html form fields from a model 
*/
class RedModel_Form {

  public static function getFields ($model) {
    if (!is_object($model)) {
      $className = "$model";
      $model = new $className;
    }
    if (@$model->metamodel) $model = $model->metamodel; 
    return $model->fields;
  } 

}

