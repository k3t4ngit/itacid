<?php

/**
 * Description of itacid
 *
 * @author ketan.tiwari@appbinder.com
 */
class Itacid extends CI_Controller {

  public function index() {
    $this->load->view('index');
  }

  public function home() {
    $this->load->view('home');
  }

  public function animate() {
    $this->load->view('3d');
  }

  public function design() {
    $this->load->view('design');
  }

}

?>
