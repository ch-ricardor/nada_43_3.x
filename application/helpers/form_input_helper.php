<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Returns value of the $_POST by name
 *
 * @access	public
 * @param	string - post variable name
 * @param	string - optional second value to return if POST is empty
 * @return	string
 */
if ( ! function_exists('get_form_value'))
{
	function get_form_value($field, $ofield='')
	{
		$ci=& get_instance();

		//return form get/post value
		if (isset($_POST[$field]) || isset($_GET[$field]))
		{
			//return form_prep($ci->input->post_get($field), $field);
			return form_prep($ci->security->xss_clean($ci->input->post_get($field)));
		}

		//return default value
		return form_prep($ofield);
	}
}


/**
 * Generates a hidden field containing a nonce.
 *
 * @access	public
 * @return	string
 * @link	http://blog.streambur.se/2010/06/no-nonsense-protection-using-a-nonce
 */
if ( ! function_exists('form_nonce'))
{
	function form_nonce()
	{
        $CI =& get_instance();
        //$CI->load->library('form_validation');
		$field = '<input type="text" name="nonce" value="'
            . $CI->form_validation->set_value('nonce', $CI->form_validation->create_nonce())
            . '" />';
        return $field;
	}
}


/**
 * Gets a value from GET/POST/SESSION
 *
 * @access	public
 * @return	string
 * @link
 * @author	Mehmood Asghar
 */
if ( ! function_exists('get_post_sess'))
{
	function get_post_sess($session_id,$field)
	{
		$CI =& get_instance();

		//check query strings
		// @todo 2.x to 3.x Upgrade Step 10
		// if ($CI->input->get($field)!==FALSE)
		if ($CI->input->get($field)!==NULL)
		{
			return $CI->input->get($field);
		}

		//this is needed when a value is unset, otherwise we can't unset a key
		//view param is required in the querystring

		// @todo 2.x to 3.x Upgrade Step 10
		//if ($CI->input->get('view')!==FALSE)
		if ($CI->input->get('view')!==NULL)
		{
			return FALSE;
		}

		return FALSE;

		// @todo RRE The code below never will run.

		//check session
		$sess_data=	$CI->session->userdata($session_id);

		//no data set?
		if (!$sess_data)
		{
			return FALSE;
		}

		//check key in session
		if (isset($sess_data[$field]) && $sess_data[$field]!=='')
		{
			return $sess_data[$field];
		}

		return FALSE;
	}
}


/**
 * Gets a value from GET/POST/COOKIE
 *
 * @access	public
 * @return	string
 * @link
 * @author	Mehmood Asghar
 */
if ( ! function_exists('get_post_cookie'))
{
	function get_post_cookie($cookie_id,$field)
	{
		$CI =& get_instance();

		//check query strings

		// @todo 2.x to 3.x Upgrade Step 10
		//if ($CI->input->post_get($field)!==FALSE)
		if ($CI->input->post_get($field)!==NULL)
		{
			return $CI->input->post_get($field);
		}

		//check cookie
		$cookie_data=	$CI->$this->input->cookie($cookie_id);

		//no data set?
		if (!$cookie_data)
		{
			return FALSE;
		}

		//check key in session
		if (isset($cookie_data[$field]) && $cookie_data[$field]!=='')
		{
			return $cookie_data[$field];
		}

		return FALSE;
	}
}

/* End of file form_input_helper.php */
/* Location: ./application/helpers/form_input_helper.php */
