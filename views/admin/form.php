<section class="title">
    <?php if ($this->method == 'create'): ?>
        <h4><?php echo lang('metrouni:department_create_title'); ?></h4>
    <?php else: ?>
        <h4><?php echo sprintf(lang('metrouni:department_edit_title'), $department->name); ?></h4>
    <?php endif; ?>
</section>

<section class="item">

    <?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>

    <div class="form_inputs">

        <ul>
            <li class="<?php echo alternator('', 'even'); ?>">
                <label for="facultyid"><?php echo lang('metrouni:department_facultyid_label'); ?></label>
                <div class="input"><?php echo form_dropdown('facultyid', $faculties, $department->facultyid); ?></div>
            </li>
            
            <li class="<?php echo alternator('', 'even'); ?>">
                <label for="departmentno"><?php echo lang('metrouni:department_departmentno_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('departmentno', $department->departmentno, 'id="departmentno"'); ?></div>
            </li>

            <li class="<?php echo alternator('', 'even'); ?>">
                <label for="name"><?php echo lang('metrouni:department_name_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('name', $department->name, 'id="name"'); ?></div>				
            </li>

            <li class="<?php echo alternator('', 'even'); ?>">
                <label for="comment"><?php echo lang('metrouni:department_comment_label'); ?></label>
                <br style="clear: both;" />
                <?php echo form_textarea(array('id' => 'comment', 'name' => 'comment', 'value' => $department->comment, 'rows' => 5, 'class' => 'department wysiwyg-simple')); ?>
            </li>

            <li class="<?php echo alternator('', 'even'); ?>">
                <label for="phone"><?php echo lang('metrouni:department_phone_label'); ?></label>
                <div class="input"><?php echo form_input('phone', $department->phone, 'id="phone"'); ?></div>				
            </li>

            <li class="<?php echo alternator('', 'even'); ?>">
                <label for="fax"><?php echo lang('metrouni:department_fax_label'); ?></label>
                <div class="input"><?php echo form_input('fax', $department->fax, 'id="fax"'); ?></div>				
            </li>

            <li class="<?php echo alternator('', 'even'); ?>">
                <label for="email"><?php echo lang('metrouni:department_email_label'); ?></label>
                <div class="input"><?php echo form_input('email', $department->email, 'id="email"'); ?></div>				
            </li>

            <li class="<?php echo alternator('', 'even'); ?>">
                <label for="web"><?php echo lang('metrouni:department_phone_label'); ?></label>
                <div class="input"><?php echo form_input('web', $department->web, 'id="web"'); ?></div>				
            </li>
        </ul>

    </div>

    <div class="buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
    </div>

    <?php echo form_close(); ?>

</section>