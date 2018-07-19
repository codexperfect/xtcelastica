<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 18/07/2018
 * Time: 16:08
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;


class Document extends Paragraph
{

  public function get(){
    $data = [];
    $data['title'] = $this->entity->get('field_titre_rubrique')->getString();
    $documents = $this->entity->get('field_documents_connexes')->getValue();
    $docs = [];
    foreach ($documents as $key => $value){
      $docs[$key] = $this->loadParagraph($value['target_id']);
    }
    $data['contenu'] = $docs;
    return $data;
  }

}