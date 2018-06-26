<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:29
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


use Drupal\Core\Entity\Entity;

class IndexElasticaClient extends AbstractElasticaClient
{

  public function indexElasticaDoc(){
    $clientParams = $this->getParams();
    $this->content = $this->client->index($clientParams);
    return $this;
  }

  public function reindexElastica(){
    $clientParams = $this->getParams();
    $this->content = $this->client->reindex($clientParams);
    return $this;
  }


}