<section class="title">
    <h4><?php echo lang('metrouni:department_title'); ?></h4>
</section>

<section class="item">

    <?php template_partial('filters'); ?>

    <?php echo form_open('admin/metrouni_departments/action'); ?>

    <div id="filter-stage">
        <?php template_partial('tables/departments'); ?>
    </div>

    <div class="table_action_buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
    </div>

    <?php echo form_close(); ?>

</section>
