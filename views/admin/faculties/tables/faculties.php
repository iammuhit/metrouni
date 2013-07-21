<?php if ($faculties) : ?>
    <table border="0" class="table-list">
        <thead>
            <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('metrouni:faculty_name_label'); ?></th>
                <th class="collapse"><?php echo lang('metrouni:faculty_phone_label'); ?></th>
                <th><?php echo lang('metrouni:faculty_email_label'); ?></th>
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
            <?php foreach ($faculties as $faculty) : ?>
                <tr>
                    <td><?php echo form_checkbox('action_to[]', $faculty->id); ?></td>
                    <td><?php echo $faculty->name; ?></td>
                    <td class="collapse"><?php echo $faculty->phone; ?></td>
                    <td><?php echo $faculty->email; ?></td>
                    <td>
                        <?php echo anchor('admin/metrouni/faculties/preview/' . $faculty->id, lang('global:preview'), 'class="btn green modal"'); ?>
                        <?php echo anchor('admin/metrouni/faculties/edit/' . $faculty->id, lang('global:edit'), 'class="btn orange edit"'); ?>
                        <?php echo anchor('admin/metrouni/faculties/delete/' . $faculty->id, lang('global:delete'), array('class' => 'confirm btn red delete')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no_data"><?php echo lang('metrouni:faculty_none'); ?></div>
<?php endif; ?>