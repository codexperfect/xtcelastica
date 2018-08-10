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

  public function index() {
    $esObject = $this->buildEsObject();

    $xtcRequest = New IndexElasticaXtcRequest('test_local');
    $xtcRequest->setRequest('index-doc');
    $xtcRequest->setConfig();

    return $xtcRequest->index($esObject);
  }

  public function setEid($eid){
    $this->id = $eid;
    return $this;
  }

  protected function prepareField($fieldname){
    $field = $this->content->get($fieldname);
    return (New EntityField($field))->getValues();
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
      case 'learningResourceType':
        $d8Name = $this->getActiveField($d8Name);
      default:
        $value = $this->prepareField($d8Name);
    }
    return $value;
  }

  protected function getActiveField($fieldname){
    $name = [
      'Actualité' => 'field_type_actualite',
      'Comité, commissions ou autre instance' => 'field_type_de_comite',
      'Ressource documentaire ou service de l\'Ordre' => 'field_type_de_ressource',
      'Référentiel normatif' => 'field_type_de_referentiel',
      'Article' => 'field_type_d_article',
    ];
    $contenu = $this->content->get($fieldname);
    return $name[$contenu->getString()];
  }

}