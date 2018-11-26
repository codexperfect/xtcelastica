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

  protected $_unsearchable = false;

  /**
   * @var array
   */
  protected $data;

  abstract public function index();

  abstract public function unindex();

  public function setEid($eid){
    $this->id = $eid;
    return $this;
  }

  protected function prepareField($fieldname){
    $field = $this->content->get($fieldname);
    if(!empty($field->getValue())){
      return (New EntityField($field))->getValues();
    }
  }

  abstract public function load();

  protected function buildEsObject(){
    $this->load();
    $configuration = $this->getConfig();
    $config = $configuration['xtcontent']['index_map'][$this->content->getEntityTypeId()][$this->content->bundle()];
    $params = $configuration['xtcontent']['index_map']['elastica'][$this->content->getEntityTypeId()];
    $esArray = [];
    $esArray['params'] = $params;
    foreach($config as $esName => $d8Name){
      if ($value = $this->map($esName, $d8Name)){
        if('body' == $esName && 'field_composants' != $d8Name){
          $esArray['object'][$esName]['contenu']['text'] = $value;
        }
        else{
          $esArray['object'][$esName] = $value;
        }
      }
    }
    $esArray['object']['unsearchable'] = $this->_unsearchable;
    // if (!isset($esArray['object']['body'][0]) && $esArray['object']['body']) {
    if (empty($esArray['object']['body'][0]) && !empty($esArray['object']['body'])) {
        $tempBody = $esArray['object']['body'];
      unset($esArray['object']['body']);
      $esArray['object']['body'][] = $tempBody;
    }
    return $esArray;
  }

  protected function getConfig(){
    return \Drupal::config('xtcelastica.xtc.serve.index')->getRawData();
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
      'Application web' => 'field_type_d_application',
      'Instance de l\'Ordre' => 'field_type_de_comite',
      'Ressource documentaire ou service de l\'Ordre' => 'field_type_de_ressource',
      'Référentiel normatif' => 'field_type_de_referentiel',
      'Article' => 'field_type_d_article',
      'Video' => 'field_type_de_video',
    ];
    $contenu = $this->content->get($fieldname);
    return $name[$contenu->getString()];
  }

}
