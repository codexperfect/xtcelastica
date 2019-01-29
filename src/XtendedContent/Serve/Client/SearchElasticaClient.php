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
  protected $response;

  protected function triggerSearch($callback, $value = '', $label = ''){
    $this->initClientParams();
    $this->response = $this->client->search($this->clientParams);
    if(!empty($this->response)){
      $this->${"callback"}($value, $label);
    }
    return $this;
  }

  protected function initClientParams(){
    if(!empty($this->param['count']) ){
      $this->clientParams['size'] = $this->param['count'];
    }
    foreach (self::SEARCH_PARAMS as $param){
      if(!empty($this->param[$param]) ){
        $this->clientParams[$param] = $this->param[$param];
      }
      if(empty($this->clientParams[$param]) && !empty($this->getArg($param))){
        $this->clientParams[$param] = $this->getArg($param);
      }
    }
    if(
      !empty($this->clientParams['body']) &&
      !empty($this->clientParams['q'])
    ){
      unset($this->clientParams['q']);
    }
    elseif(empty($this->param['q'])){
      $this->param['q'] = '';
    }
    if(empty($this->clientParams['timeout']) ){
      $this->clientParams['timeout'] = 5;
    }
  }

  public function searchElasticaDocByQuery(){
    $clientParams = $this->getParams();
    $this->content = $this->client->search($clientParams);
    return $this;
  }
}