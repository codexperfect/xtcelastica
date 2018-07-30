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

}