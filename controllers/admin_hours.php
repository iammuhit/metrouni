<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Metrouni Hour Controller Class
 * 
 * @package     PyroCMS\Addon\Modules\Metrouni\Controllers
 * @subpackage  Metrouni Module
 * @author      The Primitive Solution
 * @website     http://primitivesolution.com
 */
class Admin_Hours extends Admin_Controller {

    protected $section = 'hours';
    private $validation_rules = array(
        'day' => array(
            'field' => 'day',
            'label' => 'lang:metrouni:hour_day_label',
            'rules' => 'trim'
        ),
        'hour' => array(
            'field' => 'hour',
            'label' => 'lang:metrouni:hour_lecture_label',
            'rules' => 'trim|required'
        ),
        'beginhour' => array(
            'field' => 'beginhour',
            'label' => 'lang:metrouni:hour_beginhour_label',
            'rules' => 'trim|required'
        ),
        'endhour' => array(
            'field' => 'endhour',
            'label' => 'lang:metrouni:hour_endhour_label',
            'rules' => 'trim'
        ),
        'closed' => array(
            'field' => 'closed',
            'label' => 'lang:metrouni:hour_closed_label',
            'rules' => 'trim'
        )
    );

    public function __construct() {
        parent::__construct();

        $this->lang->load(array('metrouni'));
        $this->load->model(array('hours_m'));
        $this->load->library(array('form_validation'));

        $this->template
                ->append_css('module::admin.css')
                ->append_js('module::admin.js');
    }

    public function index() {
        $total_rows = $this->hours_m->count_all();
        $pagination = create_pagination('admin/metrouni/hours/index', $total_rows, null, 5);

        $faculties = $this->hours_m->limit($pagination['limit'])->get_all();

        $this->input->is_ajax_request() and $this->template->set_layout(FALSE);

        $this->template
                ->title($this->module_details['name'])
                ->set('pagination', $pagination)
                ->set('hours', $faculties)
                ->set_partial('filters', 'admin/hours/partials/filters')
                ->append_js('admin/filter.js');

        $this->input->is_ajax_request() ? $this->template->build('admin/hours/tables/hours') : $this->template->build('admin/hours/index');
    }

    public function create() {
        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $form_data = array(
                'day' => $this->input->post('day'),
                'hour' => $this->input->post('hour'),
                'beginhour' => $this->input->post('beginhour'),
                'endhour' => $this->input->post('endhour'),
                'closed' => ($this->input->post('closed') == 'y') ? 'y' : 'n'
            );

            if ($id = $this->hours_m->insert($form_data)) {
                $this->pyrocache->delete_all('hours_m');
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:hour_add_success'), $this->input->post('hour')));
            } else {
                $this->session->set_flashdata('error', lang('metrouni:hour_add_error'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/metrouni/hours') : redirect('admin/metrouni/hours/edit/' . $id);
        } else {
            $hour = new stdClass;
            foreach ($this->validation_rules as $key => $field) {
                $hour->$field['field'] = set_value($field['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], lang('metrouni:hour_create_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', null, true))
                ->set('hour', $hour)
                ->build('admin/hours/form');
    }

    public function edit($id = 0) {
        $id OR redirect('admin/metrouni/hours');

        $hour = $this->hours_m->get($id);

        $this->form_validation->set_rules($this->validation_rules);

        if ($this->form_validation->run()) {

            $form_data = array(
                'day' => $this->input->post('day'),
                'hour' => $this->input->post('hour'),
                'beginhour' => $this->input->post('beginhour'),
                'endhour' => $this->input->post('endhour'),
                'closed' => ($this->input->post('closed') == 'y') ? 'y' : 'n'
            );

            if ($this->hours_m->update($id, $form_data)) {
                $this->session->set_flashdata(array('success' => sprintf(lang('metrouni:hour_edit_success'), $this->input->post('hour'))));
            } else {
                $this->session->set_flashdata('error', lang('metrouni:hour_edit_error'));
            }

            $this->input->post('btnAction') == 'save_exit' ? redirect('admin/metrouni/hours') : redirect('admin/metrouni/hours/edit/' . $id);
        }

        foreach ($this->validation_rules as $key => $field) {
            if (isset($_POST[$field['field']])) {
                $hour->$field['field'] = set_value($field['field']);
            }
        }

        $this->template
                ->title($this->module_details['name'], lang('metrouni:hour_edit_title'))
                ->append_metadata($this->load->view('fragments/wysiwyg', null, true))
                ->set('hour', $hour)
                ->build('admin/hours/form');
    }

    public function preview($id = 0) {
        $hour = $this->hours_m->get($id);

        $this->template
                ->set_layout('modal', 'admin')
                ->set('hour', $hour)
                ->build('admin/hours/preview');
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
            $hour_names = array();
            $deleted_ids = array();

            foreach ($ids as $id) {
                if ($hour = $this->hours_m->get($id)) {
                    if ($this->hours_m->delete($id)) {
                        $this->pyrocache->delete('hours_m');
                        $hour_names[] = $hour->hour;
                        $deleted_ids[] = $hour->id;
                    }
                }
            }

            Events::trigger('hour_deleted', $deleted_ids);
        }

        if (!empty($hour_names)) {
            if (count($hour_names) == 1) {
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:hour_delete_success'), $hour_names[0]));
            } else {
                $this->session->set_flashdata('success', sprintf($this->lang->line('metrouni:hour_mass_delete_success'), implode('", "', $hour_names)));
            }
        } else {
            $this->session->set_flashdata('notice', lang('metrouni:hour_delete_error'));
        }

        redirect('admin/metrouni/hours');
    }

}

/* End of file admin_hours.php */
/* Location: ./modules/metrouni/controllers/admin_hours.php */