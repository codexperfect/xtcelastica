<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:21
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\Core\Site\Settings;
use Drupal\xtc\XtendedContent\API\Config;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequestOFF;

abstract class AbstractElasticaXtcRequestOFF extends AbstractXtcRequestOFF
{

  protected $request;

  /**
   * @var \Drupal\xtcelastica\XtendedContent\Serve\Client\AbstractElasticaClient
   */
  protected $client;

  public function setConfigfromPlugins(array $config = [])
  {
    $name = $this->profile;
    $profile = Config::loadXtcProfile($name);

    $settings = Settings::get('xtc.serve_client')['xtc']['serve_client']['server'];

    $server = Config::loadXtcServer($profile['server']);
    $request = Config::loadXtcRequest($profile['request']);
    $this->setRequest($request);

    if(!empty($settings[$profile['server']]['env'])){
      $server['env'] = $settings[$profile['server']]['env'];
    }

    $this->webservice = [
      'type' => $profile['type'],
      'env' => $server['env'],
      'connection' => $server['connection'],
      'method' => $request['method'],
      'args' => $request['args'] ?? [],
      'params' => $request['params'] ?? [],
    ];

    $this->config['xtc']['serve_client'][$name] = $profile;
    $this->config['xtc']['serve_client']['server'][$profile['server']] = $server;
    $this->config['xtc']['serve_client']['request'][$profile['request']] = $request;

    $this->buildClient();
    return $this;
  }

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
