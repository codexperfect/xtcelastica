<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 19/07/2018
 * Time: 12:33
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERParagraph;


use Drupal\Component\Serialization\Json;
use Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType\Paragraph;

class Editeur extends Paragraph
{

  public function get(){
    $json = substr($this->entity->get('field_editeur')->getString(), 1, -1);
    $editeur = Json::decode($json);
    $this->data['contenu']['name'] = $editeur['label'];
    $this->data['contenu']['id'] = $editeur['value'];
    return $this->data;
  }
}