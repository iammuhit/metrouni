<h1><?php echo $semester->name; ?></h1>

<p style="float:left; width: 40%;">
    <?php echo anchor('metrouni/semester/view/' . $semester->id, lang('global:view'), ' class="btn small green" target="_blank"'); ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
    <?php echo anchor('admin/metrouni/semesters/edit/' . $semester->id, lang('global:edit'), ' class="btn small orange" target="_parent"'); ?>
</p>

<table>
    <tr>
        <td><?php echo lang('metrouni:semester_name_label'); ?></td>
        <td><?php echo $semester->name; ?></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:semester_begindate_label'); ?></td>
        <td><?php echo $semester->begindate; ?></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:semester_enddate_label'); ?></td>
        <td><?php echo $semester->enddate; ?></td>
    </tr>
</table>