<?php if ( !empty($departments)) : ?>
    <table border="0" class="table-list">
        <thead>
            <tr>
                <th width="20"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')); ?></th>
                <th><?php echo lang('metrouni:department_name_label'); ?></th>
                <th class="collapse"><?php echo lang('metrouni:department_phone_label'); ?></th>
                <th><?php echo lang('metrouni:department_email_label'); ?></th>
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
            <?php foreach ($departments as $department) : ?>
                <tr>
                    <td><?php echo form_checkbox('action_to[]', $department->id); ?></td>
                    <td><?php echo $department->name; ?></td>
                    <td class="collapse"><?php echo $department->phone; ?></td>
                    <td><?php echo $department->email; ?></td>
                    <td>
                        <?php echo anchor('admin/metrouni_departments/preview/' . $department->id, lang('global:preview'), 'class="btn green modal"'); ?>
                        <?php echo anchor('admin/metrouni_departments/edit/' . $department->id, lang('global:edit'), 'class="btn orange edit"'); ?>
                        <?php echo anchor('admin/metrouni_departments/delete/' . $department->id, lang('global:delete'), array('class' => 'confirm btn red delete')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no_data"><?php echo lang('metrouni:department_none'); ?></div>
<?php endif; ?>