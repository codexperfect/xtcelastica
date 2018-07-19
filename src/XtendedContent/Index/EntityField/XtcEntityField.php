<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 16/07/2018
 * Time: 16:52
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;

use Drupal\Core\Field\EntityReferenceFieldItemList;
use Drupal\Core\Field\FieldItemListInterface;

class XtcEntityField implements EntityFieldInterface {

  /**
   * @var FieldItemListInterface
   */
  protected $field;

  protected $id;

  protected $data;

  /**
   * @var \Drupal\Core\Entity\EntityInterface
   */
  protected $entity;

  /**
   * AbstractEntityField constructor.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $field
   */
  public function __construct(FieldItemListInterface $field) {
    $this->field = $field;
    $this->id = (!empty($field->getValue()[0]['target_id'])) ? $field->getValue()[0]['target_id'] : '';
    $this->load();
  }

  /**
   * {@inheritdoc}
   */
  public function build($tags) {
    dump("BUILDING");
    dump($this->getPluginDefinition());

    $build = [];
    return $build;
  }

  protected function load(){
    $this->entity = null;
    return $this;
  }

  public function get(){
    return '';
  }

  public function getType(){
    return '';
  }

  public function getEntity(){
    return $this->entity;
  }

  public function getValues(){
    $values = $this->field->getValue();
    if (2 > count($values) && !empty($values[0]) && (2 > count($values[0]))) {
      $this->getFieldValue();
    }
    elseif (2 > count($values)) {
      $this->getFieldValuesToOne();
    }
    else {
      $this->getFieldValues();
    }
    return $this->data;
  }

  private function getFieldValue(){
    $this->data[$this->field->getName()]  = $this->getFieldMultiValues($this->field->getValue()[0]);
  }

  private function getFieldValuesToOne(){
    foreach ($this->field->getValue() as $key => $value) {
      $this->data[$this->field->getName()]  = $this->getFieldMultiValues($value);
    }
  }

  private function getFieldValues(){
    foreach ($this->field->getValue() as $key => $value) {
      $this->data[$this->field->getName()][$key]  = $this->getFieldMultiValues($value);
    }
  }

  private function getFieldMultiValues($value){
    $data = [];
    if($this->field instanceof EntityReferenceFieldItemList){
      $definition = $this->getPluginDefinition()['first'];
      dump($definition);
      dump("DEF");
      $item = EntityFieldBuilder::builder($this->field);
      if(!empty($item)){
        $data = $item->get();
      }
    }
    else{
      $currentField = $this->field->getValue();
      if (2 > count($currentField) && !empty($currentField[0]) && (2 > count($currentField[0]))) {
        $data = $this->field->getString();
      }
      else {
        $value = $this->field->getValue()[0];
        if(isset($value['value'])){
          $data = $value['value'];
        }
        elseif(isset($value['target_id'])){
          $data = $value['target_id'];
        }
        else {
          $data = $value;
        }
      }
    }
//    dump($data);
    return $data;
  }

}