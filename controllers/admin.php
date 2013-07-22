<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Admin Controller Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni_Departments\Controllers
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Admin extends Admin_Controller {

    protected $section = 'departments';

    public function __construct() {
        parent::__construct();

        // Load all the required classes
        $this->load->model('departments_m');
        $this->load->model('metrouni/faculties_m');
        $this->load->library('form_validation');
        $this->lang->load('metrouni');

        // Set the validation rules
        $this->validation_rules = array(
            array(
                'field' => 'departmentno',
                'label' => 'lang:metrouni:department_departmentno_label',
                'rules' => 'trim|max_length[10]|required'
            ),
            array(
                'field' => 'facultyid',
                'label' => 'lang:metrouni:department_facultyid_label',
                'rules' => 'trim|max_length[5]'
            ),
            array(
                'field' => 'name',
                'label' => 'lang:metrouni:department_name_label',
                'rules' => 'trim|max_length[50]|required'
            ),
            array(
                'field' => 'comment',
                'label' => 'lang:metrouni:department_comment_label',
                'rules' => 'trim|max_length[255]'
            ),
            array(
                'field' => 'phone',
                'label' => 'lang:metrouni:department_phone_label',
                'rules' => 'trim|max_length[25]'
            ),
            array(
                'field' => 'fax',
                'label' => 'lang:metrouni:department_fax_label',
                'rules' => 'trim|max_length[25]'
            ),
            array(
                'field' => 'email',
                'label' => 'lang:metrouni:department_email_label',
                'rules' => 'trim|max_length[60]'
            ),
            array(
                'field' => 'web',
                'label' => 'lang:metrouni:department_web_label',
                'rules' => 'trim|max_length[60]'
            )
        );

        // We'll set the partials and metadata here since they're used everywhere
        $this->template
                ->append_js('module::admin.js')
                ->append_css('module::admin.css');
    }

    public function index() {
        $total_rows = $this->departments_m->count_all();
        $pagination = create_pagination('admin/metrouni_departments/index', $total_rows);

        $departments = $this->departments_m->limit($pagination['limit'])->get_all();

        $this->input->is_ajax_request() and $this->template->set_layout(false);

        $this->template
                ->title($this->module_details['name'])
                ->set('pagination', $pagination)
                ->set('departments', $departments)
                ->set_partial('filters', 'admin/partials/filters')
                ->append_js('admin/filter.js');

        $this->input->is_ajax_request() ? $this->template->build('admin/tables/departments') : $this->template->build('admin/index');
    }

    public function create() {
        $this->form_validation->set_rules($this->validation_rules);

        $faculties = array();
        foreach ($this->faculties_m->get_all() as $faculty) {
            $faculties[$faculty->id] = $faculty->name;
        }

        if ($this->form_validation->run()) {

            $form_data = array(
                'departmentno' => $this->input->post('departmentno'),
                'facultyid' => $this->input->post('facultyid'),
                'name' => $this->input->post('name'),
                'comment' => $this->input->post('comment'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'web' => $this->input->post('web')
            );

            if ($id = $this->departments_m->insert($form_data)) {
                $this->pyrocache->delete_all('departments_m');
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:department_add_success'), $this->input->post('name')));
            } else {
                $this->session->set_flashdata('error', lang('metrouni:department_add_error'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/metrouni_departments') : redirect('admin/metrouni_departments/edit/' . $id);
        } else {
            $department = new stdClass;
            foreach ($this->validation_rules as $key => $field) {
                $department->$field['field'] = set_value($field['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], lang('metrouni:department_create_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', null, true))
                ->set('department', $department)
                ->set('faculties', $faculties)
                ->build('admin/form');
    }

    public function edit($id = 0) {
        $id OR redirect('admin/metrouni_departments');

        $department = $this->departments_m->get($id);
        $faculties = array();
        foreach ($this->faculties_m->get_all() as $faculty) {
            $faculties[$faculty->id] = $faculty->name;
        }

        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $form_data = array(
                'departmentno' => $this->input->post('departmentno'),
                'facultyid' => $this->input->post('facultyid'),
                'name' => $this->input->post('name'),
                'comment' => $this->input->post('comment'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'web' => $this->input->post('web')
            );

            if ($this->departments_m->update($id, $form_data)) {
                $this->session->set_flashdata(array('success' => sprintf(lang('metrouni:department_edit_success'), $this->input->post('name'))));
            } else {
                $this->session->set_flashdata('error', lang('metrouni:department_edit_error'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/metrouni_departments') : redirect('admin/metrouni_departments/edit/' . $id);
        }

        foreach ($this->validation_rules as $key => $field) {
            if (isset($_POST[$field['field']])) {
                $department->$field['field'] = set_value($field['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], lang('metrouni:department_edit_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', null, true))
                ->set('department', $department)
                ->set('faculties', $faculties)
                ->build('admin/form');
    }

    public function action() {
        switch ($this->input->post('btnAction')) {
            case 'publish':
                $this->publish();
                break;
            case 'delete':
                $this->delete();
        }
    }

    public function publish($id = 0) {
        
    }

    public function delete($id = 0) {
        if (isset($_POST['btnAction']) AND is_array($_POST['action_to'])) {
            $this->departments_m->delete_many($this->input->post('action_to'));
        } elseif (is_numeric($id)) {
            $this->departments_m->delete($id);
        }
        redirect('admin/metrouni_departments');
    }

}

/* End of file admin.php */
/* Location: ./modules/metrouni_departments/controllers/admin.php */