<?php

namespace Drupal\xtcelastica\Plugin\XtcHandler;


use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;
use Drupal\xtc\XtendedContent\API\XtcProfile;
use Drupal\xtcsearch\Form\Traits\FilterSearchTrait;
use Drupal\xtcsearch\Form\Traits\PaginationTrait;
use Drupal\xtcsearch\Form\Traits\QueryTrait;
use Elastica\Document;
use Elastica\Exception\InvalidException;

/**
 * Plugin implementation of the xtc_handler for File.
 *
 */
abstract class ElasticaBase extends XtcHandlerPluginBase
{

  use FilterSearchTrait;
  use QueryTrait;
  use PaginationTrait;

  const TIMEOUT = 5;

  /**
   * @var array
   */
  protected $definition;

  /**
   * @var array
   */
  protected $server = [];

  /**
   * @var array
   */
  protected $request = [];


  public function get() {
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

  public function getFilters() {
    return $this->get()
                ->filters();
  }

  protected function filters(){
    foreach($this->filters as $name => $container) {
      $filter = $this->loadFilter($name);
      if(!empty($this->resultSet)){
        try{
          $agg = $this->resultSet->getAggregation($filter->getFieldName());
        }
        catch(InvalidException $e){
        }
        finally{
        }
      }

      if (!empty($agg['buckets'])) {
        foreach ($agg['buckets'] as $option) {
          $options[$option['key']] = $option['key'] . ' (' . $option['doc_count'] . ')';
        }
      }
      $facets[$name] = $options;

    }
    return $facets;
  }

  protected function getTimeout(){
    return self::TIMEOUT;
  }

}
