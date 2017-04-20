<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX core module class */
require dirname(__FILE__).'/Modules.php';

/**
 * Modular Extensions - HMVC
 *
 * Adapted from the CodeIgniter Core Classes
 * @link	http://codeigniter.com
 *
 * Description:
 * This library extends the CodeIgniter router class.
 *
 * Install this file as application/third_party/MX/Router.php
 *
 * @copyright	Copyright (c) 2015 Wiredesignz
 * @version 	5.5
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/
class MX_Router extends CI_Router
{
	public $module;
	private $located = 0;

	public function fetch_module()
	{
		return $this->module;
	}

	protected function _set_request($segments = array())
	{
		if ($this->translate_uri_dashes === TRUE)
		{
			foreach(range(0, 2) as $v)
			{
				isset($segments[$v]) && $segments[$v] = str_replace('-', '_', $segments[$v]);
			}
		}

		$segments = $this->locate($segments);

		if($this->located == -1)
		{

//  echo 'Here Override <br>';

			$this->_set_404override_controller();
			return;
		}

		if(empty($segments))
		{
// echo 'Empty segments <br>';

			$this->_set_default_controller();
			return;
		}

		$this->set_class($segments[0]);

		if (isset($segments[1]))
		{
// echo 'Segment 1  <br>';
			$this->set_method($segments[1]);
		}
		else
		{
// echo 'Segment 1 set to index <br>';
			$segments[1] = 'index';
		}

		array_unshift($segments, NULL);
		unset($segments[0]);
		$this->uri->rsegments = $segments;
	}

	protected function _set_404override_controller()
	{
		$this->_set_module_path($this->routes['404_override']);
	}

	protected function _set_default_controller()
	{
		if (empty($this->directory))
		{
			/* set the default controller module path */
			$this->_set_module_path($this->default_controller);
		}

		parent::_set_default_controller();

		if(empty($this->class))
		{

			$this->_set_404override_controller();
// echo 'override Controller <br>';

		}
	}

	/** Locate the controller **/
	// @todo Trace bug HMVC and CI 3.1.3 + RRE
	/*
		located -1
		located 0
		located 1
		located 2
		located 3
	*/
	public function locate($segments)
	{
		$this->directory = '';
		$this->located = 0;
		$ext = $this->config->item('controller_suffix').EXT;

//	echo $segments[0].' <- Initial segment <br>';

		/* use module route if available */
		if (isset($segments[0]) && $routes = Modules::parse_routes($segments[0], implode('/', $segments)))
		{
			$segments = $routes;

//	echo implode('/', $segments).' <- segments imploded<br>';

		}

		/* get the segments array elements */
		list($module, $directory, $controller) = array_pad($segments, 3, NULL);

		/* check modules */
		foreach (Modules::$locations as $location => $offset)
		{

//	echo $location.$module.'/controllers/ <- Test for Directory<br>';
//	echo $location.' <- in Location <br>';
//	echo $module.' <- in Module Directory Structure <br>';

			/* module exists? */
			if (is_dir($source = $location.$module.'/controllers/'))
			{
				$this->module = $module;
				$this->directory = $offset.$module.'/controllers/';

//	echo $source.' <- Source <br>';
//	echo $offset.' <- Offset <br>';
//	echo 'This Directory ->'.$this->directory.'<- <br>';
//	echo 'Directory ->'.$directory.'<-  <br>';

				/* module sub-controller exists? */
				if($directory)
				{

//	echo $source.$directory.'/ Test 1<br> ';

					/* module sub-directory exists? */
					if(is_dir($source.$directory.'/'))
					{
						$source .= $directory.'/';
						$this->directory .= $directory.'/';

						/* module sub-directory controller exists? */
						if($controller)
						{
							if(is_file($source.ucfirst($controller).$ext))
							{
								$this->located = 3;
								return array_slice($segments, 2);
							}
							else $this->located = -1;
						}
					}
					else
					if(is_file($source.ucfirst($directory).$ext))
					{
//	echo $source.ucfirst($directory).$ext.' File ucfirst <br>';
						$this->located = 2;
						return array_slice($segments, 1);
					}
					else $this->located = -1;
				}


//	echo $this->located.' Located <br>';
//	echo $source.ucfirst($module).$ext.' <- Module Test2 ucfirst <br>';

				/* module controller exists? */
				if(is_file($source.ucfirst($module).$ext))
				{
					$this->located = 1;
					return $segments;
				}
			}

		}

//	echo $directory.'  <- $ Directory variable <br>';
//	echo $this->directory.' <- This Directory value <br>';
//	echo $this->located.' Test for Located <br>';

		// @todo RRE Test again into application/controllers Path in case of Located -1.
		/*
			Define PRIORITY in case of DUPLICITY in:
			application/controllers/<dir>/Class.php
			application/modules/<dir>/controllers/Class.php

			If directory structure exists in MODULES and the Calss.php only exists in
			application/controllers/<dir>/Class.php
			ERROR 404.

			This solved the problem with only ONE directory level TESTED.
		*/
		// if(! empty($this->directory)) return;
		if( (! empty($this->directory)) && $this->located > 0 )
		{
			return;
		}

//	echo '<br>';
//	echo $directory.' <- Processing directory <br>';
//	echo $this->directory.' <- Processing this->directory <br>';
//	echo '<br>';

		// @todo RRE Reset Located to 0
		$this->located = 0;
		if ( ! empty($this->directory) )
		{
			$this->directory = $directory;
		}

//	echo '<br>';
//	echo $directory.' <- Reseted Processing directory <br>';
//	echo $this->directory.' <- Reseted Processing this->directory <br>';
//	echo '<br>';


		/* application sub-directory controller exists? */
		if($directory)
		{

//	echo APPPATH.'controllers/'.$module.'/'.ucfirst($directory).$ext.' <- Should be <br>';

			if(is_file(APPPATH.'controllers/'.$module.'/'.ucfirst($directory).$ext))
			{
				$this->directory = $module.'/';

//	echo $this->directory.' <- This Directory Test 2<br>';
//	echo array_slice($segments,1)[0].' <- Slice segment 1 <br>';

				return array_slice($segments, 1);
			}

			/* application sub-sub-directory controller exists? */
			if($controller)
			{
				if(is_file(APPPATH.'controllers/'.$module.'/'.$directory.'/'.ucfirst($controller).$ext))
				{
					$this->directory = $module.'/'.$directory.'/';
					return array_slice($segments, 2);
				}
			}
		}

//	echo APPPATH.'controllers/'.$module.'/ <- Test as a Controller Subdirectory <br>';

		/* application controllers sub-directory exists? */
		if (is_dir(APPPATH.'controllers/'.$module.'/'))
		{

//	echo '<br>';
//	echo $this->directory.' <- Returning this->directory <br>';
//	echo $this->located.' <- Returning Located Status <br>';
//	echo '<br>';

			$this->directory = $module.'/';
			return array_slice($segments, 1);
		}

//	echo APPPATH.'controllers/'.ucfirst($module).$ext.' <- Test as a Controller Class <br>';

		/* application controller exists? */
		if (is_file(APPPATH.'controllers/'.ucfirst($module).$ext))
		{

//	echo '<br>';
//	echo $this->directory.' <- Returning this->directory <br>';
//	echo $this->located.' <- Returning Located Status <br>';
//	echo $segments[0].' <- Final segment <br>';
//	echo '<br>';

			return $segments;
		}

		$this->located = -1;
	}

	/* set module path */
	protected function _set_module_path(&$_route)
	{
		if ( ! empty($_route))
		{
			// Are module/directory/controller/method segments being specified?
			$sgs = sscanf($_route, '%[^/]/%[^/]/%[^/]/%s', $module, $directory, $class, $method);

			// set the module/controller directory location if found
			if ($this->locate(array($module, $directory, $class)))
			{
				//reset to class/method
				switch ($sgs)
				{
					case 1:	$_route = $module.'/index';
						break;
					case 2: $_route = ($this->located < 2) ? $module.'/'.$directory : $directory.'/index';
						break;
					case 3: $_route = ($this->located == 2) ? $directory.'/'.$class : $class.'/index';
						break;
					case 4: $_route = ($this->located == 3) ? $class.'/'.$method : $method.'/index';
						break;
				}
			}
		}
	}

	public function set_class($class)
	{
		$suffix = $this->config->item('controller_suffix');
		if (strpos($class, $suffix) === FALSE)
		{
			$class .= $suffix;
		}
		parent::set_class($class);
	}
}
