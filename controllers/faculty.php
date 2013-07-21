<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Public Controller Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni\Controllers
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Faculty extends Public_Controller {

    public function __construct() {
        parent::__construct();
        
        $this->load->model(array('faculties_m'));
    }

    public function index() {
        echo 'faculty index';
    }

    public function view($id = 0) {
        if (!$id or !$faculty = $this->faculties_m->get_by('id', $id)) {
            redirect('metrouni/faculty');
        }

        $this->_single_view($faculty);
    }

    private function _single_view($faculty, $build = 'faculty') {
        
        $this->template
                ->set('faculty', $faculty)
                ->build($build);
    }

}

/* End of file faculty.php */
/* Location: ./modules/metrouni/controllers/faculty.php */