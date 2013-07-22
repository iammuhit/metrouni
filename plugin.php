<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Plugin Class
 *
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 * @package     PyroCMS\Addon\Modules\Metrouni_Departments
 * @subpackage  Metrouni Module
 */
class Plugin_Metrouni_Departments extends Plugin {

    /**
     * Department List
     * Usage:
     * 
     * {{ metrouni_departments:departments limit="5" order="asc" }}
     *      {{ id }} {{ name }} {{ slug }}
     * {{ /metrouni_departments:departments }}
     *
     * @return	array
     */
    function departments() {
        $limit = $this->attribute('limit');
        $order = $this->attribute('order');

        return $this->db->order_by('name', $order)
                        ->limit($limit)
                        ->get('metrouni_departments')
                        ->result_array();
    }

}

/* End of file plugin.php */
/* Location: ./modules/metrouni_departments/plugin.php */