<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:47
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\xtcelastica\XtendedContent\Serve\Client\ElasticaClient;

class ElasticaXtcRequest extends AbstractElasticaXtcRequest
{
  protected function getElasticaClient(){
    return New ElasticaClient($this->profile);
  }

}