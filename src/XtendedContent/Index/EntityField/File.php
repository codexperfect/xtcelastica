<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 17/07/2018
 * Time: 16:37
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;


class File extends XtcEntityField
{

  protected function load(){
    $this->entity = \Drupal\file\Entity\File::load($this->id);
    return $this;
  }

}