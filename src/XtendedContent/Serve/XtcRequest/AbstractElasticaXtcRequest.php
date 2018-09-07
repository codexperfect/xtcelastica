<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:21
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;

abstract class AbstractElasticaXtcRequest extends AbstractXtcRequest
{

  private $request;

  /**
   * @var \Drupal\xtcelastica\XtendedContent\Serve\Client\AbstractElasticaClient
   */
  protected $client;

  protected function buildClient(){
    $this->client = $this->getElasticaClient();
    $this->client->setXtcConfig($this->config);
    $this->client->setRequest($this->request);
    return $this;
  }

  public function setRequest($request){
    $this->request = $request;
    return $this;
  }

  /**
   * @return \Drupal\xtcelastica\XtendedContent\Serve\Client\AbstractElasticaClient
   */
  abstract protected function getElasticaClient();

  /**
   * @return $this
   */
  protected function setWebservice()
  {
    $server = $this->config['xtc']['serve_client'][$this->profile]['server'];
    $request = $this->config['xtc']['serve_client'][$this->profile]['request'];
    $requestSettings = (is_array($this->config['xtc']['serve_client']['request'][$request])) ? $this->config['xtc']['serve_client']['request'][$request] : [];
    $this->webservice = array_merge_recursive(
      $this->config['xtc']['serve_client']['server'][$server],
      $requestSettings
    );
    return $this;
  }
}
