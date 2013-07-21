<section class="title">
    <?php if ($this->method == 'create'): ?>
        <h4><?php echo lang('metrouni:faculty_create_title'); ?></h4>
    <?php else: ?>
        <h4><?php echo sprintf(lang('metrouni:faculty_edit_title'), $faculty->name); ?></h4>
    <?php endif; ?>
</section>

<section class="item">

    <?php echo form_open_multipart(); ?>

    <div class="tabs">

        <ul class="tab-menu">
            <li><a href="#faculty-content-tab"><span><?php echo lang('metrouni:faculty_general_label'); ?></span></a></li>
            <li><a href="#faculty-options-tab"><span><?php echo lang('metrouni:faculty_contacts_label'); ?></span></a></li>
        </ul>

        <!-- Content tab -->
        <div class="form_inputs" id="faculty-content-tab">

            <fieldset>
                <ul>
                    <li>
                        <label for="facultyno"><?php echo lang('metrouni:faculty_facultyno_label'); ?> <span>*</span></label>
                        <div class="input"><?php echo form_input('facultyno', htmlspecialchars_decode($faculty->facultyno), 'maxlength="100" id="facultyno"'); ?></div>				
                    </li>

                    <li>
                        <label for="name"><?php echo lang('metrouni:faculty_name_label'); ?> <span>*</span></label>
                        <div class="input"><?php echo form_input('name', htmlspecialchars_decode($faculty->name), 'maxlength="100" id="name"'); ?></div>				
                    </li>

                    <li>
                        <label for="comment"><?php echo lang('metrouni:faculty_comment_label'); ?></label>
                        <br style="clear: both;" />
                        <?php echo form_textarea(array('id' => 'comment', 'name' => 'comment', 'value' => $faculty->comment, 'rows' => 5, 'class' => 'faculty wysiwyg-simple')); ?>
                    </li>
                </ul>
            </fieldset>

        </div>

        <!-- Options tab -->
        <div class="form_inputs" id="faculty-options-tab">

            <fieldset>
                <ul>
                    <li>
                        <label for="phone"><?php echo lang('metrouni:faculty_phone_label'); ?></label>
                        <div class="input"><?php echo form_input('phone', $faculty->phone, 'maxlength="100" id="phone"'); ?></div>				
                    </li>

                    <li>
                        <label for="fax"><?php echo lang('metrouni:faculty_fax_label'); ?></label>
                        <div class="input"><?php echo form_input('fax', $faculty->fax, 'maxlength="100" id="fax"'); ?></div>				
                    </li>

                    <li>
                        <label for="email"><?php echo lang('metrouni:faculty_email_label'); ?></label>
                        <div class="input"><?php echo form_input('email', $faculty->email, 'maxlength="100" id="email"'); ?></div>				
                    </li>

                    <li>
                        <label for="web"><?php echo lang('metrouni:faculty_web_label'); ?></label>
                        <div class="input"><?php echo form_input('web', $faculty->web, 'maxlength="100" id="web"'); ?></div>				
                    </li>
                </ul>
            </fieldset>

        </div>

    </div>

    <div class="buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
    </div>

    <?php echo form_close(); ?>

</section>
