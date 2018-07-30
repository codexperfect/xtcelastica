<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 16/07/2018
 * Time: 16:07
 */

namespace Drupal\xtcelastica\XtendedContent\Index\Content;


use Drupal\xtcelastica\XtendedContent\Index\EntityField\EntityField;
use Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\IndexElasticaXtcRequest;

abstract class AbstractElasticaContent implements ElasticaContentInterface
{

  /**
   * @var integer $id
   */
  protected $id;

  /**
   * @var \Drupal\Core\Entity\FieldableEntityInterface
   */
  protected $content;

  /**
   * @var array
   */
  protected $data;

//  public function __construct($id) {
//    $this->id = $id;
//    $this->load();
//  }

  public function index() {
    $this->prepareContent();
    $esObject = $this->buildEsObject();

    $xtcRequest = New IndexElasticaXtcRequest('test_local');
    $xtcRequest->setRequest('index-doc');
    $xtcRequest->setConfig();

    $response = $xtcRequest->index($esObject);
    return $response;
  }

  public function setEid($eid){
    $this->id = $eid;
    return $this;
  }

  protected function prepareContent(){
    foreach ($this->content->getFields() as $fieldname => $field){
      $this->data[$fieldname] = (New EntityField($field))->getValues();
    }
  }

  abstract public function load();

  protected function buildEsObject(){
    $configuration = \Drupal::config('csoec_content.xtc.index')->getRawData();
    $config = $configuration['xtcontent']['index_map']['es2d8'];
    $esArray = [];
    foreach($config as $esName => $d8Name){
      $esArray[$esName] = $this->map($esName, $d8Name);
    }
    return $esArray;
  }

  protected function map($esName, $d8Name){
    switch ($esName){
      default:
        $value = $this->data[$d8Name];
    }
    return $value;
  }


}