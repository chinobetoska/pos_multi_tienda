<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller
 *
 * Base controller extending CI_Controller.
 * Provides PHP 8.2+ compatibility shims and common functionality
 * for all application controllers.
 *
 * @package    POS Multi-Tienda
 */
class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

}
