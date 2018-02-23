<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Functions{

	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('model_menus','menus');
	}

	
	// check priv for check button hide and show
	public function check_priv($role_id, $link)
	{

        $menu = $this->CI->menus->get_menu($role_id, $link);

        return $menu;
    }

    // check access read if passing module by url
    public function check_access($role_id, $link)
    {
        $module = $this->CI->menus->get_menu($role_id, $link);
        
        $grant_access = $module['access_module'];

        if($module['is_published'] == 0) {
        	show_404();
        }

        if($grant_access == 0){
            show_404();
        }
    }

    // check access create, update, delete if passing sub by url
    public function check_access2($role_id, $link, $action_module) 
    {
        $action_module = strtolower($action_module);
        $module = $this->CI->menus->get_menu($role_id, $link);

        $submodule = $module['privileges'];
        $privileges = explode(',', $submodule);

        switch($action_module){
            case "add"   	: $grant_access = $privileges[0]; break;
            case "update"   : $grant_access = $privileges[1]; break;
            case "delete"   : $grant_access = $privileges[2]; break;
            default         : $grant_access = 0; break;
        }

        if($module['is_published'] == 0) {
        	show_404();
        }

        if($grant_access == 0){
            show_404();
        }
    }

    public function is_login()
    {
    	if(!isset($this->CI->session->logged_in)) {
    		redirect('auth');
    	}
    }

}