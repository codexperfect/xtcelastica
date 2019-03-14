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
use Elastica\Request;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

abstract class AbstractElasticaClient extends AbstractClient implements ElasticaClientInterface
{
  const SEARCH_PARAMS = ['index','type','analyzer','analyze_wildcard',
    'default_operator','df','explain','fields','from','ignore_indices',
    'indices_boost','lenient','lowercase_expanded_terms','preference',
    'q','query_cache','request_cache','routing','scroll','search_type',
    'size','sort','source','_source','_source_exclude','_source_include',
    'stats','suggest_field','suggest_mode','suggest_size','suggest_text',
    'timeout','terminate_after','version'];

  /**
   * @var string
   */
  public $method;

  /**
   * @var array
   */
  protected $param;

  /**
   * @var string
   */
  protected $clientParams;

  /**
   * @var string
   */
  protected $content;

  /**
   * @var array
   */
  protected $connection;

  /**
   * @var Client
   */
  protected $client;

  /**
   * @var array
   */
  public $request;

  /**
   * @var array
   */
  protected $args;


  /**
   * @param string $method
   * @param string $param
   *
   * @return ClientInterface
   */
  public function init($method, $param = '') : ClientInterface {
    $this->method = $method;
    if(! is_array($param)){
      parse_str($param, $this->param);
      $this->setArgs();
    }
    return $this;
  }

  /**
   * @return string
   */
  public function get() : string {
    $this->clientParams = $this->getParams();
    if(method_exists($this, $this->method)){
      $getMethod = $this->method;
      $this->${"getMethod"}();
    }
    return (!empty($this->content)) ? Json::encode($this->content) : '';
  }

  /**
   * @return ClientInterface
   */
  protected function buildClient() : ClientInterface {
    $this->setOptions();
    $hosts[0] = $this->getConnection();
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
    $env = $this->getinfo('env');
    $this->connection = $this->clientProfile['connection'][$env];
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
  protected function getRequest(){
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

  public function getParams() {
    return (!empty($this->request['params'])) ? $this->request['params'] : [];
  }

  public function getMethod() {
    return (!empty($this->request['method'])) ? $this->request['method'] : '';
  }

  protected function setArgs() {
    $this->args = (!empty($this->xtcConfig['xtc']['serve_client'][$this->profile]['args']))
      ? $this->xtcConfig['xtc']['serve_client'][$this->profile]['args']
      : [];
    foreach ($this->param as $key => $value){
      $this->args[$key] = $value;
    }
    foreach($this->args as $key => $arg){
      if(!in_array($key, $this->request['args'])){
        unset($this->args[$key]);
      }
    }
    return $this;
  }

  protected function getArgs() {
    return $this->args;
  }

  protected function getArg($name) {
    return (!empty($this->args[$name])) ? $this->args[$name] : '';
  }

  protected function getConnectionInfo($item) {
    return (!empty($this->connection[$item])) ? $this->connection[$item] : '';
  }

  /**
   * @return ClientInterface
   */
  public function setRequest($requestName) : ClientInterface
  {
    $request = $this->xtcConfig['xtc']['serve_client'][$this->profile]['request'];
    $this->request = $this->xtcConfig['xtc']['serve_client']['request'][$request];
    return $this;
  }

  /**
   * @return ClientInterface
   */
  public function setClientProfile() : ClientInterface
  {
    $server = $this->xtcConfig['xtc']['serve_client'][$this->profile]['server'];
    $this->clientProfile = $this->xtcConfig['xtc']['serve_client']['server'][$server];

    return $this;
  }

}
