<section class="title">
    <?php if ($this->method == 'create'): ?>
        <h4><?php echo lang('metrouni:hour_create_title'); ?></h4>
    <?php else: ?>
        <h4><?php echo sprintf(lang('metrouni:hour_edit_title'), $hour->hour); ?></h4>
    <?php endif; ?>
</section>

<section class="item">

    <?php echo form_open_multipart(); ?>

    <div class="form_inputs">

        <ul>
            <li>
                <label for="day"><?php echo lang('metrouni:hour_day_label'); ?></label>
                <div class="input">
                    <?php
                    $days = array(
                        '1' => 'Monday',
                        '2' => 'Tuesday',
                        '3' => 'Wednesday',
                        '4' => 'Thusday',
                        '5' => 'Friday',
                        '6' => 'Saterday',
                        '7' => 'Sunday',
                    );
                    echo form_dropdown('day', $days, $hour->day);
                    ?>
                </div>
            </li>
            <li>
                <label for="hour"><?php echo lang('metrouni:hour_lecture_label'); ?></label>
                <div class="input">
                    <?php
                    $lectures = array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                    );
                    echo form_dropdown('hour', $lectures, $hour->hour);
                    ?>
                </div>
            </li>
            <li>
                <label for="beginhour"><?php echo lang('metrouni:hour_beginhour_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('beginhour', $hour->beginhour); ?></div>
            </li>
            <li>
                <label for="endhour"><?php echo lang('metrouni:hour_endhour_label'); ?> <span>*</span></label>
                <div class="input"><?php echo form_input('endhour', $hour->endhour); ?></div>
            </li>
            <li>
                <label for="closed"><?php echo lang('metrouni:hour_closed_label'); ?></label>
                <div class="input"><?php echo form_checkbox('closed', 'y', $hour->closed == 'y', 'id="closed"'); ?></div>
            </li>
        </ul>

    </div>

    <div class="buttons">
        <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))); ?>
    </div>

    <?php echo form_close(); ?>

</section>
