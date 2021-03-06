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
use Drupal\xtc\XtendedContent\API\Config;

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
    $this->id = (!empty($field->getValue()[$delta]['target_id'])) ? $field->getValue()[$delta]['target_id'] : $this->field->getEntity()->id();
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

  protected function getPlainValues($value, $delta){
    if (2 > count($value) && !empty($value[0]) && (2 > count($value[0]))) {
      return $this->field->getString();
    }
    $value = $this->field->getValue()[$delta];

    if(in_array($this->field->getName(), ['field_profils_autorises'])){
      return $this->getComplexFieldValues($value, $delta);
    }
    if(in_array($this->field->getName(), ['field_formulaire_question'])){
      return $this->field->view('full')[0]['#markup'];
    }

    if(isset($value['value'])){
      return $value['value'];
    }
    if(isset($value['target_id'])){
      return $value['target_id'];
    }
    return $value;
  }

  protected function getComplexFieldValues($value, $delta){
    // Get ER field type.
    $fieldClass = $this->buildFieldClass();
    return (New $fieldClass($this->field, $delta))->get();
  }

  /**
   * @param array $value
   *
   * @return mixed
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  protected function getERFieldValues($value, $delta){
    // Get ER field type.
    $target = $this->field->getSettings()['target_type'];
    $typeClass = $this->buildTypeClass($target);
    $ERType = New $typeClass($this->field, $delta);
    if($ERType instanceof EntityFieldInterface){
      $type = $ERType->getType();
      $fieldClass = $this->buildFieldClass($target, $type);
      $content = (New $fieldClass($this->field, $delta))->get();
      // if('field_composants' != $this->field->getName() ){
      if( !in_array($this->field->getName(), ['field_composants', 'field_composants_hp'])){
          return $content;
      }
      else {
        return array_merge(['paragraphType' => $type], $content);
      }
    }
  }

  protected function buildTypeClass($target){
    $config = Config::loadXtcMapping($target);
    return '\Drupal\\'.$config['type']['module'].'\\'.$config['type']['path'].'\\'.$config['class'];
  }

  protected function buildFieldClass($target = '', $type = ''){
    if(empty($target)){
      $config = Config::loadXtcMapping('complexfield');
      return '\Drupal\\' . $config['field']['module'] . '\\' . $config['field']['path'] . '\\' . $config['types'][$this->field->getName()];
    }
    else {
      $config = Config::loadXtcMapping($target);
      return '\Drupal\\' . $config['field']['module'] . '\\' . $config['field']['path'] . '\\' . $config['types'][$type];
    }
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
