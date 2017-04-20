<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * NADA
 *
 * Microdata Cataloging Tool
 *
 * @category
 * @package
 * @subpackage
 * @author
 * @copyright           IHSN
 * @license             http://
 * @link                http://www.surveynetwork.org
 * @since               Version 1.0
 * @version             Version 4.3
 */

// ------------------------------------------------------------------------


class Configurations_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
		//$this->output->enable_profiler(TRUE);
    }

    /**
    * load NADA configurations table
    *
    */
    function load()
    {
	/**
	 @todo RRE - Validation to be able to install the app
	*/
	if (! $this->db->table_exists('configurations')){
		log_message('error', 'configurations table does not exists. configurations_model.php');
		return FALSE;
	}

	$this->db->select('name,value');
	$result= $this->db->get('configurations');

	if (isset($result))
	{
		return $result->result_array();
	}

	return FALSE;
    }

    /**
     * returns all settings
     *
    */
    function select_all()
    {
	$this->db->select('*');
	$this->db->from('configurations');
        return $this->db->get()->result_array();
    }


    /**
     * check if a config key exists
     *
    */
    function check_key_exists($key)
    {

	/**
	 @todo RRE - Validation to be able to install the app
	*/
	if (! $this->db->table_exists('configurations')){
		log_message('error', 'configurations table does not exists. configurations_model.php');
		return FALSE;
	}

	/**
	 @todo RRE - Query Helper Not working
	*/
/*
	$result = $this->db->query("SELECT count(*) as found FROM configurations WHERE name = '$key';");

		if ( !isset($result) )
		{
			return FALSE;
		}

		$result = $result->row_array();
		if ( $result['found'] > 0 )
		{
			return TRUE;
		}
		return FALSE;
*/

		$this->db->select("count(*) as found ");
		$this->db->where('name',$key);
                $this->db->from('configurations');
                $result = $this->db->get();
		if (!$result)
		{
			return FALSE;
		}

		$result = $result->row_array();
/*
		echo $key;
		echo $result['found'];
*/
		if ($result && $result['found']>0)
		{
			return TRUE;
		}

		return FALSE;


    }

	/**
	* returns an array of site configurations
	*
	*/
	function get_config_array()
    {
		$this->db->select('name,value');
		$this->db->from('configurations');
		$rows=$this->db->get()->result_array();

		$result=array();
		foreach($rows as $row)
		{
			$result[$row['name']]=$row['value'];
		}

		return $result;
    }


	/**
	* update configurations
	*
	*/
	function update($options)
	{
		foreach($options as $key=>$value)
		{
			$data=array('value'=>$value);
			$this->db->where('name', $key);
			$result=$this->db->update('configurations', $data);

			if(!$result)
			{
				return FALSE;
			}
		}
		return TRUE;
	}

	/**
	* add new configuration
	*
	*/
	function add($name, $value,$label=NULL, $helptext=NULL)
	{

		/**
		 @todo RRE - Validation to be able to install the app
		*/
		if (! $this->db->table_exists('configurations')){
			log_message('error', 'configurations table does not exists. configurations_model.php');
			return FALSE;
		}


		if (trim($name)=='')
		{
			return FALSE;
		}

		//check key already exists
		if ($this->check_key_exists($name))
		{
			return FALSE;
		}

		$data=array('name'=>$name,'value'=>$value,'label'=>$label,'helptext'=>$helptext);
		$result=$this->db->insert('configurations', $data);

		if(!$result)
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	*
	* Return an array of vocabularies
	*
	*/
	function get_vocabularies_array()
    {
		$this->db->select('vid,title');
		$this->db->from('vocabularies');
		$query=$this->db->get();

		if($query)
		{
			$rows=$query->result_array();

			$result=array('-'=>'---');
			foreach($rows as $row)
			{
				$result[$row['vid']]=$row['title'];
			}
			return $result;
		}

		return FALSE;
    }


}
?>
