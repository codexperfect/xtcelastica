<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 11:01
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


use Drupal\xtc\XtendedContent\Serve\Client\AbstractClient;
use Drupal\xtc\XtendedContent\Serve\Client\ClientInterface;
use Elastica\Client;

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
    $this->client = New Client($this->options);
    return $this;
  }

  /**
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function setOptions()  : ClientInterface {
    $this->setClientProfile();
    $options = [
      'host' => $this->getInfo('host'),
      'port' => $this->getInfo('port'),
      'path' => $this->getInfo('path'),
      'url' => $this->getInfo('url'),
      'proxy' => $this->getInfo('proxy'),
      'transport' => $this->getInfo('transport'),
      'persistent' => $this->getInfo('persistent'),
      'timeout' => $this->getInfo('timeout'),
      'connections' => $this->getInfo('connections'),
      'roundRobin' => $this->getInfo('roundRobin'),
      'log' => $this->getInfo('log'),
      'retryOnConflict' => $this->getInfo('retryOnConflict'),
      'bigintConversion' => $this->getInfo('bigintConversion'),
      'username' => $this->getInfo('username'),
      'password' => $this->getInfo('password'),
    ];
    $this->options = $options;
    return $this;
  }

}
