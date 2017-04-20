# Apache configuration

## Javascript Alias directory

Apache has a configuration file javascript-common.conf.
In case this configaration is enabled, all the request to serve the files from any javascript directory will be served from:

/usr/share/javascript

## CodeIgniter configuration

CI has a configuration variable **'javascript_location'** set initially to the 'js' directory,
in case is not defined at the config.php file.
Called at system/libraries/Javascript.php

In this test the **javascript** pointed to a synlink **ihns_js** to test the application, in the application/config/config.php the definition was added:

```
$config['javascript_location']='ihns_js';
```


## Using Virtual directories

In case the application is configured to be served from a "Virtual Directory" and the application has in their directory path structure calls to "javascript" directory, we have two options:
*	Rename the application javascript directory, and change the files that call that directory.
*	Disable javascript-common.conf in Apache. This could lead to break other applications running in the same server.

@todo Update the app

* Rename the javascript directory, in this case to ihns_javascript.
* Define the CI configuration variable for javascript: 'javascript_location'. (CI Reference guide)
* Change the files which call javascript/ directory and change to the new path.
* Edit the files and change the calls not managed from CI

## Changing patterns

In the first effort to change the files searching the patterns **'javascript/** or **"javascript/** to be updated for **$this->config->item(\x27javascript_location\x27).**,
I didn't checked all the possible combinations listed below.


### Patterns in executing code

To change some patterns is necessary to use escaped codes like \x27 to produce the ' character or \/ to produce /.

