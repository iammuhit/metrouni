<?php if ( !empty($semesters)) : ?>
    <table border="0" class="table-list">
        <thead>
            <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('metrouni:semester_name_label'); ?></th>
                <th class="collapse"><?php echo lang('metrouni:semester_begindate_label'); ?></th>
                <th><?php echo lang('metrouni:semester_enddate_label'); ?></th>
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
            <?php foreach ($semesters as $semester) : ?>
                <tr>
                    <td><?php echo form_checkbox('action_to[]', $semester->id); ?></td>
                    <td><?php echo $semester->name; ?></td>
                    <td class="collapse"><?php echo $semester->begindate; ?></td>
                    <td><?php echo $semester->enddate; ?></td>
                    <td>
                        <?php echo anchor('admin/metrouni/semesters/preview/' . $semester->id, lang('global:preview'), 'class="btn green modal"'); ?>
                        <?php echo anchor('admin/metrouni/semesters/edit/' . $semester->id, lang('global:edit'), 'class="btn orange edit"'); ?>
                        <?php echo anchor('admin/metrouni/semesters/delete/' . $semester->id, lang('global:delete'), array('class' => 'confirm btn red delete')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no_data"><?php echo lang('metrouni:semester_none'); ?></div>
<?php endif; ?>