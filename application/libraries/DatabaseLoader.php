<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class DatabaseLoader
{
	public function __construct() {
			 $this->load();
	 }

	 /**
	  * Load the databases and ignore the old ordinary CI loader which only allows one
	  */
	 public function load() {
			 $CI =& get_instance();

			 $CI->db = $CI->load->database('default', TRUE);
			 $CI->db2 = $CI->load->database('db2', TRUE);
	 }
}
?>