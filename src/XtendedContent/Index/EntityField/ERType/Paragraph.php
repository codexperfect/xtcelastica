<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 16/07/2018
 * Time: 16:56
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType;


use Drupal\xtcelastica\XtendedContent\Index\EntityField\EntityField;

class Paragraph extends EntityField
{

  protected function load(){
    $this->entity = \Drupal\paragraphs\Entity\Paragraph::load($this->id);
    return $this;
  }

  public function getType(){
    return $this->entity->get('type')->getString();
  }

}