<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Admin Controller Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni\Controllers
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Admin extends Admin_Controller {

    protected $section = 'dashboard';

    public function __construct() {
        parent::__construct();

        $this->lang->load('metrouni');

        $this->template
                ->append_css('module::admin.css')
                ->append_js('module::admin.js');
    }

    public function index() {
        $this->template
                ->title($this->module_details['name'])
                ->build('admin/index');
    }

}

/* End of file admin.php */
/* Location: ./modules/metrouni/controllers/admin.php */