<?php

namespace Drupal\xtcelastica\Plugin\XtcHandler;


use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;
use Elastica\Document;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "elastica_search",
 *   label = @Translation("Elastica for XTC"),
 *   description = @Translation("Elastica for XTC description.")
 * )
 */
class Elastica extends ElasticaBase
{

  public function process() {
    $this->definition = $this->profile;
    $this->initFilters();
    $this->initElastica();
    $this->initPagination();
    $this->initQuery();

    $this->setCriteria();
    $this->getResultSet();
    $docs = $this->getDocuments();
    if(!empty($docs[0]) && $docs[0] instanceof Document){
      $this->content['totalHits'] = $this->resultSet->getTotalHits();
      foreach($this->getDocuments() as $item){
        $this->content['values'][] = $item->getData();
      }
    }
    return $this;
  }

  /**
   * @param array $options
   *
   * @return \Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase
   */
  public function setOptions($options = []) : XtcHandlerPluginBase {
    $this->options = $options;
    return $this;
  }
}
