<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Detects if a given module is currently installed
 *
 * @param string $module A module slug to query
 * @return boolean TRUE or FALSE on installed or not
 * @access public
 */
function is_module_installed($module) {

    // Get instance
    $_CI = & get_instance();

    // Ensure core is installed first
    $query = $_CI->db->select('id')->where("slug = '{$module}' AND installed = 1")->get('modules');

    // Check query
    if ($query->num_rows()) {
        return TRUE;
    }

    return FALSE;
}

/**
 * Truncates a string by a number of characters but ensures to complete the
 * last word, following by "..."
 *
 * @param string $string The string to truncate
 * @param integer $length (Optional) The character count to limit to
 * @return string The truncated string
 * @access public
 */
function truncate_words($string, $length = 140) {

    if (strlen($string) > $length) {
        $string = substr($string, 0, strrpos(substr($string, 0, $length), ' ')) . '...';
    }

    return $string;
}

/**
 * Splits Streams fileds into an array of tabs, specified fields in a tabs array
 * will be put into their designated positions with all others failling into a
 * default "general options" array.
 *
 * @param array $fields A Streams generated array of fields
 * @param array $tabs A guide containing the tab name and an array of field names
 * @return array
 * @access public
 */
function fields_to_tabs($fields, $tabs, $default = 'general') {

    // Variables
    $data = array($default => array());

    // Loop fields
    foreach ($fields AS $field) {

        // Reset found
        $found = FALSE;

        // Loop each of the tab options
        foreach ($tabs AS $tab => $slugs) {

            // Add tab to array?
            if (!array_key_exists($tab, $data)) {
                $data[$tab] = ( substr($tab, 0, 1) == '_' ? $slugs : array() );
            }

            // Assign to special tab
            if (in_array($field['input_slug'], $slugs)) {
                $data[$tab][] = $field;
                $found = TRUE;
            }
        }

        // Default to general
        if ($found == FALSE) {
            $data[$default][] = $field;
        }
    }

    // Retrun
    return $data;
}

/* End of file general_helper.php */
/* Location: ./modules/metrouni/helpers/general_helper.php */