<?php if ( !empty($hours)) : ?>
    <table border="0" class="table-list">
        <thead>
            <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('metrouni:hour_lecture_label'); ?></th>
                <th class="collapse"><?php echo lang('metrouni:hour_day_label'); ?></th>
                <th class="collapse"><?php echo lang('metrouni:hour_beginhour_label'); ?></th>
                <th class="collapse"><?php echo lang('metrouni:hour_endhour_label'); ?></th>
                <th><?php echo lang('metrouni:hour_closed_label'); ?></th>
                <th width="180"></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="7">
                    <div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php foreach ($hours as $hour) : ?>
                <tr>
                    <td><?php echo form_checkbox('action_to[]', $hour->id); ?></td>
                    <td><?php echo $hour->hour; ?></td>
                    <td class="collapse"><?php echo $hour->day; ?></td>
                    <td class="collapse"><?php echo $hour->beginhour; ?></td>
                    <td class="collapse"><?php echo $hour->endhour; ?></td>
                    <td><?php echo $hour->closed; ?></td>
                    <td>
                        <?php echo anchor('admin/metrouni/hours/preview/' . $hour->id, lang('global:preview'), 'class="btn green modal"'); ?>
                        <?php echo anchor('admin/metrouni/hours/edit/' . $hour->id, lang('global:edit'), 'class="btn orange edit"'); ?>
                        <?php echo anchor('admin/metrouni/hours/delete/' . $hour->id, lang('global:delete'), array('class' => 'confirm btn red delete')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no_data"><?php echo lang('metrouni:hour_none'); ?></div>
<?php endif; ?>