<h1><?php echo $faculty->facultyno . ' - ' . $faculty->name; ?></h1>

<p style="float:left; width: 40%;">
    <?php echo anchor('metrouni/faculty/view/' . $faculty->id, lang('global:view'), ' class="btn small green" target="_blank"'); ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
    <?php echo anchor('admin/metrouni/faculties/edit/' . $faculty->id, lang('global:edit'), ' class="btn small orange" target="_parent"'); ?>
</p>

<table>
    <tr>
        <td><?php echo lang('metrouni:faculty_phone_label'); ?></td>
        <td><?php echo $faculty->phone; ?></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:faculty_fax_label'); ?></td>
        <td><?php echo $faculty->fax; ?></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:faculty_email_label'); ?></td>
        <td><?php echo $faculty->email; ?></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:faculty_web_label'); ?></td>
        <td><a href="<?php echo $faculty->web; ?>" target="_blank"><?php echo $faculty->web; ?></a></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:faculty_comment_label'); ?></td>
        <td><?php echo $faculty->comment; ?></td>
    </tr>
</table>