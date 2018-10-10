<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:47
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\Core\Site\Settings;
use Drupal\xtc\XtendedContent\API\Config;
use Drupal\xtcelastica\XtendedContent\Serve\Client\IndexElasticaClient;
use Drupal\xtcelastica\XtendedContent\Serve\Client\IndexElasticaClientInterface;
use GuzzleHttp\Exception\RequestException;

class IndexElasticaXtcRequest extends AbstractElasticaXtcRequest
{

  /**
   * @var IndexElasticaClientInterface
   */
  protected $client;

  protected function getElasticaClient(){
    return New IndexElasticaClient($this->profile);
  }

  /**
   * @param array $document
   *
   * @return $this|\Drupal\Core\StringTranslation\TranslatableMarkup|string
   */
  public function index(array $document){
    $method = $this->webservice['method'];
    $param = $this->webservice['params'];
    try {
      $this->client->init($method, $param);
      $this->client->index($document);
      return $this;
    } catch (RequestException $e) {
      return ('Request error: ' . $e->getMessage());
    }
  }

  /**
   * @param array $document
   *
   * @return $this|\Drupal\Core\StringTranslation\TranslatableMarkup|string
   */
  public function unindex(array $document){
    $method = $this->webservice['method'];
    $param = $this->webservice['params'];
    try {
      $this->client->init($method, $param);
      $this->client->index($document);
      return $this;
    } catch (RequestException $e) {
      return ('Request error: ' . $e->getMessage());
    }
  }

  public function getConfigFromYaml()
  {
    $client = Config::getConfigs('serve', 'client');
    $index = Config::getConfigs('serve', 'index');
    $params = array_merge_recursive($client, $index);

    // Enable config override from settings.local.php
    $settings = Settings::get('csoec.serve_client');
    if(!empty($settings)){
      return array_replace_recursive($params, $settings);
    }
    return $params;
  }

}