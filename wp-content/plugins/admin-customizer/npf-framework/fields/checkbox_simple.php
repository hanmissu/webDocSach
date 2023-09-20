<?php
if ( ! class_exists('npf_field_checkbox_simple')):
	class npf_field_checkbox_simple extends npf_field
	{
		var $args;
		function __construct()
		{
			// vars
			$this->name = 'checkbox_simple';

			// do not delete!
	  	parent::__construct();
		}

		function render_field($args)
		{

            $field_value = $this->get_value( $args );
            echo '<input type="hidden" name="' . $args['field_name'] . '" value="0" />';
            echo '<input type="checkbox" name="' . $args['field_name'] . '" id="' . $args['field_id'] . '" value="1" ' . checked( $field_value, 1, false ) . ' class="stylish-checkbox" />';
            echo '<label for="'.$args['field_id'].'">&nbsp;</label>';

		}

	}

endif;
