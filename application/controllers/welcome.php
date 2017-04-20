<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * http://example.com/index.php/welcome
	 *	- or -
	 * http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

                   //get default home page
                   $default_home=$this->config->item('default_home_page');
                   $page_=$this->uri->segment(1);

		echo '*** segment 1 ->'.$this->uri->segment(1).'<-********<br>';
		echo '*** segment 2 ->'.$this->uri->segment(2).'<-********<br>';
		echo '***def home ->'.$default_home.'<-********<br>';

/*
//		if (!isset($page_))
		if (isset($page_))
		{
                                if (isset($default_home))
                                {
                                        //check if the page is a link or a static page
                                        $data=$this->Menu_model->get_page($default_home);

                                        if($data)
                                        {
						echo $default_home.' page found <br>';
						echo $data['linktype'].' linktype <br>';
                                                if ($data['linktype']!==0)
                                                {
                                                        //redirect to static page (found)
                                                        redirect($default_home);return;
                                                }
                                        }
                                        else
                                        {
                                                        //redirect
							echo $default_home.' page NOT found <br>';die;
                                                        redirect($default_home);return;
                                        }
                                }


		}
		else
		{
			$this->load->view('welcome_message');
		}

*/
echo 'Loaded from the CONTROLLERS directory <br>';
			$this->load->view('welcome_message');
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
