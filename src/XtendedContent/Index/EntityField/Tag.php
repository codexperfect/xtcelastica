<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 18/07/2018
 * Time: 18:08
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;


use Drupal\Component\Serialization\Json;

class Tag extends Paragraph
{

  public function get(){
    $json = substr($this->entity->get('field_tag')->getString(), 1, -1);
    $tag = Json::decode($json);
    $this->data['contenu']['name'] = $tag['label'];
    $this->data['contenu']['id'] = $tag['value'];
    return $this->data;
  }
}