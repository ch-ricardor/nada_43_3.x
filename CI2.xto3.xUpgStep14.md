# CI 2.x to 3.x Upgrade Step 14

Find the files with the pattern *get_post(* and change it for *post_get(* , assuming that that was the expected behavior.

## Note:

As we don't know the specific design, not changing this function will probably alter the original functionality in case of the GET gets and response before the POST when the POST was intended to operate.

#### Examples

NOTE: Use **-rl** options in the grep command to obtain the file name instead of all the lines that include the pattern.
NOTE: Use only the **-r**  option to review the changes, this option won't do any change in the file

- To review change from **input->get_post(** to **input->post_get**

```
grep -rl --exclude-dir={.git,system} --exclude=*.{md,back} 'input->get_post(' ./ | xargs sed -r 's#input->get_post\(#input->post_get\(#g'
```
- To apply change from **input->get_post(** to **input->post_get** and create a backup file

```
grep -rl --exclude-dir={.git,system} --exclude=*.{md,back} 'input->get_post(' ./ | xargs sed -ri.back 's#input->get_post\(#input->post_get\(#g'
```

## Files Affected

```

./application/libraries/math_captcha.php
./application/libraries/image_captcha.php
./application/libraries/Data_access/drivers/Data_access_public.php
./application/views/access_licensed/request_confirmation.php
./application/views/resources/delete.php
./application/views/repositories/delete.php
./application/views/catalog/publish_confirm.php
./application/views/citations/todo_delete.php
./application/helpers/querystring_helper.php
./application/helpers/form_input_helper.php
./application/models/catalog_search_model.php
./application/controllers/access_public.php
./application/controllers/Catalog.php
./application/controllers/access_direct.php
./application/controllers/ddibrowser.php
./application/controllers/test/Users.php
./application/controllers/test/Catalog.php
./application/controllers/test/Menu.php
./application/controllers/test/Citations.php
./application/controllers/access_licensed.php
./application/controllers/Citations.php
./application/controllers/admin/resources.php
./application/controllers/admin/Licensed_requests.php
./application/controllers/admin/repository_sections.php
./application/controllers/admin/da_collections.php
./application/controllers/admin/translate.php
./application/controllers/admin/Vocabularies.php
./application/controllers/admin/Users.php
./application/controllers/admin/permissions.php
./application/controllers/admin/datafiles.php
./application/controllers/admin/Logs.php
./application/controllers/admin/Catalog.php
./application/controllers/admin/user_groups.php
./application/controllers/admin/Repositories.php
./application/controllers/admin/Menu.php
./application/controllers/admin/terms.php
./application/controllers/admin/Managefiles.php
./application/controllers/admin/Citations.php
./application/core/MY_Controller.php
```
