<?php
require_once "AbstractAnalytics.php";

class GoogleAnalitics extends AbstractAnalytics
{
  const PROTOCOL_VERSION = 1;
  protected $google_host = 'https://www.google-analytics.com/collect';
  protected $google_debug_host = 'https://www.google-analytics.com/debug/collect';

  protected $trackingId = '';

  public function __construct($trackingId, $debug = false)
  {
    parent::__construct($debug);

    $this->trackingId = $trackingId;
  }

  protected function getHost()
  {
    if ($this->debug) {
      return $this->google_debug_host;
    }
    return $this->google_host;
  }

  protected function getHitData($url, $title)
  {
    $cid = $this->_ParseOrCreateAnalyticsCookie();

    return array(
      'v'   => self::PROTOCOL_VERSION,
      'tid' => $this->trackingId,
      'cid' => $cid,
      't'   => 'pageview',
      'dt'  => $title,
      'dl'  => $url,
      'ua'  => $this->_getUserAgent(),
      'dr'  => $this->_getReferer(),
      'uip' => $this->_getRemoteIP(),
      'av'  => '1.0' 
    );
  }

  protected function getEventData($category, $action, $label = null, $value = null)
  {
    $cid = $this->_ParseOrCreateAnalyticsCookie();

    $data = array(
      'v'   => self::PROTOCOL_VERSION,
      'tid' => $this->trackingId,
      'cid' => $cid,
      't'   => 'event',
      'ec'  => $category,
      'ea'  => $action,
      'el'  => $label,
      'ev'  => $value,
    );
    return $data;
  }

  protected function getErrorRequest($url, $title, $errorcode)
  {
    $data = $this->getHitData($url, $title);
    $data['t'] = 'exception';
    $data['exd'] = $errorcode;
    $data['exf'] = '1';

    return $data;
  }

  private function _ParseOrCreateAnalyticsCookie()
  {
    if (isset($_COOKIE['_ga'])) {
      list($version, $domainDepth, $cid1, $cid2) = preg_split('[\.]', $_COOKIE["_ga"], 4);
      $contents = array(
        'version' => $version,
        'domainDepth' => $domainDepth,
        'cid' => $cid1 . '.' . $cid2
      );
      $cid = $contents['cid'];
    } else {
      $cid1 = mt_rand(0, 2147483647);
      $cid2 = mt_rand(0, 2147483647);

      $cid = $cid1 . '.' . $cid2;
      setcookie('_ga', 'GA1.2' . $cid, time() + 60 * 60 * 24 * 365 * 2, '/');
    }
    return $cid;
  }
}