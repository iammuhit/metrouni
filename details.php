<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Module Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Module_Metrouni extends Module {

    public $version = '1.0.0';
    public $language_file = 'metrouni/metrouni';

    public function __construct() {
        parent::__construct();

        $this->load->library('metrouni/metrouni');
    }

    public function information() {
        $info = array(
            'name' => array(
                'en' => 'Metrouni'
            ),
            'description' => array(
                'en' => 'The system capable of managing versity resources.'
            ),
            'frontend' => true,
            'backend' => true,
            'metrouni_core' => true,
            'menu' => 'Metrouni',
            'author' => 'Nurul Amin Muhit',
            'roles' => array('create_faculty', 'edit_faculty', 'delete_faculty'),
            'sections' => array(
                'dashboard' => array(
                    'name' => 'metrouni:sections:dashboard',
                    'uri' => 'admin/metrouni'
                ),
                'faculties' => array(
                    'name' => 'metrouni:sections:faculties',
                    'uri' => 'admin/metrouni/faculties',
                    'shortcuts' => array(
                        array(
                            'name' => 'metrouni:shortcuts:faculty_create',
                            'uri' => 'admin/metrouni/faculties/create',
                            'class' => 'add'
                        )
                    )
                ),
                'hours' => array(
                    'name' => 'metrouni:sections:hours',
                    'uri' => 'admin/metrouni/hours',
                    'shortcuts' => array(
                        array(
                            'name' => 'metrouni:shortcuts:hour_create',
                            'uri' => 'admin/metrouni/hours/create',
                            'class' => 'add'
                        )
                    )
                ),
                'persons' => array(
                    'name' => 'metrouni:sections:persons',
                    'uri' => 'admin/metrouni/persons',
                    'shortcuts' => array(
                        array(
                            'name' => 'metrouni:shortcuts:person_create',
                            'uri' => 'admin/metrouni/persons/create',
                            'class' => 'add'
                        )
                    )
                ),
                'semesters' => array(
                    'name' => 'metrouni:sections:semesters',
                    'uri' => 'admin/metrouni/semesters',
                    'shortcuts' => array(
                        array(
                            'name' => 'metrouni:shortcuts:semester_create',
                            'uri' => 'admin/metrouni/semesters/create',
                            'class' => 'add'
                        )
                    )
                )
            )
        );

        return $info;
    }

    public function info() {
        return $this->metrouni->info($this->information(), $this->language_file);
    }

    public function install() {

        // For 2.2 compatibility
        $redirect = (CMS_VERSION >= '2.2' ? 'addons/' : '') . 'modules';

        if (CMS_VERSION < "2.1.5") {
            $this->session->set_flashdata('error', lang('metrouni:install:wrong_version'));
            redirect('admin/' . $redirect);
            return FALSE;
        } elseif (!is_dir(SHARED_ADDONPATH . 'field_types/multiple') AND !is_dir(ADDONPATH . 'field_types/multiple') AND !is_dir(APPPATH . 'modules/streams_core/field_types/multiple')) {
            if (!$this->install_multiple()) {
                $this->session->set_flashdata('error', lang('metrouni:install:missing_multiple'));
                redirect('admin/' . $redirect);
                return FALSE;
            } else {
                // Redirect so Pyro recognises the field type is installed
                redirect('admin/' . $redirect . '/install/metrouni');
            }
        } elseif (!is_writable(APPPATH . 'config/routes.php')) {
            $this->session->set_flashdata('error', lang('metrouni:install:no_route_access'));
            redirect('admin/' . $redirect);
            return FALSE;
        }

        $this->dbforge->drop_table('metrouni_faculties');
        $this->dbforge->drop_table('metrouni_hours');
        $this->dbforge->drop_table('metrouni_semesters');
        $this->db->delete('settings', array('module' => 'metrouni'));

        $tables = array(
            'metrouni_faculties' => array(
                'id' => array('type' => 'smallint', 'constraint' => 8, 'null' => false, 'auto_increment' => true, 'primary' => true),
                'facultyno' => array('type' => 'varchar', 'constraint' => 10, 'null' => false),
                'name' => array('type' => 'varchar', 'constraint' => 50, 'null' => false),
                'comment' => array('type' => 'varchar', 'constraint' => 255, 'null' => true, 'default' => ''),
                'phone' => array('type' => 'varchar', 'constraint' => 25, 'null' => true, 'default' => ''),
                'fax' => array('type' => 'varchar', 'constraint' => 11, 'null' => true, 'default' => ''),
                'email' => array('type' => 'varchar', 'constraint' => 60, 'null' => true, 'default' => ''),
                'web' => array('type' => 'varchar', 'constraint' => 60, 'null' => true, 'default' => ''),
            ),
            'metrouni_hours' => array(
                'id' => array('type' => 'tinyint', 'constraint' => 3, 'null' => false, 'auto_increment' => true, 'primary' => true),
                'day' => array('type' => 'tinyint', 'constraint' => 3, 'null' => false, 'default' => '0'),
                'hour' => array('type' => 'tinyint', 'constraint' => 3, 'null' => false, 'default' => '0'),
                'beginhour' => array('type' => 'time', 'null' => true, 'null' => false, 'default' => '00:00:00'),
                'endhour' => array('type' => 'time', 'null' => true, 'null' => false, 'default' => '00:00:00'),
                'closed' => array('type' => 'enum', 'constraint' => array('y', 'n'), 'null' => true, 'default' => 'n'),
            ),
            'metrouni_semesters' => array(
                'id' => array('type' => 'smallint', 'constraint' => 5, 'null' => false, 'auto_increment' => true, 'primary' => true),
                'name' => array('type' => 'varchar', 'constraint' => 50, 'null' => false),
                'begindate' => array('type' => 'date', 'null' => false, 'default' => '0000-00-00'),
                'enddate' => array('type' => 'date', 'null' => false, 'default' => '0000-00-00'),
            ),
        );

        return $this->install_tables($tables);
    }

    public function uninstall() {
        $this->dbforge->drop_table('metrouni_faculties');
        $this->dbforge->drop_table('metrouni_hours');
        $this->dbforge->drop_table('metrouni_semesters');

        return true;
    }

    public function upgrade($old_version) {
        return true;
    }

    public function help() {
        return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
    }

    public function install_multiple() {

        // Load required items
        $this->load->library('unzip');

        // Variables
        $url = 'https://github.com/muhit18/PyroMultiRelationships/zipball/master';
        $path = SHARED_ADDONPATH . 'field_types/';
        $before = scandir($path);

        // Perform checks before continuing
        if (extension_loaded('zlib') AND
                function_exists('copy') AND
                function_exists('rename') AND
                function_exists('unlink') AND
                is_writable($path)) {

            // Download to temp folder
            $temp = tempnam(sys_get_temp_dir(), 'multiple');
            copy($url, $temp);

            // Unzip
            $this->unzip->extract($temp, $path);

            // Rename folder
            $after = scandir($path);
            $new = array_diff($after, $before);
            $folder = current($new);
            rename($path . $folder, $path . 'multiple');

            // Remove temp file
            @unlink($temp);

            // Check it all went well
            if (is_dir($path . 'multiple')) {
                return TRUE;
            }
        }

        // Something went wrong
        return FALSE;
    }

}

/* End of file details.php */
/* Location: ./modules/metrouni/details.php */