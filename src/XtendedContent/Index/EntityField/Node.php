<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 16/07/2018
 * Time: 16:57
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;


class Node extends XtcEntityField
{

  protected function load(){
    $this->entity = \Drupal\node\Entity\Node::load($this->id);
    return $this;
  }

  public function getType(){
    return $this->entity->get('type')->getString();
  }

}