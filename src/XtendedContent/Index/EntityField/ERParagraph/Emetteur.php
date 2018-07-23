<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 19/07/2018
 * Time: 12:36
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERParagraph;


use Drupal\Component\Serialization\Json;
use Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType\Paragraph;

class Emetteur extends Paragraph
{

  public function get(){
    $this->data['direction'] = $this->entity->get('field_direction_emetteur')->getString();

    $this->data['contenu']['emetteur'] = [];
    $json = substr($this->entity->get('field_emetteur')->getString(), 1, -1);
    $emetteur = Json::decode($json);
    $this->data['contenu']['emetteur']['name'] = $emetteur['label'];
    $this->data['contenu']['emetteur']['id'] = $emetteur['value'];

    $this->data['pole'] = $this->entity->get('field_pole_emetteur')->getString();
    $this->data['service'] = $this->entity->get('field_service_emetteur')->getString();
    return $this->data;
  }

}