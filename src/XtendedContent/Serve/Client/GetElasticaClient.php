<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:29
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


class GetElasticaClient extends AbstractElasticaClient
{
  public function getElasticaDataByID(){
    $clientParams = $this->getParams();
    $clientParams['id'] = $this->param['q'];
    try {
      $this->content = $this->client->get($clientParams);
      return $this;
    } finally{
      return $this;
    }
  }

  public function getKnownDoc(){
    $clientParams = $this->getParams();
    $queryParams = explode('/', $this->param['q']);
    $clientParams['index'] = $queryParams[0];
    $clientParams['type'] = $queryParams[1];
    $clientParams['id'] = $queryParams[2];
    $this->content = $this->client->get($clientParams);
    return $this;
  }

}