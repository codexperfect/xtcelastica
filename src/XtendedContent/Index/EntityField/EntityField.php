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
use Drupal\csoec_ws\XtendedContent\Index\EntityField\ERParagraph\ProfilAutorise;

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
  public function __construct(FieldItemListInterface $field, $delta = 0) {
    $this->field = $field;
    $this->id = (!empty($field->getValue()[$delta]['target_id'])) ? $field->getValue()[$delta]['target_id'] : '';
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
      return $this->getFieldValue();
    }
    if (2 > count($values)) {
      return $this->getFieldValuesToOne();
    }
    if('field_profils_autorises' == $this->field->getName()){
      return $this->getFieldValue();
    }
    return $this->getFieldValues();
  }

  private function getFieldValue(){
    return $this->getFieldMultiValues($this->field->getValue()[0]);
  }

  private function getFieldValuesToOne(){
    foreach ($this->field->getValue() as $key => $value) {
      $content = $this->getFieldMultiValues($value, $key);
    }
    return $content;
  }

  private function getFieldValues(){
    foreach ($this->field->getValue() as $key => $value) {
      $content[$key] = $this->getFieldMultiValues($value, $key);
    }
    return $content;
  }

  private function getFieldMultiValues($value, $delta = 0){
    if (
      ($this->field instanceof EntityReferenceFieldItemList
        && !in_array($this->field->getName(), ['type'])
      )
    ){
      return $this->getERFieldValues($value, $delta);
    }
    else{
      return $this->getPlainValues($value, $delta);
    }
  }

  private function getPlainValues($value, $delta){
    if (2 > count($value) && !empty($value[0]) && (2 > count($value[0]))) {
      return $this->field->getString();
    }
    $value = $this->field->getValue()[$delta];
    if('field_profils_autorises' == $this->field->getName()){
      $ERPlain = New ProfilAutorise($this->field, $delta);
      if($ERPlain instanceof EntityFieldInterface){
        $ERPlain->entity = $this->field->getEntity();
        return $ERPlain->get();
      }
    }
    if(isset($value['value'])){
      return $value['value'];
    }
    if(isset($value['target_id'])){
      return $value['target_id'];
    }
    return $value;
  }

  /**
   * @param array $value
   *
   * @return mixed
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  private function getERFieldValues($value, $delta){
    // Get ER field type.
    $target = $this->field->getSettings()['target_type'];
    $typeClass = $this->buildTypeClass($target);
    $ERType = New $typeClass($this->field, $delta);
    if($ERType instanceof EntityFieldInterface){
      $type = $ERType->getType();
      $fieldClass = $this->buildFieldClass($target, $type);
      $content = (New $fieldClass($this->field, $delta))->get();
      if('field_composants' != $this->field->getName() ){
        return $content;
      }
      else {
        return array_merge(['paragraphType' => $type], $content);
      }
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

  /**
   * @return string
   */
  public function getId(): string {
    return $this->id;
  }

  /**
   * @param string $id
   */
  public function setId(string $id) {
    $this->id = $id;
    return $this;
  }


}