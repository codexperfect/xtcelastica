<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 18/07/2018
 * Time: 18:30
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;


use Drupal\Component\Serialization\Json;

class Auteur extends Paragraph
{

  public function get(){
    $json = substr($this->entity->get('field_auteur')->getString(), 1, -1);
    $auteur = Json::decode($json);
    $this->data['contenu']['name'] = $auteur['label'];
    $this->data['contenu']['id'] = $auteur['value'];
    return $this->data;
  }

}