<?php
/*
 * @package     Jokte.Site
 * @subpackage  FeaturedImages.Module
 * @author      Fabian Hernández - Equipo de desarrollo Juuntos
 * @copyleft    (comparte igual) Jokte! CMS
 * @license     GNU General Public License versión 3 o superior
 */

// Previene el acceso directo al archivo
defined('_JEXEC') or die();

require_once (dirname(__FILE__).DS.'helper.php');

$randomCategoryArticlesImgs = modFeaturedImagesHelper::randomCategoryArticlesImages($params);

require JModuleHelper::getLayoutPath('mod_featured_images', $params->get('layout', 'default'));
?>
