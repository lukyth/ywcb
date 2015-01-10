<?php
return array(
	'title' => 'Users',
	'single' => 'user',
	'model' => 'User',
	'columns' => array(
		'email', 'display_name', 'created_at', 'updated_at'
	),
	'edit_fields' => array(
		'email', 'display_name'
	)
);