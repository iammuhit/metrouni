<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Semester Controller Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni\Controllers
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Admin_Semesters extends Admin_Controller {

    protected $section = 'semesters';
    private $validation_rules = array(
        'name' => array(
            'field' => 'name',
            'label' => 'lang:metrouni:semester_name_label',
            'rules' => 'trim|required'
        ),
        'begindate' => array(
            'field' => 'begindate',
            'label' => 'lang:metrouni:semester_begindate_label',
            'rules' => 'trim|required'
        ),
        'enddate' => array(
            'field' => 'enddate',
            'label' => 'lang:metrouni:semester_enddate_label',
            'rules' => 'trim|required'
        )
    );

    public function __construct() {
        parent::__construct();

        $this->lang->load(array('metrouni'));
        $this->load->model(array('semesters_m'));
        $this->load->library(array('form_validation'));

        $this->template
                ->append_css('module::admin.css')
                ->append_js('module::admin.js');
    }

    public function index() {
        $total_rows = $this->semesters_m->count_all();
        $pagination = create_pagination('admin/metrouni/semesters/index', $total_rows, null, 5);

        $faculties = $this->semesters_m->limit($pagination['limit'])->get_all();

        $this->input->is_ajax_request() and $this->template->set_layout(FALSE);

        $this->template
                ->title($this->module_details['name'])
                ->set('pagination', $pagination)
                ->set('semesters', $faculties)
                ->set_partial('filters', 'admin/semesters/partials/filters')
                ->append_js('admin/filter.js');

        $this->input->is_ajax_request() ? $this->template->build('admin/semesters/tables/semesters') : $this->template->build('admin/semesters/index');
    }

    public function create() {
        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $form_data = array(
                'name' => $this->input->post('name'),
                'begindate' => $this->input->post('begindate'),
                'enddate' => $this->input->post('enddate')
            );

            if ($id = $this->semesters_m->insert($form_data)) {
                $this->pyrocache->delete_all('semesters_m');
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:semester_add_success'), $this->input->post('name')));
            } else {
                $this->session->set_flashdata('error', lang('metrouni:semester_add_error'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/metrouni/semesters') : redirect('admin/metrouni/semesters/edit/' . $id);
        } else {
            $semester = new stdClass;
            foreach ($this->validation_rules as $key => $field) {
                $semester->$field['field'] = set_value($field['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], lang('metrouni:semester_create_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', null, true))
                ->set('semester', $semester)
                ->build('admin/semesters/form');
    }

    public function edit($id = 0) {
        $id OR redirect('admin/metrouni/semesters');

        $semester = $this->semesters_m->get($id);

        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $form_data = array(
                'name' => $this->input->post('name'),
                'begindate' => $this->input->post('begindate'),
                'enddate' => $this->input->post('enddate')
            );

            if ($this->semesters_m->update($id, $form_data)) {
                $this->session->set_flashdata(array('success' => sprintf(lang('metrouni:semester_edit_success'), $this->input->post('name'))));
            } else {
                $this->session->set_flashdata('error', lang('metrouni:semester_edit_error'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/metrouni/hours') : redirect('admin/metrouni/semesters/edit/' . $id);
        }

        foreach ($this->validation_rules as $key => $field) {
            if (isset($_POST[$field['field']])) {
                $semester->$field['field'] = set_value($field['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], lang('metrouni:semester_edit_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', null, true))
                ->set('semester', $semester)
                ->build('admin/semesters/form');
    }

    public function preview($id = 0) {
        $semester = $this->semesters_m->get($id);

        $this->template
                ->set_layout('modal', 'admin')
                ->set('semester', $semester)
                ->build('admin/semesters/preview');
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
            $semester_names = array();
            $deleted_ids = array();

            foreach ($ids as $id) {
                if ($hour = $this->semesters_m->get($id)) {
                    if ($this->semesters_m->delete($id)) {
                        $this->pyrocache->delete('semesters_m');
                        $semester_names[] = $semester->name;
                        $deleted_ids[] = $semester->id;
                    }
                }
            }

            Events::trigger('semester_deleted', $deleted_ids);
        }

        if (!empty($semester_names)) {
            if (count($semester_names) == 1) {
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:semester_delete_success'), $semester_names[0]));
            } else {
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:semester_mass_delete_success'), implode('", "', $semester_names)));
            }
        } else {
            $this->session->set_flashdata('notice', lang('metrouni:semester_delete_error'));
        }

        redirect('admin/metrouni/semesters');
    }

}

/* End of file admin_semesters.php */
/* Location: ./modules/metrouni/controllers/admin_semesters.php */