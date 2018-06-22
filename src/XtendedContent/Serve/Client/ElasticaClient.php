<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:29
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


class ElasticaClient extends AbstractElasticaClient
{
  public function getElasticaDataByID(){
    dump("BOF");
    $clientParams = $this->getParams();
    $clientParams['id'] = $this->param;
    $this->content = $this->client->get($clientParams);
    return $this;
  }

  public function getKnownDoc(){
    dump("NON");
    $clientParams = $this->getParams();
    $queryParams = explode('/', $this->param);
    $clientParams['index'] = $queryParams[0];
    $clientParams['type'] = $queryParams[1];
    $clientParams['id'] = $queryParams[2];
    $this->content = $this->client->get($clientParams);
    return $this;
  }

  public function searchElasticaDocByQuery(){
    dump("ICI");
    $clientParams = $this->getParams();
    dump($clientParams);
    $clientParams['id'] = $this->param;
    $this->content = $this->client->search($clientParams);
    return $this;
  }
}