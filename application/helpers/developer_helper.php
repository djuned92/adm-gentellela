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