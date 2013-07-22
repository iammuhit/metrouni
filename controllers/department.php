<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Public Controller Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni_Departments\Controllers
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Department extends Public_Controller {

    public function __construct() {
        parent::__construct();

        // Load the required classes
        $this->load->model('departments_m');
        $this->lang->load('metrouni');

        $this->template
                ->append_css('module::metrouni.css')
                ->append_js('module::metrouni.js');
    }

    public function index($offset = 0) {
        // set the pagination limit
        $limit = 5;

        $departments = $this->departments_m->limit($limit)
                ->offset($offset)
                ->get_all();

        // we'll do a quick check here so we can tell tags whether there is data or not
        $departments_exist = count($departments) > 0;

        // we're using the pagination helper to do the pagination for us. Params are: (module/method, total count, limit, uri segment)
        $pagination = create_pagination('department', $this->departments_m->count_all(), $limit, 2);

        $this->template
                ->title($this->module_details['name'], 'the rest of the page title')
                ->set('departments', $departments)
                ->set('departments_exist', $departments_exist)
                ->set('pagination', $pagination)
                ->build('index');
    }

}

/* End of file department.php */
/* Location: ./modules/metrouni_departments/controllers/department.php */