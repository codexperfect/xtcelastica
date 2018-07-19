<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 16/07/2018
 * Time: 16:07
 */

namespace Drupal\xtcelastica\XtendedContent\Index\Content;


use Drupal\entity_reference_revisions\EntityReferenceRevisionsFieldItemList;
use Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\IndexElasticaXtcRequest;
use Drupal\xtcelastica\XtendedContent\Index\EntityField\Paragraph;

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

  public function __construct($id) {
    $this->id = $id;
    $this->load();
  }

  public function index() {
    $this->prepareContent();
    dump($this->data);
    $esObject = $this->buildEsObject();
    dump($esObject);

    $xtcRequest = New IndexElasticaXtcRequest('csoec-es');
    $xtcRequest->setRequest('index-doc');
    $xtcRequest->setConfig();
    dump($xtcRequest);
    $response = "OK ???";
//    $response = $xtcRequest->index($esObject);
    return $response;
//    return New JsonResponse($response);
  }

  private function prepareContent(){
    foreach ($this->content->getFields() as $fieldname => $field){
//            if('field_composants' == $fieldname){
      if($field instanceof EntityReferenceRevisionsFieldItemList){
        $target = $field->getSettings()['target_type'];
        $definition = \Drupal::service('plugin.manager.xtc_elastica_mapping')->getDefinitions();

        $entityStorage = \Drupal::entityTypeManager()->getStorage($target);
        $eid = $field->getValue()[0]['target_id'];
        $entity = $entityStorage->load($eid);

        $type = $entity->get('type')->getString();
        $class = '\Drupal\xtcelastica\XtendedContent\Index\EntityField\\'.$definition[$target]['types'][$type];
        dump($class);

        $content = New $class($field);
        dump($content);
        $this->data[$fieldname] = $content->get();
        dump($this->data);
//        $class = $target;
//        dump($class);
//        $content = $entity->load($eid);
//        dump($content);
////        $xtcField = New XtcEntityField($field);
//        $type = $entity->getPluginDefinition();
//        dump("INDEX");
//        dump($type);
//        $class = $type[$target]['types'][$entity->get('type')->getString()];
//        dump($class);
//        $this->data[$fieldname] = $xtcField->getValues();
      }
    }
  }

  protected function load(){
    $this->content = null;
    return $this;
  }

  private function buildEsObject(){
    $configuration = \Drupal::config('csoec_content.xtc.index')->getRawData();
    $config = $configuration['xtcontent']['index_map']['es2d8'];
    $esArray = [];
    foreach($config as $esName => $d8Name){
      $esArray[$esName] = $this->map($esName, $d8Name);
    }
    return $esArray;
  }

  private function map($esName, $d8Name){
    switch ($esName){
      default:
        $value = $this->data[$d8Name];
    }
    return $value;
  }


}