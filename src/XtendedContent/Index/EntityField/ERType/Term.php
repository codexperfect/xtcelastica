<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 16/07/2018
 * Time: 16:58
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType;


use Drupal\xtcelastica\XtendedContent\Index\EntityField\EntityField;

class Term extends EntityField
{

  protected function load(){
    $this->entity = \Drupal\taxonomy\Entity\Term::load($this->id);
    return $this;
  }

  public function getType(){
    return $this->entity->getVocabularyId();
  }

}