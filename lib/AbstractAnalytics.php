<?php
abstract class AbstractAnalytics {

  protected $debug = false;

  public function __construct($debug)
  {
    $this->debug = $debug;
  }

  public function Track($title)
  {
    if(!method_exists($this, "getHitData")) {
      throw new Exeption("Missing getHitData function");
    }

    $response = $this->_URLPostCurl(
      $this->getHost(),
      $this->getHitData($this->getUrlPath(), $title)
    );

    if ($this->debug) {
      echo $response;
    }
    return $response;
  }

  public function TrackEvent($category, $action, $label = null, $value = null)
  {
    if(!method_exists($this, "getEventData")) {
      throw new Exeption("Missing getEventData function");
    }

    $response = $this->_URLPostCurl(
      $this->getHost(),
      $this->getEventData($category, $action, $label, $value)
    );

    if ($this->debug) {
      error_log(var_export($response, true));
    }
    return $response;
  }

  public function Error($title, $errorcode)
  {
    if (!method_exists($this, "getErrorRequest")) {
      throw new Exception("Missing getErrorRequest function");
    }

    $response = $this->_URLPostCurl(
      $this->getHost(),
      $this->getErrorRequest($this->getUrlPath(), $title, $errorcode)
    );

    if ($this->debug) {
      echo $response;
    }
    return $response;
  }

  abstract protected function getHost();

  protected function getUrlPath()
  {
    return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') .
      '://' .
      "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  }

  protected function _getUserAgent()
  {
    return array_key_exists('HTTP_USER_AGENT', $_SERVER) ? $_SERVER['HTTP_USER_AGENT'] : "";
  }

  protected function _getReferer()
  {
    return array_key_exists('HTTP_REFERER', $_SERVER) ? $_SERVER['HTTP_REFERER'] : "";
  }

  protected function _getRemoteIP()
  {
    return array_key_exists('REMOTE_ADDR', $_SERVER) ? $_SERVER['REMOTE_ADDR'] : "";
  }

  private function _URLPostCurl($url, $data)
  {
    $content = http_build_query($data);
    $content = utf8_encode($content);
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_URL => $url,
      CURLOPT_POSTFIELDS => $content
    ));
    $resp = curl_exec($curl);
    curl_close($curl);
    return $resp;
  }
}