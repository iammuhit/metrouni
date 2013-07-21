<h1><?php echo $hour->hour . '. ' . lang('metrouni:hour_lecture_label'); ?></h1>

<p style="float:left; width: 40%;">
    <?php echo anchor('metrouni/hour/view/' . $hour->id, lang('global:view'), ' class="btn small green" target="_blank"'); ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
    <?php echo anchor('admin/metrouni/hours/edit/' . $hour->id, lang('global:edit'), ' class="btn small orange" target="_parent"'); ?>
</p>

<table>
    <tr>
        <td><?php echo lang('metrouni:hour_day_label'); ?></td>
        <td><?php echo $hour->day; ?></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:hour_beginhour_label'); ?></td>
        <td><?php echo $hour->beginhour; ?></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:hour_endhour_label'); ?></td>
        <td><?php echo $hour->endhour; ?></td>
    </tr>
    <tr>
        <td><?php echo lang('metrouni:hour_closed_label'); ?></td>
        <td><?php echo $hour->closed; ?></td>
    </tr>
</table>