<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 19/07/2018
 * Time: 14:05
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERParagraph;


use Drupal\Component\Serialization\Json;
use Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType\Paragraph;

class MotsCles extends Paragraph
{

  public function get(){
    $json = substr($this->entity->get('field_mots_cles')->getString(), 1, -1);
    $motsCles = Json::decode($json);
    $this->data['contenu']['name'] = $motsCles['label'];
    $this->data['contenu']['id'] = $motsCles['value'];
    return $this->data;
  }

}