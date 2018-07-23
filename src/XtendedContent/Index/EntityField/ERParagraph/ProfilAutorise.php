<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 19/07/2018
 * Time: 14:08
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERParagraph;


use Drupal\Component\Serialization\Json;
use Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType\Paragraph;

class ProfilAutorise extends Paragraph
{

  public function get(){
    $profils = $this->entity->get('field_profil_autorise')->getValue();
    foreach ($profils as $key => $value){
      $this->data['group'][$key] = $value['value'];
    }
    $portees = [
      0 => ['value' => 'extranet']
    ];
    foreach ($portees as $key => $value){
      $this->data['scope'][$key] = $value['value'];
    }
    return $this->data;
  }

}