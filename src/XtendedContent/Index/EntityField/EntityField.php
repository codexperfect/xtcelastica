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

class EntityField implements EntityFieldInterface {

  /**
   * @var FieldItemListInterface
   */
  protected $field;

  protected $id;

  protected $data;

  /**
   * @var \Drupal\Core\Entity\EntityInterface|null
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
      $data = $this->getFieldValue();
    }
    elseif (2 > count($values)) {
      $data = $this->getFieldValuesToOne();
    }
    else {
      $data = $this->getFieldValues();
    }
    return $data;
  }

  private function getFieldValue(){
    return $this->getFieldMultiValues($this->field->getValue()[0]);
    $this->data[$this->field->getName()] = $content;
  }

  private function getFieldValuesToOne(){
    foreach ($this->field->getValue() as $key => $value) {
      return $this->getFieldMultiValues($value);
      $this->data[$this->field->getName()] = $content;    }
  }

  private function getFieldValues(){
    foreach ($this->field->getValue() as $key => $value) {
      return $this->getFieldMultiValues($value);
      $this->data[$this->field->getName()][$key] = $content;
    }
  }

  private function getFieldMultiValues($value){
    if ($this->field instanceof EntityReferenceFieldItemList
      && !in_array($this->field->getName(), ['type']) ){
      return $this->getERFieldValues();
    }
    else{
      return $this->getPlainValues($value);
    }
  }

  private function getPlainValues($value){
    if (2 > count($value) && !empty($value[0]) && (2 > count($value[0]))) {
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
    return $data;
  }

  /**
   * @param array $value
   *
   * @return mixed
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  private function getERFieldValues(){
    // Get ER field type.
    $target = $this->field->getSettings()['target_type'];
    $typeClass = $this->buildTypeClass($target);
    $ERType = New $typeClass($this->field);
    if($ERType instanceof EntityFieldInterface){
      $type = $ERType->getType();
      $fieldClass = $this->buildFieldClass($target, $type);
      $paragraph = (New $fieldClass($this->field))->get();
      return $paragraph;
//      if(in_array($type, ['type_actualite'])){
//        return $paragraph;
//      }
//      else {
//        return array_merge(['paragraphType' => $type], $paragraph);
//      }
    }

  }

  private function buildTypeClass($target){
    $config = \Drupal::service('plugin.manager.xtc_elastica_mapping')->getDefinitions()[$target];
    return '\Drupal\\'.$config['type']['module'].'\\'.$config['type']['path'].'\\'.$config['class'];
  }

  private function buildFieldClass($target, $type){
    $config = \Drupal::service('plugin.manager.xtc_elastica_mapping')->getDefinitions()[$target];
    return '\Drupal\\'.$config['field']['module'].'\\'.$config['field']['path'].'\\'.$config['types'][$type];
  }

}