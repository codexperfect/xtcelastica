<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 17/07/2018
 * Time: 16:17
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;


class User extends XtcEntityField
{

  protected function load(){
    $this->entity = \Drupal\user\Entity\User::load($this->id);
    return $this;
  }

}