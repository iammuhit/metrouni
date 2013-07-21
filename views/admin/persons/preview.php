<h1><?php echo $user->first_name . ' ' . $user->last_name; ?></h1>

<p style="float:left; width: 40%;">
	<?php echo anchor('metrouni/person/view/' . $user->username, NULL, 'target="_blank"'); ?>
</p>

<p style="float:right; width: 40%; text-align: right;">
	<?php echo anchor('admin/metrouni/persons/edit/' . $user->id, lang('buttons.edit'), ' target="_parent"'); ?>
</p>

<iframe src="<?php echo site_url('metrouni/person/view/' . $user->username); ?>" width="99%" height="400"></iframe>