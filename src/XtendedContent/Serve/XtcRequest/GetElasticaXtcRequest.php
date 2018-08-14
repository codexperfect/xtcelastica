<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:47
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\xtcelastica\XtendedContent\Serve\Client\GetElasticaClient;

class GetElasticaXtcRequest extends AbstractElasticaXtcRequest
{
  /**
   * @return \Drupal\xtcelastica\XtendedContent\Serve\Client\AbstractElasticaClient
   */
  protected function getElasticaClient(){
    return New GetElasticaClient($this->profile);
  }

}