<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Metrouni Module Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni_Departments
 * @subpackage  Metrouni_Departments Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Module_Metrouni_Departments extends Module {

    public $version = '1.0.0';
    public $language_file = 'metrouni_departments/metrouni';

    public function __construct() {
        parent::__construct();

        $this->load->library('metrouni/metrouni');
    }

    public function information() {
        return array(
            'name' => array(
                'en' => 'Metrouni Departments'
            ),
            'description' => array(
                'en' => 'Metrouni Department Management.'
            ),
            'frontend' => true,
            'backend' => false,
            'metrouni_core' => false,
            'menu' => 'Metrouni',
            'author' => 'Nurul Amin Muhit',
            'sections' => array(
                'departments' => array(
                    'name' => 'metrouni:sections:departments',
                    'uri' => 'admin/metrouni_departments',
                    'shortcuts' => array(
                        array(
                            'name' => 'metrouni:shortcuts:department_create',
                            'uri' => 'admin/metrouni_departments/create',
                            'class' => 'add'
                        )
                    )
                )
            )
        );
    }

    public function info() {
        return $this->metrouni->info($this->information(), $this->language_file);
    }

    public function install() {
        if ($this->metrouni->is_installed()) {
            $this->dbforge->drop_table('metrouni_departments');

            $metrouni_departments = array(
                'id' => array('type' => 'smallint', 'constraint' => '5', 'null' => false, 'auto_increment' => true),
                'departmentno' => array('type' => 'varchar', 'constraint' => '10', 'null' => true),
                'facultyid' => array('type' => 'smallint', 'constraint' => '5', 'null' => false, 'default' => '0'),
                'name' => array('type' => 'varchar', 'constraint' => '50', 'null' => false),
                'comment' => array('type' => 'varchar', 'constraint' => '255', 'null' => true, 'default' => ''),
                'phone' => array('type' => 'varchar', 'constraint' => '25', 'null' => true, 'default' => ''),
                'fax' => array('type' => 'varchar', 'constraint' => '25', 'null' => true, 'default' => ''),
                'email' => array('type' => 'varchar', 'constraint' => '60', 'null' => true, 'default' => ''),
                'web' => array('type' => 'varchar', 'constraint' => '60', 'null' => true, 'default' => '')
            );

            $this->dbforge->add_field($metrouni_departments);
            $this->dbforge->add_key('id', true);

            if ($this->dbforge->create_table('metrouni_departments') AND
                    is_dir($this->upload_path . 'metrouni_departments') OR @mkdir($this->upload_path . 'metrouni_departments', 0777, true)) {
                return true;
            }
        }
        
        return false;
    }

    public function uninstall() {
        $this->dbforge->drop_table('metrouni_departments');

        return true;
    }

    public function upgrade($old_version) {
        return true;
    }

    public function help() {
        return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

}

/* End of file details.php */
/* Location: ./modules/metrouni_departments/details.php */
