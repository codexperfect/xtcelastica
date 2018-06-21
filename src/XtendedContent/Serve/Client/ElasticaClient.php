<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 11:01
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


use Drupal\Component\Serialization\Json;
use Drupal\xtc\XtendedContent\Serve\Client\AbstractClient;
use Drupal\xtc\XtendedContent\Serve\Client\ClientInterface;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ElasticaClient extends AbstractClient
{

  /**
   * @var string
   */
  private $method;

  /**
   * @var string
   */
  private $param;

  /**
   * @var string
   */
  private $content;

  /**
   * @var array
   */
  private $connection;

  /**
   * @var Client
   */
  private $client;

  /**
   * @var array
   */
  private $request;


  /**
   * @param string $method
   * @param string $param
   *
   * @return ClientInterface
   */
  public function init($method, $param = '') : ClientInterface {
    $this->method = $method;
    $this->param = $param;
    return $this;
  }

  /**
   * @return string
   */
  public function get() : string {
    if(method_exists($this, $this->method)){
      $getMethod = $this->method;
      $this->${"getMethod"}();
    }
    return Json::encode($this->content);
  }

  /**
   * @return ClientInterface
   */
  protected function buildClient() : ClientInterface {
    $this->setOptions();
    $hosts = [
      'host' => $this->getConnectionInfo('host'),
      'port'=> $this->getConnectionInfo('port'),
    ];
    $this->client = ClientBuilder::create()
      ->setHosts($hosts)
      ->setRetries($this->getConnectionInfo('retryOnConflict'))
      ->build();
    return $this;
  }

  public function getElasticaData(){
    $this->content = $this->client->get($this->getParams());
    return $this;
  }

  public function getElasticaDataByID(){
    $clientParams = $this->getParams();
    $clientParams['id'] = $this->param;
    $this->content = $this->client->get($clientParams);
    return $this;
  }

  public function getKnownDoc(){
    $clientParams = $this->getParams();
    $queryParams = explode('/', $this->param);
    $clientParams['index'] = $queryParams[0];
    $clientParams['type'] = $queryParams[1];
    $clientParams['id'] = $queryParams[2];
    $this->content = $this->client->get($clientParams);
    return $this;
  }

  public function getElasticaVersion(){
    $this->content = $this->client->get('version');
    return $this;
  }

  /**
   * @return ClientInterface
   */
  public function setOptions()  : ClientInterface {
    $this->setClientProfile();
    $this->setConnection();
    $this->options = $this->getConnection();
    return $this;
  }

  private function setConnection() : ClientInterface {
    $this->connection = $this->clientProfile['connection'][$this->getinfo('env')];
    return $this;
  }

  /**
   * @return array
   */
  private function getConnection(){
    return $this->connection;
  }

  /**
   * @return array
   */
  private function getRequest(){
    return $this->request;
  }

  protected function getIndex() {
    return (!empty($this->request['index'])) ? $this->request['index'] : '';
  }

  protected function getVerb() {
    return ('GET' == $this->request['method']) ? Request::GET : '';
  }

  protected function getData() {
    return (!empty($this->request['data'])) ? $this->request['data'] : [];
  }

  protected function getQuery() {
    return (!empty($this->request['query'])) ? $this->request['query'] : [];
  }

  protected function getContentType() {
    return (!empty($this->request['type'])) ? $this->request['type'] : '';
  }

  protected function getParams() {
    return (!empty($this->request['params'])) ? $this->request['params'] : [];
  }

  protected function getConnectionInfo($item) {
    return (!empty($this->connection[$item])) ? $this->connection[$item] : '';
  }

  /**
   * @return ClientInterface
   */
  public function setRequest($requestName) : ClientInterface
  {
    $this->request = $this->xtcConfig['xtc']['serve_client']['request'][$requestName];
    return $this;
  }

  /**
   * @return ClientInterface
   */
  public function setClientProfile() : ClientInterface
  {
    $this->clientProfile = $this->xtcConfig['xtc']['serve_client']['server'][$this->profile];
    return $this;
  }

}
