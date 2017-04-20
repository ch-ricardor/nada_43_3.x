<?php
class Translate extends MY_Controller {
 
 	//base/template language
	var $base_lang='base';
	
 
    public function __construct()
    {
        parent::__construct();
		$this->template->set_template('admin');

		$this->lang->load("general");
		$this->load->library('translator');
		//$this->output->enable_profiler(TRUE);
    }
 
 	function index()
	{
		$data['title']='Translate';
		$data['languages']=$this->translator->get_languages_array();
		$content=$this->load->view("translator/index_admin",$data,true);
		
		$this->template->write('title', $data['title'],true);
		$this->template->write('content', $content,true);
	  	$this->template->render();	
	}
 
	function edit($language=NULL,$translation_file=NULL)
	{	
		if (!$language)
		{
			show_error("NO_LANGUAGE_SELECTED");
		}
	
		//check if language exists
		if (!$this->translator->language_exists($language))
		{
			show_error('INVALID_LANGUAGE');
		}
		
		
		$data['save_status']=NULL;
		
		if ($this->input->post('save'))
		{
			//save form
			$data['save_status']=$this->_save($language,$translation_file);
		}
		
		$data['title']='Translate';
		$data['active_lang_file']=$translation_file;
		$data['languages']=$this->translator->get_languages_array();
		$data['language']=$language;
		$data['rtl_languages']=array('arabic');
		$data['files']=$this->translator->get_language_files_array(APPPATH.'/language/base');
		
		//check if base translation file exists
		$data['template_file']=$this->translator->load($this->base_lang.'/'.$translation_file);				
		$data['edit_file']=$this->translator->load($language.'/'.$translation_file);
		
		if ($data['edit_file']===false)
		{
			$data['edit_file']=array();
		}
		
		$content=$this->load->view("translator/edit",$data,true);
		
		//set page options and render output
		$this->template->write('title', $data['title'],true);
		$this->template->write('content', $content,true);
	  	$this->template->render();
	}
	
	
	function _save($language,$translation_file)
	{
		if (!$this->input->post('save'))
		{
			return FALSE;
		}
		
		//save the file
		$output_file=APPPATH.'language/'.$language.'/'.$translation_file.'_lang.php';
		
		$data['language']=$language;
		$data['template_file']=$this->translator->load($this->base_lang.'/'.$translation_file);
		$data['fill_missing']=true;
		$data['language_file']=$translation_file;
		
		$post_data=array();
		
		//reload data from POST for language
		foreach($data['template_file'] as $key=>$value)
		{
			if ($this->input->post(md5($key)))
			{
				$post_data[$key]=$this->input->post(md5($key));
			}
		}				
		
		$data['edit_file']=$post_data;
		$output =$this->load->view('translator/preview',$data,TRUE);
		
		//make a backup copy of the existing file
		@copy($output_file,$output_file.'.bak');
		
		//save file
		$file_contents="<?php \n"; 
		$file_contents.=$output;
		$result=@file_put_contents($output_file, $file_contents);
		
		if (!$result)
		{
			return array(
					'type'=>'error',
					'msg'=>'Could not save file. '.$output_file,
					);
		}
		else
		{
			return array(
				'type'=>'success',
				'msg'=>'File has been saved. '.$output_file,
				);

		}	
	
	}
	
	function change_lang()
	{
		$lang=$this->input->post_get("lang");
		
		if ($lang)
		{
			redirect("admin/translate/edit/".$lang);exit;
		}
	}
	
	function download($language)
	{
		$this->translator->export($language);
	}
	
}
/* End of file translate.php */
/* Location: ./controllers/admin/translate.php */