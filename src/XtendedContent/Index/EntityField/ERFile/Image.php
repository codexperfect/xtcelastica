<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 20/07/2018
 * Time: 12:14
 */
namespace Drupal\xtcelastica\XtendedContent\Index\EntityField\ERFile;


use Drupal\xtcelastica\XtendedContent\Index\EntityField\ERType\File;

class Image extends File {

  public function get(){
    $entity = $this->field->getParent();
    $render_array = $entity->get('field_image')->view('full');
    $this->data['contenu']['text'] = \Drupal::service('renderer')->renderRoot($render_array)->jsonSerialize();
    $this->data['contenu']['description'] = $entity->get('field_credit')->getString();
    return $this->data;
  }

}