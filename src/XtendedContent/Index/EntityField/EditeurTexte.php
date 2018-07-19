<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 17/07/2018
 * Time: 18:34
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;


class EditeurTexte extends Paragraph
{

  public function get(){
    $ref = $this->entity->get('field_texte')->getValue();
    $this->data['contenu']['text'] = $ref[0]['value'];
    $this->data['contenu']['format'] = $ref[0]['format'];
    return $this->data;
  }

}