<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Faculty Model Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni\Models
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Faculties_m extends MY_Model {

    protected $_table = 'metrouni_faculties';

    public function __construct() {
        parent::__construct();
    }

    public function get_all() {
        $this->db
                ->select('*')
                ->order_by('id', 'DESC');

        return $this->db->get($this->_table)->result();
    }

    public function get($id) {
        $this->db
                ->select('*')
                ->where('id', $id);

        return $this->db->get($this->_table)->row();
    }

    public function get_by($key, $value = '') {

        if (is_array($key)) {
            $this->db->where($key);
        } else {
            $this->db->where($key, $value);
        }

        return $this->db->get($this->_table)->row();
    }

    public function get_many_by($params = array()) {

        return $this->get_all();
    }

    public function update($id, $input) {
        return parent::update($id, $input);
    }

}

/* End of file faculties_m.php */
/* Location: ./modules/metrouni/models/faculties_m.php */