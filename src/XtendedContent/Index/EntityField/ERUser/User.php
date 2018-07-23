<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 20/07/2018
 * Time: 11:39
 */
namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERUser;

use Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType\User as UserType;

class User extends UserType
{
  public function get(){
    $this->data['contenu']['name'] = $this->entity->get('name')->getString();
    $this->data['contenu']['id'] = $this->entity->get('uid')->getString();
    return $this->data;
  }

}