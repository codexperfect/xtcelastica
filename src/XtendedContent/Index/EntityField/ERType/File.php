<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 17/07/2018
 * Time: 16:37
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType;


use Drupal\xtcelastica\XtendedContent\Index\EntityField\EntityField;

class File extends EntityField
{

  protected function load(){
    $this->entity = \Drupal\file\Entity\File::load($this->id);
    return $this;
  }

  public function getType(){
    return $this->field->getFieldDefinition()->getType();
  }
}