<?php
/** 
 * Methods related to defining and registering sidebars 
 *
 * (@link http://codex.wordpress.org/Conditional_Tags)
 *
 * PHP version 5.3
 *
 * LICENSE: TODO
 *
 * @package WPezClasses
 * @author Mark Simchock <mark.simchock@alchemyunited.com>
 * @since 0.5.0
 * @license TODO
 */
 
/*
* == Change Log == 
*
* --- 24 August 2014 - Ready
*
*/


// No WP? Die! Now!!
if (!defined('ABSPATH')) {
	header( 'HTTP/1.0 403 Forbidden' );
    die();
}

if (! class_exists('Class_WP_ezClasses_Theme_Register_Sidebar_1') ) {
  class Class_WP_ezClasses_Theme_Register_Sidebar_1 extends Class_WP_ezClasses_Master_Singleton {
  
    protected $_arr_init;
	
	protected $_arr_register_sidebar_base;
	protected $_arr_register_sidebar;
	
	protected function __construct() {
	  parent::__construct();
	}
	
	/**
	 *
	 */
	public function ezc_init($arr_args = NULL){
	 
	  $this->_arr_init = $this->init_defaults();
	}
		

		
    protected function init_defaults(){
	
	  $arr_defaults = array(
	    'active' 		=> true,
		'active_true'	=> true,
		'filters' 		=> false,
		'validation' 	=> false,
		'base'			=> array(),
		'arr_args'		=> array(),
        ); 
	  return $arr_defaults;
	}
		
		
    /**
	 *
	 */ 
    public function ez_rs($arr_args = ''){
	
	  if ( WP_ezMethods::array_pass($arr_args) )
	  
	    $arr_args = WP_ezMethods::ez_array_merge(array( $this->_arr_init, $arr_args));
		
	//die(print_r($this->_arr_init));  
	
	    if ( $arr_args['active'] === true && WP_ezMethods::array_pass($arr_args['arr_args']) ){
		
		  $arr_register_sidebar_base = $arr_args['base'];
		  $arr_register_sidebar = $arr_args['arr_args'];

			
				// validate - optional
				/* TODO
				if ( isset($arr_args['validate']) && $arr_args['validate'] === true ){
					$bool_return = false;
					$arr_validate_response_merge = array();
					
					$arr_validate_response = $this->_obj_ezc_theme_register_sidebar->register_sidebar_base_validate($arr_register_sidebar_base);
					if ( $arr_validate_response['status'] !== true){
						$arr_validate_response_merge[] = $arr_validate_response;
						$bool_return = true;
					} else {
						$arr_register_sidebar_base = $arr_validate_response['arr_args'];
					}
					
					
					$arr_validate_response = $this->_obj_ezc_theme_register_sidebar->register_sidebar_validate($arr_register_sidebar);
					if ( $arr_validate_response['status'] !== true){
						$arr_validate_response_merge[] = $arr_validate_response;
						$bool_return = true;
					} else {
						$arr_register_sidebar = $arr_validate_response['arr_args'];
					}
					
					if  ( $bool_return === true ) {
						return $arr_validate_response_merge;
					}	
				}
				*/
							
				/**
				 * returns arr_args that are actice. if you 
				 */
				if ( isset($arr_args['active_true']) && $arr_args['active_true'] === true ){
				
					$arr_active_true_response = $this->register_sidebar_active_true($arr_register_sidebar);
					
					if ( ! isset($arr_active_true_response['status']) && $arr_active_true_response['status'] === false ){
						return $arr_active_true_response;
					}
					$arr_register_sidebar = $arr_active_true_response['arr_args'];
				}
				
				/*
				 * At this point we should be good to go.
				 */ 
				 
				// set - if you're going to _do then you have to _set

				$this->_arr_register_sidebar_base = WP_ezMethods::ez_array_merge(array($this->register_sidebar_base_defaults(), $arr_register_sidebar_base));
				$this->_arr_register_sidebar = $arr_register_sidebar;

				// do
				$this->register_sidebar_do();

				return true;
			
			} else {
			//TODO - not an array
			}
		}  


		/**
		 *
		 */
		public function register_sidebar_base_defaults() {

			$arr_defaults = array(	
								'active'			=> true,
								'description'   	=> '',
								'before_widget'		=> '<div id="WP-EZC-WIDGET-ID" class="wp-ezbs-widget WP-EZC-WIDGET-CLASS">', 
								'after_widget'		=> '</div>',
								'before_title'		=> '<div class="wp-ezbs-widget-title">',
								'after_title'		=> '</div>'
							);	
			
			/*
			 * Allow filters?
			 */			
			if ( $this->_arr_init['filters'] ){
				$arr_defaults_via_filter = apply_filters('filter_ezc_theme_register_sidebar_1_base_defaults', $arr_defaults);
				$arr_defaults = WP_ezMethods::_ez_array_merge(array($arr_defaults, $arr_defaults_via_filter));
			}
			return $arr_defaults;
		}				

		/**
		 * TODO - this validate will be the same as the reg sidebar validate since - in theory anything can be in this or that.
		 */
		 /*
		public function register_sidebar_base_validate($arr_args = NULL){
			$str_return_source = 'Theme \ Register :: register_sidebar_base_validate()'; 
			if ( $this->_bool_ezc_validate !== false ){

				//TODO
				return array('status' => true, 'msg' => 'success', 'source' => $str_return_source, 'arr_args' => $arr_args);
				
			} else {
			
				return array('status' => true, 'msg' => 'validate off', 'source' => $str_return_source, 'arr_args' => $arr_args);
			}
		}
		*/
	
	
		/**
		 *
		 */
		/*
		public function register_sidebar_base_set($arr_args = NULL) {	
			$str_return_source = 'Theme \ Register :: register_sidebar_base_set()'; 
	

			if ( is_array($arr_args) ){
			
				//TODO register_sidebar_base_validate()
			
				$this->_arr_register_sidebar_base = array_merge($this->register_sidebar_base_defaults(), $arr_args);			
				return array('status' => true, 'msg' => 'success', 'source' => $str_return_source, 'arr_args' => $arr_args);
			}
			return array('status' => false, 'msg' => 'ERROR: arr_args !is_array()', 'source' => $str_return_source, 'arr_args' => 'error');
		}
		*/
		


		
		/**
		 *
		 */
		/*
		public function register_sidebar_validate($arr_args = NULL){
			$str_return_source = 'Theme \ Register Sidebar :: register_sidebar_validate()'; 
			
			if ( $this->_bool_ezc_validate !== false ){

				//TODO - needs *much* improvement
				
				if ( is_array($arr_args) && !empty($arr_args) ){
					return array('status' => true, 'msg' => 'success', 'source' => $str_return_source, 'arr_args' => $arr_args);
				}
				return array('status' => false, 'msg' => 'ERROR: arr_args !is_array() || empty()', 'source' => $str_return_source, 'arr_args' => 'error');
			} else {
				// TODO - improve msg? 
				return array('status' => true, 'msg' => 'validate off', 'source' => $str_return_source, 'arr_args' => $arr_args);
			}
		}
		*/
		
		/**
		 * Whips through the array and returns only the active ones
		 */	
		public function register_sidebar_active_true($arr_args = NULL) {
			$str_return_source = get_class() . ' ' . __METHOD__; 
		
			if ( WP_ezMethods::array_pass($arr_args) ) {
			
				$arr_active_true = array();
				foreach ($arr_args as $str_key => $arr_value){
					if (  isset($arr_value['active']) && $arr_value['active'] === true ) {
						$arr_active_true[$str_key] = $arr_value;	
					}
				}	
				return array('status' => true, 'msg' => 'success', 'source' => $str_return_source . ' ' , 'arr_args' => $arr_active_true);
			}
			return array('status' => false, 'msg' => 'ERROR: arr_args ! is_array() || empthy()', 'source' => $str_return_source, 'arr_args' => 'error');
		}
		
			
		/**
		 * Combines the base and the values and makes the register_sidebar() magic happen
		 */
		public function register_sidebar_do() {
			$str_return_source = get_class() . ' ' . __METHOD__; 

			if ( WP_ezMethods::array_pass($this->_arr_register_sidebar) ){
			
						// OK now crank'em out
			  foreach( $this->_arr_register_sidebar as $str_key => $arr_value ){
			
				// Let's - for now - the list has been pre scrubbed. 
				//if ( isset($arr_value['active']) && $arr_value['active'] === true ) {
			
					$arr_value = array_merge($this->_arr_register_sidebar_base, $arr_value);
				
					$str_widget_class = isset($arr_value['class_widget']) ? $arr_value['class_widget'] : 'wp-ezc-class-not-assigned-%1';
					$str_widget_id = isset($arr_value['id_css']) ? $arr_value['id_css'] : "wp-ezbs-widget";

					$str_widget_before = preg_replace("%WP-EZC-WIDGET-CLASS%", $str_widget_class , $arr_value['before_widget']);									
					$str_widget_before = preg_replace("%WP-EZC-WIDGET-ID%", $str_widget_id , $str_widget_before);

					/*
					 * Note: The basic widget configs in are: name, id, description, and class. You can, if you wish, on a widget area by
					 * widget area basis, also define before_widget, after_widget, before_title, after_title. If these are not defined then the logic
					 * below will use the widget-base as the standard / baseline values. 
					 *
					 * Saves some repetetive typing. Nice, right?
					 */ 

					register_sidebar(array(
										'name' 			=> isset($arr_value['name']) ? $arr_value['name'] : $str_key, 
										'description'   => $arr_value['description'],
										'id'			=> $arr_value['id_ds_unique'],
										'before_widget' => $str_widget_before,	
										'after_widget'  => $arr_value['after_widget'],
										'before_title'  => $arr_value['before_title'],
										'after_title'   => $arr_value['after_title'], 
									));   
									
					//TODO - does register_sidebar return an error if it fails?
				//}
			}

			return array('status' => true, 'msg' => 'success', 'source' => $str_return_source, 'arr_args' => $this->_arr_register_sidebar);
			
			} else { 
			
			  return array('status' => false, 'msg' => 'ERROR: property _arr_register_sidebar !isset() || empty()', 'source' => $str_return_source, 'arr_args' => 'error');
			
			}

		}

	
		
	} // END: class
} // END: if class exists


?>