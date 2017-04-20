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

//decides which database search driver to load
$ci_catalog=& get_instance();
$driver=$ci_catalog->db->dbdriver;

switch($driver)
{
	case 'postgre';
		include dirname(__FILE__).'/catalog_search_postgre.php';
		break;
	case 'sqlsrv';
		include dirname(__FILE__).'/catalog_search_sqlsrv.php';
		return;
		break;
	case 'mysql';
		include dirname(__FILE__).'/catalog_search_mysql.php';
		return;
		break;
	// @todo review queries. Queries have different definitions
	case 'mysqli';
		include dirname(__FILE__).'/catalog_search_mysql.php';
		return;
		break;
	// @todo Define which Query is the MASTER query
	default:
		include dirname(__FILE__).'/catalog_search_sql.php';
		return;
		break;
		show_error(t('DB Driver not defined in catalog_search'));
		exit;
}

/* End of file Catalog_search.php */
/* Location: ./application/libraries/Catalog_search.php */
