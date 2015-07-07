<?php
defined('BASEPATH') or exit('No direct access script allowed');

if ( ! function_exists('set_value'))
{
    function set_value($field, $default = '', $html_escape = FALSE)
    {
        $CI =& get_instance();

        $value = (isset($CI->form_validation) && is_object($CI->form_validation) && $CI->form_validation->has_rule($field))
            ? $CI->form_validation->set_value($field, $default)
            : $CI->input->post($field, FALSE);

        isset($value) OR $value = $default;
        return ($html_escape) ? html_escape($value) : $value;
    }
}
