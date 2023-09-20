<?php
if ( ! class_exists('NPF_Options')):


	class NPF_Options
	{
		var $base_args;
		var $options;
		var $top_level_menu;
		var $parent_page;
		function __construct($args) {

			$this->base_args = $args;
			$this->options = get_option($this->base_args['option_slug']);

			// Check if top level page
			if ( isset($this->base_args['top_level_menu']) && $this->base_args['top_level_menu'] ) {
				$this->top_level_menu = true;
			}
			else{
				$this->top_level_menu = false;
			}
			// Set submenu page
			if ( isset($this->base_args['parent_page']) && ! empty($this->base_args['parent_page'] ) ) {
				$this->parent_page = $this->base_args['parent_page'];
			}
			else{
				$this->parent_page = 'options-general.php';
			}

			add_action('admin_menu', array($this,'create_menu_page'));

			add_action('admin_init', array($this,'register_settings'));

			add_action('admin_enqueue_scripts', array($this,'plugin_scripts'));

		}




		function plugin_scripts(){

			$screen = get_current_screen();

			$required_screen = $this->get_required_screen();
			if ($required_screen != $screen->id ) {
				return;
			}

			// tzCheckbox
			wp_enqueue_style( 'npf-framework-tzcheckbox-style', plugin_dir_url( __FILE__ ) . '/assets/vendor/tzcheckbox/jquery.tzCheckbox.css' );
			wp_enqueue_script( 'npf-framework-tzcheckbox-script', plugin_dir_url( __FILE__ ) . 'assets/vendor/tzcheckbox/jquery.tzCheckbox.js', array('jquery') );

			// Upload requirement
			wp_enqueue_media();
			wp_enqueue_script( 'custom-header' );

			// Color
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker');

			// jQuery UI Style
			wp_enqueue_style( 'jquery-ui-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );

			// Select2
			wp_enqueue_style( 'npf-framework-select2-style', plugin_dir_url( __FILE__ ) . '/assets/vendor/select2/select2.css' );
			wp_enqueue_script( 'npf-framework-select2-script', plugin_dir_url( __FILE__ ) . 'assets/vendor/select2/select2.min.js', array('jquery') );

			// Simple Slider
			wp_enqueue_style( 'npf-framework-simple-slider-style', plugin_dir_url( __FILE__ ) . '/assets/vendor/simple-slider/simple-slider.css' );
			wp_enqueue_script( 'npf-framework-simple-slider-script', plugin_dir_url( __FILE__ ) . 'assets/vendor/simple-slider/simple-slider.min.js', array('jquery') );

			// Framework Style
			wp_enqueue_style( 'npf-framework-style', plugin_dir_url( __FILE__ ) . '/assets/css/npf.css' );

            wp_enqueue_script( 'npf-framework-cookie-script', plugin_dir_url( __FILE__ ) . 'assets/js/cookie.min.js', array('jquery') );
			wp_enqueue_script( 'npf-framework-tabs-script', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.easytabs.min.js', array('jquery') );

			wp_enqueue_script( 'npf-framework-timepicker', plugin_dir_url( __FILE__ ) . 'assets/js/jquery-ui-timepicker-addon.js', array('jquery','jquery-ui-core','jquery-ui-slider','jquery-ui-datepicker') );
			wp_enqueue_script( 'npf-framework-script', plugin_dir_url( __FILE__ ) . 'assets/js/npf.js', array('jquery','jquery-ui-core','jquery-ui-slider','jquery-ui-datepicker','npf-framework-tabs-script','npf-framework-timepicker','npf-framework-select2-script','npf-framework-tzcheckbox-script', 'npf-framework-cookie-script' ) );

		}

		function register_settings(){

			register_setting($this->base_args['option_slug'].'-group', $this->base_args['option_slug'], array($this, 'sanitize_callback') );

			foreach ($this->base_args['tabs'] as $tab_key => $tab) {

				add_settings_section(
					$tab['id'].'_settings'.'-'.$this->base_args['menu_slug'],
					$tab['title'] ,
					array($this,'section_text_callback'),
					$tab['id'].'-'.$this->base_args['menu_slug']
				);

				foreach ($tab['fields'] as $field_key => $field) {
					$args = array(
						'field'       => $field,
						'field_id'    => $field['id'],
						'field_name'  => $this->base_args['option_slug'].'['.$field['id'].']',
						'tab'         => $tab,
						'base_args'   => $this->base_args,
						'field_value' => (isset($this->options[$field['id']]))?$this->options[$field['id']]:'',
						'options'   => $this->options,
					);

					add_settings_field(
						$field_key,
						$field['title'],
						array($this,'field_callback'),
						$tab['id'].'-'.$this->base_args['menu_slug'],
						$tab['id'].'_settings'.'-'.$this->base_args['menu_slug'],
						$args
					);
				}

			}


		}

		////
		function sanitize_callback($input){

			$tabs = $this->base_args['tabs'];

			foreach ($tabs as $tab_key => $tab) {
				foreach ($tab['fields'] as $field_key => $field) {

					// Text
                    if ( 'text' == $field['type'] ) {
                        $input[$field['id']] = sanitize_text_field($input[$field['id']]);
                    }
					if ( 'custom_css' == $field['type'] ) {
						$input[$field['id']] = wp_filter_nohtml_kses($input[$field['id']]);
					}
					// URL
					if ( 'url' == $field['type'] ) {
						$input[$field['id']] = esc_url($input[$field['id']]);
					}
                    // Email
                    if ( 'email' == $field['type'] ) {
                        $input[$field['id']] = sanitize_email($input[$field['id']]);
                    }
                    // Checkbox simple.
                    if ( 'checkbox_simple' == $field['type'] ) {
                        $input[ $field['id'] ] = esc_attr( $input[ $field['id'] ] );
                    }
					// Checkbox.
					if ( 'checkbox' == $field['type'] ) {
                        if ( ! isset( $input[ $field['id'] ] ) ) {
                            $input[ $field['id'] ] = array();
                        }
					}
					// On/Off.
					if ( 'on_off' == $field['type'] ) {
						if ( isset($input[ $field['id'] ] ) ) {
                            $input[ $field['id'] ] = 'ON';
                        }
                        else {
							$input[ $field['id'] ] = 'OFF';
                        }
					}
					// Switch
					if ( 'switch' == $field['type'] ) {
						if ( ! isset($input[$field['id']]) ) {
							$off_value = '';
							if (isset($field['choices_off'])) {
								reset($field['choices_off']);
								$off_value = key($field['choices_off']);
							}
							if (!empty($off_value)) {
								$input[$field['id']] = $off_value;
							}
						}
					}

				}
			}

			return $input;

		}

		///
		function section_text_callback($arg){

			$id = $arg['id'];
			$current_section=str_replace('_settings', '', $id);
			$sub_heading = '';
			$callback_object = $arg['callback'][0];
			if (isset($callback_object->base_args['tabs'][$current_section]['sub_heading'])) {
				$sub_heading = $callback_object->base_args['tabs'][$current_section]['sub_heading'];
			}
			if (!empty($sub_heading)) {
				echo '<div class="npf-subheading">'.$sub_heading.'</div><!-- .npf-subheading -->';
			}

		}
		///
		///
		function field_callback($args){
			$field_type = $args['field']['type'];
			if ( ! class_exists('npf_field_'.$field_type) ) {
				$ov_file = $field_type.'.php';
				echo 'Class <strong>npf_field_'.$field_type.'</strong> does not exist.';
				return;
			}
			$class = 'npf_field_'.$field_type;
			$instance = $class::getInstance();
			$instance->render_field($args);
			$instance->show_description($args);

		}
		///
		function create_menu_page(){

			if ( true == $this->top_level_menu ) {
		    add_menu_page(
		        $this->base_args['page_title'],
		        $this->base_args['menu_title'],
		        $this->base_args['capability'],
		        $this->base_args['menu_slug'],
		        array($this,'menu_page_callback')
		    );
			}
			else{
		    add_submenu_page(
		    		$this->parent_page,
		        $this->base_args['page_title'],
		        $this->base_args['menu_title'],
		        $this->base_args['capability'],
		        $this->base_args['menu_slug'],
		        array($this,'menu_page_callback')
		    );
			}

		}

		function menu_page_callback(){

			require_once 'views/admin.php';

		}

		// Returns required screen
		function get_required_screen(){
			$output = '';
			$map_array = array(
				'index.php'         => 'dashboard',
				'edit.php'          => 'posts',
				'upload.php'        => 'media',
				'edit.php?post_type=page'  => 'pages',
				'edit-comments.php'   => 'comments',
				'themes.php'          => 'appearance',
				'plugins.php'         => 'plugins',
				'users.php'           => 'users',
				'tools.php'           => 'tools',
				'options-general.php' => 'settings',
				);
			if ( true == $this->top_level_menu ) {
				$output = 'toplevel';
			}
			else{
				if (isset($map_array[$this->parent_page])) {
					$output = $map_array[$this->parent_page];
				}
				else{
					$t= strpos($this->parent_page, 'edit.php?post_type=');
					if ( false !== $t ) {
						$output = substr($this->parent_page, strlen('edit.php?post_type=') );
					}

				}
			}
			$output .= '_page_';
			$output .= $this->base_args['menu_slug'];

			return $output;
		}

	}

endif; // end if not class_exists
