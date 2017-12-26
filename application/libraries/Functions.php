<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Functions{

	protected $CI;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('model_menus','menus');
	}

	public function generate_menu()
	{
		$menus = $this->CI->menus->get_list_menus($this->CI->session->role_id, 0, NULL);
		
		$menu_list = '';
		foreach($menus as $m) {
			// level 0 as parent
			$id = $m['id'];

			// level 1
			$menu1 = $this->CI->menus->get_list_menus($this->CI->session->role_id, 1, $id);
			if(count($menu1) > 0) {
				$menu_list .= '<li><a><i class="fa '.$m['icon'].'"></i> '.$m['menu'].' <span class="fa fa-chevron-down"></span></a>';
				$menu_list .= '<ul class="nav child_menu">';
				foreach($menu1 as $m1) {
					$id = $m1['id'];

					// level 2
					$menu2 = $this->CI->menus->get_list_menus($this->CI->session->role_id, 2, $id);
					if(count($menu2) > 0) {
						$menu_list .= '<li><a>'.$m1['menu'].'<span class="fa fa-chevron-down"></span></a>';
						$menu_list .= '<ul class="nav child_menu">';
						foreach($menu2 as $m2) {
							$id = $m2['id'];

							// level 3
							$menu3 = $this->CI->menus->get_list_menus($this->CI->session->role_id, 3, $id);
							if(count($menu3) > 0) {
								$menu_list .= '<li><a>'.$m2['menu'].'<span class="fa fa-chevron-down"></span></a>';
								$menu_list .= '<ul class="nav child_menu">';
								foreach($menu3 as $m3) {
									// $active = ($this->CI->uri->segment(1) == $m3['link']) ? 'class="active"':'';
									$menu_list .= '<li><a href="'.base_url($m3['link']).'">'.$m3['menu'].'</a></li>';
								}
								$menu_list .= '</ul></li>';
							} else {
								// $active = ($this->CI->uri->segment(1) == $m2['link']) ? 'class="active"':'';
								$menu_list .= '<li><a href="'.base_url($m2['link']).'">'.$m2['menu'].'</a></li>';
							}	
						}
						$menu_list .= '</ul></li>';
					} else {
						// $active = ($this->CI->uri->segment(1) == $m1['link']) ? 'class="active"':'';
						$menu_list .= '<li><a href="'.base_url($m1['link']).'">'.$m1['menu'].'</a></li>';
					}
				}
				$menu_list .= '</ul></li>';
			} else {
				// $active = ($this->CI->uri->segment(1) == $m['link']) ? 'class="active"':'';
				$menu_list .= '<li><a href="'.base_url($m['link']).'"><i class="fa '.$m['icon'].'"></i> '.$m['menu'].'</a></li>';
			}

			//dd($m['id']);
		}

		return $menu_list;
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

        if($grant_access == 0){
            show_404();
        }
    }

    public function is_login()
    {
    	if(!isset($this->CI->session->logged_in)) redirect('auth');
    }

}