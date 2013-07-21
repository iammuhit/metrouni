<section class="title">
    <?php if ($this->method == 'create'): ?>
        <h4><?php echo lang('metrouni:semester_create_title'); ?></h4>
    <?php else: ?>
        <h4><?php echo sprintf(lang('metrouni:semester_edit_title'), $semester->name); ?></h4>
    <?php endif; ?>
</section>

<section class="item">

    <?php echo form_open_multipart(); ?>

    <div class="form_inputs">

        <ul>
            <li>
                <label for="name"><?php echo lang('metrouni:semester_name_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('name', $semester->name); ?></div>
            </li>
            <li>
                <label for="begindate"><?php echo lang('metrouni:semester_begindate_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('begindate', $semester->begindate); ?></div>
            </li>
            <li>
                <label for="enddate"><?php echo lang('metrouni:semester_enddate_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('enddate', $semester->enddate); ?></div>
            </li>
        </ul>

    </div>

    <div class="buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
    </div>

    <?php echo form_close(); ?>

</section>
