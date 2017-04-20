<?php
header('Cache-Control: no-store, no-cache, must-revalidate, private');
//header('Cache-Control: no-cache="set-cookie"');
header ("Pragma: no-cache"); 
header("Expires: -1");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo js_base_url(); ?>">
<link rel="stylesheet" type="text/css" href="themes/<?php echo $this->template->theme();?>/reset-fonts-grids.css" />
<link rel="stylesheet" type="text/css" href="themes/<?php echo $this->template->theme();?>/styles.css" />
<link rel="stylesheet" type="text/css" href="themes/<?php echo $this->template->theme();?>/forms.css" />

<script type="text/javascript" src="<?php echo $this->config->item('javascript_location');?>/jquery.js"></script>

<?php
	//detect if we are on the secure pages
	$site_url=site_url();
	if ($this->uri->segment(1)=='auth')
	{
				$site_url= str_replace("http:","https:",site_url());
	}

	$site_url= site_url();
?>

<script type="text/javascript">
   var CI = {'base_url': '<?php echo $site_url; ?>'}; 
</script> 

<?php if (isset($_styles) ){ echo $_styles;} ?>
<?php if (isset($_scripts) ){ echo $_scripts;} ?>

<style type="text/css">
	body,html{background-color:white !important ;padding:0px;margin:10px;text-align:left;font-family:Arial, Helvetica, sans-serif}
</style>
</head>
<body>
    <div>
        <?php if (isset($content) ):?>
            <?php print $content; ?>
        <?php endif;?>
    </div>
<?php //@include_once(APPPATH.'/../tracking.php');?>
</body>
</html>
