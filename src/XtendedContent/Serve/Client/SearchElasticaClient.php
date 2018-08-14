<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:29
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


class SearchElasticaClient extends AbstractElasticaClient
{

  public function searchElasticaDocByQuery(){
    $clientParams = $this->getParams();
    $this->content = $this->client->search($clientParams);
    return $this;
  }
}