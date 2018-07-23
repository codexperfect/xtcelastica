<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 20/07/2018
 * Time: 14:08
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERTerm;


use Drupal\Component\Serialization\Json;
use Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType\Term;

class TypeActualite extends Term
{

  public function get(){
//    $this->data['title'] = $this->entity->get('name')->getString();
//    $this->data['vocabulary'] = $this->entity->get('vid')->getString();
    $this->data = $this->entity->get('name')->getString();
    return $this->data;
  }

}
