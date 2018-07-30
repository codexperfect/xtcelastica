<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 22/06/2018
 * Time: 10:47
 */

namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


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
    if ($this->isAllowed($method)){
      try {
        $this->client->init($method, $param);
        $this->client->index($document);
        return $this;
      } catch (RequestException $e) {
        return ('Request error: ' . $e->getMessage());
      }
    }
    else{
      return (t('Request error: The "'.$method.'" method is not allowed.'));
    }

  }

}