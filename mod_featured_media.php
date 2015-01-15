<?php
/*
 * @package     Jokte.Site
 * @subpackage  FeaturedMedia.Module
 * @author      Fabian Hernández - Equipo de desarrollo Juuntos
 * @copyleft    (comparte igual) Jokte! CMS
 * @license     GNU General Public License versión 3 o superior
 */

// Previene el acceso directo al archivo
defined('_JEXEC') or die();

require_once (dirname(__FILE__).DS.'helper.php');

$items = modFeaturedMediaHelper::displayCategoryArticlesMedia($params);

$styles = modFeaturedMediaHelper::displayCategoryArticlesStyles($params);

require JModuleHelper::getLayoutPath('mod_featured_Media', $params->get('layout', 'default'));
?>