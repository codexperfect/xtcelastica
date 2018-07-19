<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 17/07/2018
 * Time: 16:14
 */

namespace Drupal\xtcelastica\XtendedContent\Index\EntityField;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Field\EntityReferenceFieldItemList;

class EntityFieldBuilder extends PluginBase {

//  public static function builder(EntityReferenceFieldItemList $field){
//    $entityType = $field->getSettings()['target_type'];
////    dump($field);
//    switch ($entityType){
//      case 'node':
//        $entity = New Node($field);
//        break;
//      case 'paragraph':
//        $entity = self::buildParagraph($field);
//        break;
//      case 'file':
//        $entity = New File($field);
//        break;
//      case 'taxonomy_term':
//        $entity = New Term($field);
//        break;
//      case 'user':
//        $entity = New User($field);
//        break;
//      default:
//        $entity = null;
//    }
//    return $entity;
//  }
//
//  private static function buildParagraph(EntityReferenceFieldItemList $field){
//    $paragraph = New Paragraph($field);
//    $type = $paragraph->getType();
//    switch ($type){
//      case 'editeur_texte':
//        $entity = New EditeurTexte($field);
//        break;
//      default:
//        $entity = New Paragraph($field);
//    }
//    return $entity;
//  }
}