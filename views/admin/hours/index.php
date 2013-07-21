<section class="title">
    <h4><?php echo lang('metrouni:hour_title'); ?></h4>
</section>

<section class="item">

    <?php template_partial('filters'); ?>

    <?php echo form_open('admin/metrouni/hours/action'); ?>

    <div id="filter-stage">
        <?php template_partial('tables/hours'); ?>
    </div>

    <div class="table_action_buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete', 'publish'))); ?>
    </div>

    <?php echo form_close(); ?>

</section>
