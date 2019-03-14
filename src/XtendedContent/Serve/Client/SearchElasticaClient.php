<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:29
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


use Elastica\Query;
use Elastica\Response;
use Elastica\ResultSet;

class SearchElasticaClient extends AbstractElasticaClient
{
  /**
   * @var \Elastica\ResultSet
   */
  protected $resultSet;

  /**
   * @param        $callback
   * @param string $value
   * @param string $label
   *
   * @return $this
   */
  protected function triggerSearch($callback, $value = '', $label = ''){
    $this->initClientParams();
//    $this->resultSet = $this->client->search($this->clientParams);


    try{
      $this->resultSet = $this->client->search($this->clientParams);
      $this->results = [];
    }
    catch(\Exception $exception){
      $msg = $exception->getMessage();
      \Drupal::logger('xtc.elastica')->critical(
        'Message: @message',
        [
          '@message' => $exception->getMessage(),
        ]
      );
      \Drupal::messenger()->addError($msg);
    }
    finally{
      if(empty($this->resultSet)){
        $response = New Response('');
        $result = [];
        $this->resultSet = New ResultSet($response, New Query(), $result);
        $this->results = $this->getDocuments();
      }
      else{
        $this->results = $this->getDocuments();
      }
      $this->searched = true;
    }



    if(!empty($this->resultSet)){
      $this->${"callback"}($value, $label);
    }
    return $this;
  }

  /**
   * @return array Documents \Elastica\Document
   */
  public function getDocuments(){
    if(!empty($this->resultSet->getResults())){
      return $this->resultSet->getDocuments();
    }
    return [];
  }

  protected function initClientParams(){
    if(!empty($this->param['count']) ){
      $this->clientParams['size'] = $this->param['count'];
    }
    if(empty($this->params['timeout']) ){
      $this->param['timeout'] = '5s';
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
  }

  public function searchElasticaDocByQuery(){
    $clientParams = $this->getParams();
    $this->content = $this->client->search($clientParams);
    return $this;
  }
}