**('javascript/** to **(\$this->config->item('javascript_location').'/** with pattern **(\$this->config->item(\x27javascript_location\x27).'\/**

**("javascript/** to **(\$this->config->item('javascript_location')."/** with pattern  **(\$this->config->item(\x27javascript_location\x27)."\/**

```php
<?php
$this->template->add_css('javascript/jquery/themes/base/ui.all.css');
$this->template->add_js("javascript/plupload/plupload.full.js")
```


### Patterns in static or template code

**href="javascript/**

**src="javascript/**

**/../javascript/** to src="<?php echo $this->config->item('javascript_location');?>

**'javascript/plupload/plupload.flash.swf'**

**'javascript/plupload/plupload.silverlight.xap'**


```html
<link rel="stylesheet" type="text/css" href="javascript/superfish/css/superfish.css" media="screen">
<script src="javascript/jquery-1.5.1.min.js">
src="<?php echo site_url(); ?>/../javascript/plupload/gears_init.js">
flash_swf_url : 'javascript/plupload/plupload.flash.swf'
silverlight_xap_url : 'javascript/plupload/plupload.silverlight.xap'
```

### Commands to find the patterns

To these command we excluded the **.git** and **system** directories to avoid possible changes to files not related with the app.
Exclude ** *.md ** and ** *.back ** files too.

These commands should be run at the first directory level of the app.

```

grep -r --exclude-dir={.git,system} --exclude=*.{md,back} 'href="javascript/' ./
grep -r --exclude-dir={.git,system} --exclude=*.{md,back} 'src="javascript/' ./
grep -r --exclude-dir={.git,system} --exclude=*.{md,back} "'javascript/plupload/plupload.flash.swf'" ./
grep -r --exclude-dir={.git,system} --exclude=*.{md,back} "'javascript/plupload/plupload.silverlight.xap'" ./
grep -r --exclude-dir={.git,system} --exclude=*.{md,back} '/\.\./javascript/' ./

grep -r --exclude-dir={.git,system} --exclude=*.{md,back} '("javascript\/' ./
grep -r --exclude-dir={.git,system} --exclude=*.{md,back} "('javascript\/" ./

```


### Commands to update files

NOTE: Script in revision. Not all the files were updated correctly initially, use the **xargs sed -r** option before the final run to review the changes.
NOTE: The order in the execution of the scripts could change the final result.
NOTE: Make a backup before run the sripts.

#### Examples

NOTE: Use **-rl** optins in the grep command to obtain the file name instead of all the lines that include the pattern.
NOTE: Use only the **-r**  option to review the changes, this option won't do any change in the file

- To change from **href="javascript/** to **href="<?php echo $this->config->item('javascript_location');?>/**
- To change from **src="javascript/** to **src="<?php echo $this->config->item('javascript_location');?>/**

```
grep -rl --exclude-dir={.git,system} --exclude=*.{md,back} '="javascript/' ./ | xargs sed -r 's#="javascript\/#="<?php echo \$this->config->item(\x27javascript_location\x27);?>\/#g'
```

- To change from **'javascript/plupload/plupload.flash.swf'** to **'<?php echo $this->config->item('javascript_location');?>/plupload/plupload.flash.swf'**
- To change from **'javascript/plupload/plupload.silverlight.xap'** to **'<?php echo $this->config->item('javascript_location');?>/plupload/plupload.silverlight.xap'**

```
grep -rl --exclude-dir={.git,system} --exclude=*.{md,back} "'javascript/plupload/plupload.flash.swf'" ./ | xargs sed -r 's#\x27javascript/plupload/plupload.flash.swf\x27#\x27<?php echo $this->config->item(\x27javascript_location\x27);?>/plupload/plupload.flash.swf\x27#g'
grep -rl --exclude-dir={.git,system} --exclude=*.{md,back} "'javascript/plupload/plupload.silverlight.xap'" ./ | xargs sed -r 's#\x27javascript/plupload/plupload.silverlight.xap\x27#\x27<?php echo $this->config->item(\x27javascript_location\x27);?>/plupload/plupload.silverlight.xap\x27#g'
```

- To change **/../javascript/** to **/../<?php echo $this->config->item('javascript_location'):?>/**
 
```
grep -rl --exclude-dir={.git,system} --exclude=*.{md,back} '/\.\./javascript/' ./ | xargs sed -r 's#/\.\./javascript/#/\.\./<?php echo \$this->config->item(\x27javascript_location\x27);?>/#g'
```


**NOTE:** These should be the **last** scripts to run.

Two options were found initially **"javascript/...." or 'javascript/.....'**, the pattern should be **("javascript/...." or '(javascript/.....'**, to change some of the files.
These commands change the original file and create a backup file adding the extension .back

```
grep -rl --exclude-dir={.git,system} --exclude=*.{md,back} '("javascript\/' ./ | xargs sed -ri.back 's/("javascript\/)/(\$this->config->item(\x27javascript_location\x27)."\//g'
grep -rl --exclude-dir={.git,system} --exclude=*.{md,back} "('javascript\/" ./ | xargs sed -ri.back "s/('javascript\/)/(\$this->config->item(\x27javascript_location\x27).'\//g"
```


#### Modified Files:
```
application/controllers/ddibrowser.php
application/controllers/catalog.php
application/controllers/access_licensed.php
application/controllers/admin/resources.php
application/controllers/admin/menu.php
application/controllers/admin/reports.php
application/controllers/admin/catalog.php
application/controllers/admin/licensed_requests.php
application/controllers/admin/citations.php

application/modules/datadeposit/controllers/datadeposit.php

application/modules/admin/controllers/datadeposit.php

```

### Direct html css style templates

```
application/modules/admin/views/datadeposit/plupload.php
application/modules/admin/views/datadeposit/summary.php
application/modules/admin/views/datadeposit/upload.php

application/views/catalog/surveys_list.php

application/modules/datadeposit/views/datadeposit/plupload.php
application/modules/datadeposit/views/datadeposit/summary.php
application/modules/datadeposit/views/datadeposit/upload.php
application/modules/datadeposit/views/plupload.php
application/modules/datadeposit/views/summary.php
application/modules/datadeposit/views/upload.php
application/modules/datadeposit/views/projects/plupload.php
application/modules/datadeposit/views/projects/upload.php

application/modules/datadeposit/themes/wb_intranet/layout.php
application/modules/datadeposit/themes/wb_intranet/blank.php

application/views/catalog/batch_file_upload.php
application/views/catalog/plupload.php

application/views/managefiles/plupload.php
application/views/resources/plupload.php


themes/admin/blue.php
themes/admin/admin.php
themes/admin/black.php

themes/admin20/index.php
themes/admin20/layout.php

themes/ddibrowser/layout.php
themes/ddibrowser/blank.php
themes/ddibrowser/box.php

themes/installer/layout.php
themes/installer/blank.php

themes/wb/blank_iframe.php
themes/wb/layout.php
themes/wb/blank.php

themes/wb2/blank.php
themes/wb2/layout.php

```
