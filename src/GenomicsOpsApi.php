<?php
namespace Pixiekat\FhirGenomexPhpBridge;

use GuzzleHttp\Client;

class GenomicsOpsApi implements GenomicsOpsApiInterface {

  /**
   * The base api url for all endpoints.
   *
   * @access protected
   * @var $baseApiUrl
   */
  protected static $baseApiUrl = 'https://fhir-gen-ops.herokuapp.com/';

  /**
   * The GuzzleHttp\Client definition.
   *
   * @access protected
   * @var \GuzzleHttp\Client
   */
  protected $client;

  /**
   * Determines debug mode.
   *
   * @access protected
   * @var $debugMode
   */
  protected static $debugMode = FALSE;

  /**
   * The current subject referenced.
   *
   * @access protected
   * @var $subject
   */
  protected $subject;

  /**
   * The constructor
   *
   * @access public
   */
  public function __construct() {
    $this->client = new Client(['base_uri' => self::$baseApiUrl, 'debug' => self::$debugMode, 'http_errors' => self::$debugMode]);
  }

  /**
   * Sends a request in Guzzle.
   *
   * @access protected
   * @return \GuzzleHttp\Psr7\Response
   */
  protected function buildRequest($method, $endpoint, $options = []): \GuzzleHttp\Psr7\Response {
    $response = $this->client->request($method, $endpoint, $options);
    return $response;
  }

  /**
   * Get feature coordinates.
   *
   * @access public
   * @param $chromosome string
   * @param $gene string
   * @param $transcript string
   * @param $protein string
   * @return array
   */
  public function getFeatureCoordinates($chromosome = null, $gene = null, $transcript = null, $protein = null): array {
    $args = func_get_args();
    if (!empty($args)) {
      $options = ['query' => [
        'chromosome' => $chromosome,
        'gene' => $gene,
        'transcript' => $transcript,
        'protein' => $protein,
      ]];
      $response = $this->buildRequest('GET', 'utilities/get-feature-coordinates', $options);
      if ($response) {
        $contents = json_decode($response->getBody()->getContents());
        if ($contents) {
          $data = current($contents);
          return get_object_vars($data);
        }
      }
    }
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getSubject(): ?string {
    return $this->subject;
  }

  /**
   * {@inheritdoc}
   */
  public function setSubject($subject): self {
    $this->subject = $subject;
    return $this;
  }
}
