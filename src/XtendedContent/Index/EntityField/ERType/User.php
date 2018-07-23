<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 17/07/2018
 * Time: 16:17
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType;


use Drupal\xtcelastica\XtendedContent\Index\EntityField\EntityField;

class User extends EntityField
{

  protected function load(){
    $this->entity = \Drupal\user\Entity\User::load($this->id);
    return $this;
  }

  public function getType(){
    return 'user';
  }
}