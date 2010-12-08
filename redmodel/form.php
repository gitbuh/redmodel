<?php
/**
    class for automatically creating html form fields from a model 
*/
class RedModel_Form {

  public static function getFields ($model) {
    if (!is_object($model)) $model = new $model;
    if (@$model->metamodel) $model = $model->metamodel; 
    foreach ($model->fields as $k=>$v) {
      if (@$v->constraints['hidden'] && $v->constraints['hidden']->value) return;
      $html .= "<label for='$k'><span>{$v->title}</span><input type='text' name='$k' /></label>";
    }
    $cssClass = strtolower("{$model->name}_fields");
    return "<fieldset class='$cssClass'>$html</fieldset>";
  } 

}

