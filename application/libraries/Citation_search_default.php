<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Citation Search Class for MySQL
 *
 *
 *
 * @package	NADA 3
 * @subpackage	Libraries
 * @category	Citation Search MySQL
 * @author	Mehmood Asghar
 * @link	-
 *
 */

class Citation_search_default{

	/**
	 * @todo Redefining the object
	 *
	*/
	var $ci_sql;

	var $errors=array();
	var $search_found_rows=0;


	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	*/
	function __construct($params = array())
	{
		$this->ci_sql=& get_instance();

		if (count($params) > 0)
		{
			$this->initialize($params);
		}

		//$this->ci_sql->output->enable_profiler(TRUE);
	}

	function initialize($params=array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}


	//search
	function search($limit = NULL, $offset = NULL,$filter=NULL,$sort_by=NULL,$sort_order=NULL,$published=NULL,$repositoryid=NULL)
	{
		//fields returned by select
		// $select_fields='SQL_CALC_FOUND_ROWS
		/**
		  * @todo Changing the recordcount
		*/
		$select_fields='citations.id,
				citations.title,
				citations.subtitle,
				citations.alt_title,
				citations.authors,
				citations.editors,
				citations.translators,
				citations.changed,
				citations.created,
				citations.published,
				citations.volume,
				citations.issue,
				citations.idnumber,
				citations.edition,
				citations.place_publication,
				citations.place_state,
				citations.publisher,
				citations.publication_medium,
				citations.url,
				citations.page_from,
				citations.page_to,
				citations.data_accessed,
				citations.organization,
				citations.ctype,
				citations.pub_day,
				citations.pub_month,
				citations.pub_year,
				citations.abstract,
				citations.keywords,
				citations.notes,
				citations.doi,
				citations.flag,
				count(survey_citations.sid) as survey_count,
				citations.owner';

		//select columns for output
		$this->ci_sql->db->select($select_fields, FALSE);

		//allowed_fields
		$db_fields=array(
			'id'=>'citations.id',
			'title'=>'citations.title',
			'subtitle'=>'citations.subtitle',
			'alt_title'=>'citations.alt_title',
			'authors'=>'citations.authors',
			'editors'=>'citations.editors',
			'translators'=>'citations.translators',
			'place_publication'=>'citations.place_publication',
			'publisher'=>'citations.publisher',
			'url'=>'citations.url',
			'place_state'=>'citations.place_state',
			'country'=>'surveys.nation',
			'pub_year'=>'citations.pub_year',
			'survey_count'=>'survey_count',
			'changed'=>'citations.changed',
			'created'=>'citations.created',
			'ctype'=>'citations.ctype',
			'keywords'=>'citations.keywords',
			'notes'=>'citations.notes',
			'doi'=>'citations.doi',
			'flag'=>'citations.flag',
			'published'=>'citations.published',
			'owner'=>'citations.owner'
			);

		//fields to search when search=ALL FIELDS
		$all_fields=array(
			'citations.title',
			'citations.subtitle',
			'citations.alt_title',
			'citations.authors',
			'citations.url',
			// 'citations.pub_year', // This field is Integer
			'citations.country',
			'citations.keywords',
			'citations.doi'
			);

		// @todo RRE Fulltext index not included in the install sql
		// @todo modify the sql install script
		// $fulltext_index='citations.title,citations.subtitle,citations.authors,citations.doi,citations.keywords';
		$fulltext_index=implode(',',$all_fields);
		$country_fulltext_index='surveys.nation';


		$this->ci_sql->db->from('citations');
		$this->ci_sql->db->join('survey_citations', 'survey_citations.citationid = citations.id','left');
		$this->ci_sql->db->join('surveys', 'survey_citations.sid = surveys.id','left');

		//filter by repository if set
		if($repositoryid!=NULL && strtolower($repositoryid)!='central')
		{
			$this->ci_sql->db->join('survey_repos', 'surveys.id = survey_repos.sid','inner');
			$this->ci_sql->db->where('survey_repos.repositoryid',$repositoryid);
		}

		$this->ci_sql->db->group_by('citations.id');

		//set where
		if ($filter)
		{
			foreach($filter as $f)
			{
				$keywords=trim($f['keywords']);

				// @todo Review condition restructuration
				if (trim($keywords)!="" && strlen($keywords)>=3)
				{
					switch ($f['field'])
					{
						case "pub_year" :
							if (is_numeric($f['keywords']))
							{
								$this->ci_sql->db->where(sprintf("%s =%s",$f['field'], intval($f['keywords'])));
							}
							break;
						// This option requires a Fulltext index on the table citations
						case "all" :
							//$this->ci_sql->db->where(sprintf('MATCH(%s) AGAINST(%s IN BOOLEAN MODE)',$fulltext_index,$this->ci_sql->db->escape($keywords)));
							foreach ($all_fields as $keylike)
							{
								$this->ci_sql->db->or_like($keylike,$keywords);
							}
							break;
						case "authors" :
						case "country" :
						case "title" :
							$this->ci_sql->db->like('citations.'.$f['field'],$keywords);
							break;
						default :
							$this->ci_sql->db->like('citations.'.$f['field'],$keywords);
					}
				}

/*
				if (trim($keywords)!="" && strlen($keywords)>=3)
				{
					//search only in the allowed fields
					if ($f['field']!='' &&  array_key_exists($f['field'],$db_fields))
					{

						{
						//$this->ci->db->like($db_fields[$f['field']], trim($keyword));
						$this->ci_sql->db->where(sprintf('MATCH(%s) AGAINST(%s IN BOOLEAN MODE)',$f['field'],$this->ci_sql->db->escape($keywords)));
						}
					}
					else if ($f['field']=='all')
					{
						//$this->ci->db->or_like($field, trim($keyword));
						$this->ci_sql->db->where(sprintf('MATCH(%s) AGAINST(%s IN BOOLEAN MODE)',$fulltext_index,$this->ci_sql->db->escape($keywords)));
						// @todo Validate this option
						//$this->ci_sql->db->or_where(sprintf('MATCH(%s) AGAINST(%s IN BOOLEAN MODE)',$country_fulltext_index,$this->ci_sql->db->escape($keywords)));
					}
				}
*/
				if ( ($f['field']=='notes' ||  $f['field']=='flag') && $f['keywords']=='*')
				{
					$this->ci_sql->db->where(sprintf("%s !=''",$f['field']));
				}

			}
		}

		//set order by
		if ($sort_by!='' && $sort_order!='')
		{
			if (array_key_exists($sort_by,$db_fields))
			{
				$this->ci_sql->db->order_by($sort_by, $sort_order);
			}
			else
			{
				$this->ci_sql->db->order_by('citations.title', $sort_order);
			}
		}

		//set Limit clause
		// @todo RRE CI 3.x Use DB helper
	  	// $this->ci_sql->db_sql->limit($limit, $offset);
	  	$this->ci_sql->db->limit($limit, $offset);

		// Query execution
        $query= $this->ci_sql->db->get();

		if (isset($query))
		{
			$result=$query->result_array();

			// get total search result count
			// $query_found_rows=$this->ci_sql->db->query('SELECT FOUND_ROWS() as rowcount',FALSE)->row_array();
			// $this->search_found_rows=$query_found_rows['rowcount'];
			/**
			 * @todo Row Count using PHP
			 *
			*/
			// $this->search_found_rows=count($query->all);
			// @todo Count if the Array Content should be the same value
			$this->search_found_rows=count($result);

			//find authors for citations
			foreach($result as $key=>$row)
			{
				$result[$key]['authors']=$this->get_citation_authors($row['id'],'author');
			}
			return $result;
		}

		return FALSE;
	}



