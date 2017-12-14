<?php

/**
 * Debug some vars and die.
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

function encode($value)
{
    $ci =& get_instance();
    $ci->load->library('encrypt');
    return $ci->encrypt->encode($value);
}

function decode($value)
{
    $ci =& get_instance();
    $ci->load->library('encrypt');
    return $ci->encrypt->decode($value);   
}