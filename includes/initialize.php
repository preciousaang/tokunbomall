<?php


defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
define('INCLUDES', doc_root.'includes/');

//defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'practise'.DS.'photo_gallery');
//defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

require_once(INCLUDES."config.php");
require_once(INCLUDES."functions.php");
require_once(INCLUDES."session.php");
require_once(INCLUDES."database.php");
require_once(INCLUDES."database_object.php");
require_once(INCLUDES."image_resizer.php");
require_once(INCLUDES."pagination.php");
require_once(INCLUDES."user.php");
require_once(INCLUDES."categories.php");
require_once(INCLUDES."products.php");
require_once(INCLUDES."states.php");
require_once(INCLUDES."lgas.php");




?>