  	/**
	*
	* Search on citation survey country
	*
	* return arrayy of citation IDs
	*
	* TODO: remove, no longer in use
 	**/
	function search_citation_by_country($keyword=NULL)
	{
		$this->ci_sql->db->select('citationid');
		$this->ci_sql->db->from('survey_citations');
		$this->ci_sql->db->join('surveys', 'survey_citations.sid = surveys.id','inner');
		$this->ci_sql->db->group_by('survey_citations.citationid');
		$this->ci_sql->db->like('surveys.nation',$keyword);
	        $query= $this->ci_sql->db->get();

		$output=array();

		if (isset($query))
		{
			$result=$query->result_array();

			foreach($result as $row)
			{
				$output[]=$row['citationid'];
			}
		}

		return $output;
	}




	function search_count()
	{
		return $this->search_found_rows;
	}


	function get_citation_authors($citationid,$type)
	{
		$this->ci_sql->db->select('*');
		$this->ci_sql->db->where('cid', $citationid);
		$this->ci_sql->db->where('author_type', $type);
		$query=$this->ci_sql->db->get("citation_authors");

		if(isset($query))
		{
			return $query->result_array();
		}
		return FALSE;
	}

}
// END Search class

/* End of file Citation_search_default.php */
/* Location: ./application/libraries/Citation_search_default.php */
