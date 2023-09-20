<?php

require_once 'core.php';

// Include fields.
$fields = array(
	'_base',
	'checkbox_simple',
	'checkbox',
	'color',
	'cpt_checkbox',
	'custom_css',
	'custom_post_type_checkbox',
	'custom_post_type_select',
	'custom_taxonomy_checkbox',
	'custom_taxonomy_select',
	'date_time',
	'date',
	'email',
	'nav_menu_select',
	'number',
	'numeric_slider',
	'on_off',
	'password',
	'radio_image',
	'radio',
	'select',
	'sidebar_select',
	'switch',
	'text',
	'textarea',
	'time',
	'upload',
	'url',
	'user_role_checkbox',
	'user_role_select',
	'wysiwyg',
);

foreach ( $fields as $field ) {
	include_once ADMIN_CUSTOMIZER_PLUGIN_URI . '/npf-framework/fields/'. $field . '.php';
}
