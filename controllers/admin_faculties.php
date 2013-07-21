<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Faculty Controller Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni\Controllers
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Admin_Faculties extends Admin_Controller {

    protected $section = 'faculties';
    private $validation_rules = array(
        'facultyno' => array(
            'field' => 'facultyno',
            'label' => 'lang:metrouni:faculty_facultyno_label',
            'rules' => 'trim|htmlspecialchars|required'
        ),
        'name' => array(
            'field' => 'name',
            'label' => 'lang:metrouni:faculty_name_label',
            'rules' => 'trim|htmlspecialchars|required'
        ),
        'comment' => array(
            'field' => 'comment',
            'label' => 'lang:metrouni:faculty_comment_label',
            'rules' => 'trim'
        ),
        'phone' => array(
            'field' => 'phone',
            'label' => 'lang:metrouni:faculty_phone_label',
            'rules' => 'trim'
        ),
        'fax' => array(
            'field' => 'fax',
            'label' => 'lang:metrouni:faculty_fax_label',
            'rules' => 'trim'
        ),
        'email' => array(
            'field' => 'email',
            'label' => 'lang:metrouni:faculty_email_label',
            'rules' => 'trim|valid_email'
        ),
        'web' => array(
            'field' => 'web',
            'label' => 'lang:metrouni:faculty_web_label',
            'rules' => 'trim'
        )
    );

    public function __construct() {
        parent::__construct();

        $this->lang->load('metrouni');
        $this->load->model(array('faculties_m'));
        $this->load->library(array('form_validation'));

        $this->template
                ->append_css('module::admin.css')
                ->append_js('module::admin.js');
    }

    public function index() {
        $total_rows = $this->faculties_m->count_all();
        $pagination = create_pagination('admin/metrouni/faculties/index', $total_rows, null, 5);

        $faculties = $this->faculties_m->limit($pagination['limit'])->get_all();

        $this->input->is_ajax_request() and $this->template->set_layout(FALSE);

        $this->template
                ->title($this->module_details['name'])
                ->set('pagination', $pagination)
                ->set('faculties', $faculties)
                ->set_partial('filters', 'admin/faculties/partials/filters')
                ->append_js('admin/filter.js');

        $this->input->is_ajax_request() ? $this->template->build('admin/faculties/tables/faculties') : $this->template->build('admin/faculties/index');
    }

    public function create() {
        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $form_data = array(
                'facultyno' => $this->input->post('facultyno'),
                'name' => $this->input->post('name'),
                'comment' => $this->input->post('comment'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'web' => $this->input->post('web')
            );

            if ($id = $this->faculties_m->insert($form_data)) {
                $this->pyrocache->delete_all('faculties_m');
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:faculty_add_success'), $this->input->post('name')));
            } else {
                $this->session->set_flashdata('error', lang('metrouni:faculty_add_error'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/metrouni/faculties') : redirect('admin/metrouni/faculties/edit/' . $id);
        } else {
            $faculty = new stdClass;
            foreach ($this->validation_rules as $key => $field) {
                $faculty->$field['field'] = set_value($field['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], lang('metrouni:faculty_create_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', null, true))
                ->set('faculty', $faculty)
                ->build('admin/faculties/form');
    }

    public function edit($id = 0) {
        $id OR redirect('admin/metrouni/faculties');

        $faculty = $this->faculties_m->get($id);

        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $form_data = array(
                'facultyno' => $this->input->post('facultyno'),
                'name' => $this->input->post('name'),
                'comment' => $this->input->post('comment'),
                'phone' => $this->input->post('phone'),
                'fax' => $this->input->post('fax'),
                'email' => $this->input->post('email'),
                'web' => $this->input->post('web')
            );

            if ($this->faculties_m->update($id, $form_data)) {
                $this->session->set_flashdata(array('success' => sprintf(lang('metrouni:faculty_edit_success'), $this->input->post('name'))));
            } else {
                $this->session->set_flashdata('error', lang('metrouni:faculty_edit_error'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/metrouni/faculties') : redirect('admin/metrouni/faculties/edit/' . $id);
        }

        foreach ($this->validation_rules as $key => $field) {
            if (isset($_POST[$field['field']])) {
                $faculty->$field['field'] = set_value($field['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], lang('metrouni:faculty_edit_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', null, true))
                ->set('faculty', $faculty)
                ->build('admin/faculties/form');
    }

    public function preview($id = 0) {
        $faculty = $this->faculties_m->get($id);

        $this->template
                ->set_layout('modal')
                ->set('faculty', $faculty)
                ->build('admin/faculties/preview');
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
        $ids = ($id) ? array($id) : $this->input->post('action_to');

        if (!empty($ids)) {
            $faculty_names = array();
            $deleted_ids = array();

            foreach ($ids as $id) {
                if ($faculty = $this->faculties_m->get($id)) {
                    if ($this->faculties_m->delete($id)) {
                        $this->pyrocache->delete('faculties_m');
                        $faculty_names[] = $faculty->name;
                        $deleted_ids[] = $faculty->id;
                    }
                }
            }

            Events::trigger('faculty_deleted', $deleted_ids);
        }

        if (!empty($faculty_names)) {
            if (count($faculty_names) == 1) {
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:faculty_delete_success'), $faculty_names[0]));
            } else {
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:faculty_mass_delete_success'), implode('", "', $faculty_names)));
            }
        } else {
            $this->session->set_flashdata('notice', lang('metrouni:faculty_delete_error'));
        }

        redirect('admin/metrouni/faculties');
    }

}

/* End of file admin_faculties.php */
/* Location: ./modules/metrouni/controllers/admin_faculties.php */