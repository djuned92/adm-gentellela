<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * dd is developer debug some vars and die.
 * @param* mixed vars The things to debug.
 */
function dd(){
    $args = func_get_args();
    ob_start();
    echo '<pre>';
    foreach($args as $vars){
        if(is_bool($vars) || is_null($vars))
            var_dump($vars);
        else
            echo htmlspecialchars(print_r($vars, true), ENT_QUOTES);
        echo PHP_EOL;
    }
    echo '</pre>';
    
    $ctx = ob_get_contents();
    ob_end_clean();
    
    echo $ctx;
    die;
}

/**
 * Check if current env is development
 * @return boolean true on dev~ false otherwise.
 */
function is_dev(){
    return ENVIRONMENT == 'development';
}

/**
 * Short-hand of get_instance of CodeIgniter
 * @return the CI object.
 */
function &ci(){
    $ci =&get_instance();
    return $ci;
}

/**
 * Short-hand for htmlspecialchars
 * @param string str The string to encode
 * @return string encoded $str
 */
function hs($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
* short to encode
* @param value
*/
function encode($value)
{
    $ci =& get_instance();
    $ci->load->library('encrypt');
    return str_replace(array('+','/','='),array('-','_','~'), $ci->encrypt->encode($value));
}

/**
* short to decode
* @param value
*/
function decode($value)
{
    $ci =& get_instance();
    $ci->load->library('encrypt');
    $value = str_replace(array('-','_','~'), array('+','/','='), $value);   
    return $ci->encrypt->decode($value);
}

/**
* function noted_log
* @param activity = array, uri_segment_3
* return create logs
*/
function noted_log($activity, $uri_segment_3 = FALSE)
{
    $ci =& get_instance();
    $ci->load->model('m_global','global');
    $ci->load->library('session');

    if($uri_segment_3 == TRUE) {
        $log = '/' . $ci->uri->segment(1) . '/' . $ci->uri->segment(2) . '/' . $uri_segment_3;
    } else {
        $log = '/' . $ci->uri->segment(1) . '/' . $ci->uri->segment(2);
    }

    $data_log = [
        'log'           => $log,
        'activity'      => json_encode($activity),
        'user_id'       => $ci->session->id,
        'created_by'    => $ci->session->username,
        'created_at'    => date('Y-m-d H:i:s'),
    ];
    return $ci->global->create('logs', $data_log);
}

function generate_menu()
{   
    $ci =& get_instance();
    $ci->load->model('model_menus','menus');
    $menus = $ci->menus->get_list_menus($ci->session->role_id, 0, NULL);
        
        $menu_list = '';
        foreach($menus as $m) {
            // level 0 as parent
            $id = $m['id'];

            // level 1
            $menu1 = $ci->menus->get_list_menus($ci->session->role_id, 1, $id);
            if(count($menu1) > 0) {
                $menu_list .= '<li><a><i class="fa '.$m['icon'].'"></i> '.$m['menu'].' <span class="fa fa-chevron-down"></span></a>';
                $menu_list .= '<ul class="nav child_menu">';
                foreach($menu1 as $m1) {
                    $id = $m1['id'];

                    // level 2
                    $menu2 = $ci->menus->get_list_menus($ci->session->role_id, 2, $id);
                    if(count($menu2) > 0) {
                        $menu_list .= '<li><a>'.$m1['menu'].'<span class="fa fa-chevron-down"></span></a>';
                        $menu_list .= '<ul class="nav child_menu">';
                        foreach($menu2 as $m2) {
                            $id = $m2['id'];

                            // level 3
                            $menu3 = $ci->menus->get_list_menus($ci->session->role_id, 3, $id);
                            if(count($menu3) > 0) {
                                $menu_list .= '<li><a>'.$m2['menu'].'<span class="fa fa-chevron-down"></span></a>';
                                $menu_list .= '<ul class="nav child_menu">';
                                foreach($menu3 as $m3) {
                                    // $active = ($ci->uri->segment(1) == $m3['link']) ? 'class="active"':'';
                                    $menu_list .= '<li><a href="'.base_url($m3['link']).'">'.$m3['menu'].'</a></li>';
                                }
                                $menu_list .= '</ul></li>';
                            } else {
                                // $active = ($ci->uri->segment(1) == $m2['link']) ? 'class="active"':'';
                                $menu_list .= '<li><a href="'.base_url($m2['link']).'">'.$m2['menu'].'</a></li>';
                            }   
                        }
                        $menu_list .= '</ul></li>';
                    } else {
                        // $active = ($ci->uri->segment(1) == $m1['link']) ? 'class="active"':'';
                        $menu_list .= '<li><a href="'.base_url($m1['link']).'">'.$m1['menu'].'</a></li>';
                    }
                }
                $menu_list .= '</ul></li>';
            } else {
                // $active = ($ci->uri->segment(1) == $m['link']) ? 'class="active"':'';
                $menu_list .= '<li><a href="'.base_url($m['link']).'"><i class="fa '.$m['icon'].'"></i> '.$m['menu'].'</a></li>';
            }

            //dd($m['id']);
        }
        
        return $menu_list;
} 