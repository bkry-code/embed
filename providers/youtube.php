<?php

namespace Kirby\Plugins\distantnative\oEmbed\Providers;

class YouTube extends Provider {

  protected function init() {
    $this->getAll('t');
  }

  public function code($code) {
    $this->setAutoplay();
    $this->setTimecode();
    $this->setJsApi();
    return $code;
  }


  // ================================================
  //  Parameters for Panel Field Cheatsheet
  // ================================================

  public function providerParameters() {
    return [
      ['t', 'Timecode where the video should start (e.g. 1m4s)'],
    ];
  }


  // ================================================
  //  Autoplay
  // ================================================

  protected function setAutoplay() {
    if($this->option('lazyvideo') || $this->option('autoplay')) {
      $this->parameter(['rel=0', 'autoplay=1']);
    }
  }


  // ================================================
  //  Timecode
  // ================================================

  protected function setTimecode() {
    if($this->timecode !== false) {
      $this->parameter('start=' . $this->calculateTimecode());
    }
  }

  protected function calculateTimecode() {
    $time  = $this->disectTimecode('h') * 60 * 60;
    $time += $this->disectTimecode('m') * 60 ;
    $time += $this->disectTimecode('s');
    return $time;
  }

  protected function disectTimecode($identifier) {
    return preg_match('/([0-9]+)' . $identifier . '/i', $this->timecode, $match) ? $match[0] : 0;
  }


  // ================================================
  //  JS API
  // ================================================

  protected function setJsApi() {
    if($this->option('jsapi')) {
      $this->parameter('enablejsapi=1');
    }
  }

}
