<?
//Cron Add
if(!(defined("CHK_EVENT") && CHK_EVENT===true))
   define("BX_CRONTAB_SUPPORT", true);
define("BX_USE_MYSQLI", true);
define("DBPersistent", false);
define('BX_CRONTAB_SUPPORT', true);
$DBType = "mysql";
$DBHost = "localhost";
$DBLogin = "cw83857_3bjttc3";
$DBPassword = "HFtF7AbkHivKX";
$DBName = "cw83857_3bjttc3";
$DBDebug = false;
$DBDebugToFile = false;

define("DELAY_DB_CONNECT", true);
define("CACHED_b_file", 3600);
define("CACHED_b_file_bucket_size", 10);
define("CACHED_b_lang", 3600);
define("CACHED_b_option", 3600);
define("CACHED_b_lang_domain", 3600);
define("CACHED_b_site_template", 3600);
define("CACHED_b_event", 3600);
define("CACHED_b_agent", 3660);
define("CACHED_menu", 3600);

define("BX_FILE_PERMISSIONS", 0644);
define("BX_DIR_PERMISSIONS", 0755);
@umask(~(BX_FILE_PERMISSIONS|BX_DIR_PERMISSIONS)&0777);

define("BX_DISABLE_INDEX_PAGE", true);
//define("BX_CATALOG_IMPORT_1C_PRESERVE", true);

define("BX_UTF", true);
mb_internal_encoding("UTF-8");

define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/log.txt");

//$_SERVER["REMOTE_ADDR"] = $_SERVER['HTTP_CF_CONNECTING_IP'];
?>
