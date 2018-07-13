<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:29
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


use Drupal\Core\Entity\Entity;
use Drupal\xtc\XtendedContent\Serve\Client\ClientInterface;

class IndexElasticaClient extends AbstractElasticaClient implements IndexElasticaClientInterface
{

  /**
   * @param array $document
   *
   * @return string
   */
  public function index($document) : string {
    $this->param = $document;
    if(method_exists($this, $this->method)){
      $getMethod = $this->method;
      $this->${"getMethod"}();
    }
    return Json::encode($this->content);
  }


  public function indexElasticaDoc(){
    $clientParams = $this->getParams();
    $clientParams['type'] = '_doc';
    $clientParams['id'] = $this->param['id'];
    unset($this->param['id']);
    $clientParams['body'] = $this->param;
    $this->content = $this->client->index($clientParams);
    return $this;
  }

  public function reindexElastica(){
    $clientParams = $this->getParams();
    $this->content = $this->client->reindex($clientParams);
    return $this;
  }

}