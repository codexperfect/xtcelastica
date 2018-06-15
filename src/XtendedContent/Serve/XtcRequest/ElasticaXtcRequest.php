<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:21
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;
use Drupal\xtcelastica\XtendedContent\Serve\Client\ElasticaClient;

class ElasticaXtcRequest extends AbstractXtcRequest
{
  protected function buildClient(){
    if(isset($this->profile)){
      $this->client = new ElasticaClient($this->profile);
    }
    $this->client->setXtcConfigFromYaml();
    return $this;
  }

}
