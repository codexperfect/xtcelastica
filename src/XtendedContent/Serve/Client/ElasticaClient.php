<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 11:01
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\Client;


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
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
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
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  protected function buildClient() : ClientInterface {
    $this->setOptions();
    $this->client = New
    ($this->options);
    return $this;
  }

}
