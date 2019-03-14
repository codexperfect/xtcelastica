<?php

namespace Drupal\xtcelastica\Plugin\XtcHandler;


use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;

/**
 * Plugin implementation of the xtc_handler.
 *
 * @XtcHandler(
 *   id = "elastica",
 *   label = @Translation("Elastica for XTC"),
 *   description = @Translation("Elastica for XTC description.")
 * )
 */
class Elastica extends ElasticaBase
{

  /**
   * @param array $options
   *
   * @return \Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase
   */
  public function setOptions($options = []) : XtcHandlerPluginBase {
    $this->options = $options;
    return $this;
  }
}
