<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 12/07/2018
 * Time: 15:02
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


interface IndexElasticaClientInterface {

  public function index($document);
}