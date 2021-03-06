<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 16/07/2018
 * Time: 16:11
 */

namespace Drupal\xtcelastica\XtendedContent\Index\Content;


use Drupal\node\Entity\Node;

abstract class AbstractElasticaNode extends AbstractElasticaContent
{

  public function load(){
    $this->content = Node::load($this->id);
    return $this;
  }

  public function index() {
    $esObject = $this->buildEsObject();
    $service = \Drupal::service('xtcelastica.es_index_node')->setConfig();
    return $service->index($esObject);
  }

  public function unindex() {
    $esObject = $this->buildEsObject();
    $service = \Drupal::service('xtcelastica.es_unindex_node')->setConfig();
    return $service->unindex($esObject);
  }

}