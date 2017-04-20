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
 * @filesource
 */

// ------------------------------------------------------------------------


class Page extends MY_Controller {

    public function __construct()
    {

        parent::__construct($skip_auth=TRUE);
	$this->lang->load('general');
	//$this->output->enable_profiler(TRUE);

	//set template for print
	if ($this->input->get("print")==='yes')
	{
		$this->template->set_template('blank');
	}
    }

	function index()
	{

		if (in_array($this->uri->segment(1), array('page','pages')) )
		{
			if ($this->uri->segment(2)!='' )
			{
				//get page data
				$data=$this->Menu_model->get_page($this->uri->segment(2));
			}
			else
			{
				//this part will never get executed

				//get home page contente
				$data['title']='Home page';
				$data['body']='home page content here....';
			}
		}
		else
		{
			//get default home page
			$default_home=$this->config->item('default_home_page');
			$page_=$this->uri->segment(1);

			//show home page
			// if ($page_==false)
			// @todo CI 2.x to 3.x Step 10
			if (!isset($page_))
			{
				// @todo CI 2.x to 3.x Step 10
				// if ($default_home!==FALSE)
				if (isset($default_home))
				{
					//check if the page is a link or a static page
					$data=$this->Menu_model->get_page($default_home);

					if($data)
					{
						// Static page found redirect on linktype
						if ($data['linktype']!==0)
						{
							// redirect
							redirect($default_home);return;
						}
					}
					else
					{
						// redirect to default home page
						redirect($default_home);return;
					}
				}

				//no default home page set
				//get the page with minimum weight to be the home page
				$data=$this->Menu_model->get_page_by_min_weight();

				if ($data)
				{
					//link or page
					if ($data['linktype']!==0)
					{
						//link
						redirect($data['url']);
					}
				}
			}
			else //static pages in the database
			{
				$data=$this->Menu_model->get_page($page_);
/* RRE
echo $default_home.'<br>';
echo $page_.' <-looking for<br>';
echo $data.'****<br>';
die;
*/
			}
		}

		//page not found in the database

		if ( empty($data))
		{
			if ($this->static_page()===FALSE)
			{
				//show 404 page;
				$this->_error_page();
			}
			return;
		}
		else
		{
			if ($data['linktype']==1) //link
			{
				if ($this->static_page()!==FALSE)
				{
					return;
				}
			}
		}

		if (isset($data['css_links']) && trim($data['css_links'])!=='')
		{
			$css_arr=explode("\r",$data['css_links']);
			foreach($css_arr as $css)
			{
				$this->template->add_css(trim($css));
			}
		}

		if (isset($data['js_inline']) && trim($data['js_inline'])!=='')
		{
			$this->template->add_js($data['js_inline'],'embed');
		}

		if (isset($data['js_links']) && trim($data['js_links'])!=='')
		{
			$js_arr=explode("\r",$data['js_links']);
			foreach($js_arr as $js)
			{
				$this->template->add_js(trim($js));
			}
		}


		$content=$this->load->view('page_index', $data,true);
		$this->template->write('title', $data['title'],true);
		$this->template->write('content', $content,true);
	  	$this->template->render();
	}

	function user_bar()
	{
		$this->load->view('user_bar');
	}

	function switch_language($lang=NULL)
	{
		if ($lang==NULL)
		{
			show_404();
		}

		$valid_languages=$this->config->item("supported_languages");

		if (in_array($lang,$valid_languages))
		{
			//set language in the user session cookie
			$this->session->set_userdata('language',strtolower($lang));

			$destination=site_home();

			if ($this->input->get("destination"))
			{
				$destination=$this->input->get("destination");
			}
			redirect($destination);
		}
		else
		{
			show_error("Invalid Language selected!");
		}
	}



	function _error_page()
	{

		//check if url mapping is available for the url
		$uri=$this->uri->uri_string();

		$this->db->where("source",$uri);
		$result=$this->db->get("url_mappings")->row_array();

		if ($result)
		{
			$destination=$result["target"];
			redirect($destination);
			return;
		}

		header('HTTP/1.0 404 Not Found');
		$content=$this->load->view("404_page",NULL,TRUE);
		// $this->template->write('title', t('page not found'),true);
		// RRE -
		$this->template->write('title', t('page not found' . $uri ),true);
		$this->template->write('content', $content,true);
	  	$this->template->render();
	}

	function static_page()
	{

		$page=$this->uri->segment(1);
		$data=array();
		switch($page)
		{
			case 'home':
					$data['title']='Microdata Library Home';
					$this->load->model("repository_model");
					$this->lang->load('catalog_search');
					$this->load->model("stats_model");

					//get stats
					$data['title']='Microdata Home';
					$data['survey_count']=$this->stats_model->get_survey_count();
					$data['variable_count']=$this->stats_model->get_variable_count();
					$data['citation_count']=$this->stats_model->get_citation_count();

					//get top popular surveys
					$data['popular_surveys']=$this->stats_model->get_popular_surveys(5);

					//get top n recent acquisitions
					$data['latest_surveys']=$this->stats_model->get_latest_surveys(10);

					//reset any search options selected
					$this->session->unset_userdata('search');

					//reset repository
					$this->session->set_userdata('active_repository','central');

			break;

			default:
			return FALSE;
		}

		$data['body']=$this->load->view('./static/'.$page,$data,TRUE);
		$content=$this->load->view('page_index', $data,true);

		$this->template->write('title', $data['title'],true);
		$this->template->write('content', $content,true);
	  	$this->template->render();
	}
}
/* End of file page.php */
/* Location: ./controllers/page.php */
