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

    public function info() {
        return array(
            'name' => array(
                'en' => 'Metrouni'
            ),
            'description' => array(
                'en' => 'The system capable of managing versity resources.'
            ),
            'frontend' => true,
            'backend' => true,
            'metrouni_core' => true,
            'author' => 'Nurul Amin Muhit',
            'skip_xss' => true,
            'menu' => 'Metrouni',
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
            ),
            'elements' => array(
                'dashboard' => array(
                    array()
                )
            )
        );
    }

    public function install() {
        $this->dbforge->drop_table('metrouni_faculties');
        $this->dbforge->drop_table('metrouni_hours');
        $this->dbforge->drop_table('metrouni_semesters');

        $tables = array(
            'metrouni_faculties' => array(
                'id' => array('type' => 'smallint', 'constraint' => 8, 'null' => false, 'auto_increment' => true, 'key' => true),
                'facultyno' => array('type' => 'varchar', 'constraint' => 10, 'null' => false),
                'name' => array('type' => 'varchar', 'constraint' => 50, 'null' => false),
                'comment' => array('type' => 'varchar', 'constraint' => 255, 'null' => true, 'default' => ''),
                'phone' => array('type' => 'varchar', 'constraint' => 25, 'null' => true, 'default' => ''),
                'fax' => array('type' => 'varchar', 'constraint' => 11, 'null' => true, 'default' => ''),
                'email' => array('type' => 'varchar', 'constraint' => 60, 'null' => true, 'default' => ''),
                'web' => array('type' => 'varchar', 'constraint' => 60, 'null' => true, 'default' => ''),
            ),
            'metrouni_hours' => array(
                'id' => array('type' => 'tinyint', 'constraint' => 3, 'null' => false, 'auto_increment' => true, 'key' => true),
                'day' => array('type' => 'tinyint', 'constraint' => 3, 'null' => false, 'default' => '0'),
                'hour' => array('type' => 'tinyint', 'constraint' => 3, 'null' => false, 'default' => '0'),
                'beginhour' => array('type' => 'time', 'null' => true, 'null' => false, 'default' => '00:00:00'),
                'endhour' => array('type' => 'time', 'null' => true, 'null' => false, 'default' => '00:00:00'),
                'closed' => array('type' => 'enum', 'constraint' => array('y', 'n'), 'null' => true, 'default' => 'n'),
            ),
            'metrouni_semesters' => array(
                'id' => array('type' => 'smallint', 'constraint' => 5, 'null' => false, 'auto_increment' => true, 'key' => true),
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

}

/* End of file details.php */
/* Location: ./modules/metrouni/details.php */