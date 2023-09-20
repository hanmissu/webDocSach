<?php
if ( ! class_exists('npf_field_custom_css')):
	class npf_field_custom_css extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'custom_css';

			// do not delete!
	  	parent::__construct();
		}

		function render_field($args)
		{

			$rows = (isset($args['field']['rows'])) ? intval($args['field']['rows']) : 5 ;
			$field_value = $this->get_value($args);

			echo '<textarea type="text" name="'.$args['field_name'].'" id="'.$args['field_id'].'" class="large-text code" rows="'.$rows.'" >';
			echo esc_textarea($field_value);
			echo '</textarea>';

		}

	}
endif;
