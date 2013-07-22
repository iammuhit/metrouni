<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Plugin Class
 *
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 * @package     PyroCMS\Addon\Modules\Metrouni
 * @subpackage  Metrouni Module
 */
class Plugin_Metrouni extends Plugin {

    public function module_installed() {

        $module = $this->attribute('slug', 'metrouni');

        $query = $this->db->select('id')->where('slug', $module)->where('installed', '1')->get('modules');

        if ($query->num_rows()) {
            return true;
        }

        return false;
    }

}

/* End of file plugin.php */
/* Location: ./modules/metrouni/plugin.php */