<?php

// Previene el acceso directo a este archivo
defined('_JEXEC') or die();

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class modFeaturedMediaHelper {
  
  public static function displayCategoryArticlesStyles(&$params) {

    $hs = $params->get('horizontal_space');
    $vs = $params->get('vertical_space');

    $styles = array();
    $styles['item_margin'] = $hs.'px '.$vs.'px '.$hs.'px '.$vs.'px;';
    $styles['image_relative_height'] = $params->get('image_relative_height').'px;';

    return $styles;
  }

  public static function displayCategoryArticlesMedia(&$params) {
    $articles = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

    $app = JFactory::getApplication();
    $appParams = $app->getParams();
    $articles->setState('params', $appParams);

    $db = JFactory::getDbo();
    $cat_ids = $params->get('catid');

    $category_filter = $params->get('category_filter', 'use_all');
    switch ($category_filter) {
      case 'random' :
        $cat_id = $cat_ids[rand(0,count($cat_ids) -1)];
        $articles->setState('filter.category_id', $cat_id);
        break;
      case 'use_all' :
        //$cat_ids = array(JRequest::getInt('id'));
        $articles->setState('filter.category_id', $cat_ids);
        //var_dump($cat_ids);
        //var_dump($articles);
        break;
      case 'featured' :
        $articles->setState('filter.category_id', $cat_ids);
        $articles->setState('filter.featured', 'only');
        break;
    }

    $articles->setState('list.start', 0);
    $articles->setState('list.limit', (int) $params->get('article_limit', 0));
    $articles->setState('filter.published', 1);

    $articles->setState('list.select', 'a.id, a.title, a.introtext, a.fulltext, a.alias, a.images');

    $items = $articles->getItems();
 
    // Acá almacenaré todos los elementos multimedia que serán usados en la vista
    $media = array();

    foreach($items as &$item) {
      //var_dump($item);
      $data = array();
      $data['id']= $item->id;
      $data['text'] = $item->introtext . $item->fulltext;
      $data['title'] = $item->title;
      $slug = $item->id.':'.$item->alias;
      $catslug = $cat_ids[0].':'.$item->category_alias;
      $data['link'] = JRoute::_(ContentHelperRoute::getArticleRoute($slug, $catslug));
      $data['image_intro'] = json_decode($item->images)->image_intro;
      
      // Cargo el HTML que hace parte del texto completo del artículo.
      // de aqui saldran los elementos multimedia imagenes y videos
      $dom = new DomDocument();
      $dom->loadHTML($data['text']);


      $limit = $params->get('img_limit');
      $media_types = $params->get('media_types');
      $data['media'] = self::getMediaFromText($dom, $media_types, $limit);

      if (!empty($data['media']) || !empty($data['image_intro'])) array_push($media, $data);
    }
    
    if ($params->get('display_media_as') == 'merge_results') {

      $merged = array();
      foreach($media as $item) {
        foreach($item['media'] as $el) {
          $el['data']['title'] = $item['title'];
          $el['data']['link'] = $item['link'];
          $el['data']['src'] = $el['src'];
          array_push($merged,$el);  
        }
      }

      return $merged;

    } elseif($params->get('display_media_as') == 'only_intro_images') {

      $intro = array();
      foreach($media as $item) {
        $tmp = array();
        $tmp['title'] = $item['title'];
        $tmp['link'] = $item['link'];
        $tmp['image_intro'] = $item['image_intro'];        
        array_push($intro, $tmp);
      }

      return $intro;
      
    } elseif ($params->get('display_media_as') == 'separated_by_article') {

      return $media;
    }
  }

  private function getMediaFromText ($text, $types, $limit = 0) {
    $elements = array();
    
    foreach ($types as $type) {
      $element = array();
      
      $tags = $text->getElementsByTagName($type);
      
      if(!empty($tags->length)) {
        foreach($tags as $tag) {
          $element['type'] = $type;
          $element['src'] = $tag->getAttribute('src');        
          
          if($type == "iframe") {
            $element['data'] = self::getEmbedApiData($element['src']);
          } elseif ($type == "img") {
            $element['alt'] = $tag->getAttribute('alt') ? $tag->getAttribute('alt') : "";
            $element['data'] = self::getImageRandomId(100000,999999);
          }
          array_push($elements, $element);
        } 
      } 
    }
        
    return array_slice($elements, 0, $limit);
  }

  private function getImageRandomId($min, $max) {
    $img_data = array();
    $img_data['embed_id'] = mt_rand($min, $max);
    
    return $img_data;
  }

  private function getEmbedApiData($url) {
    $parsed_url = parse_url($url);
    $scheme = $parsed_url['scheme'];
    $host = $parsed_url['host'];
    $path = $parsed_url['path'];

    $exploded_host = explode('.', $host);
    $exploded_path = explode('/', $path);

    $api_data = array();
    $api_data['provider'] = $exploded_host[1];
    $api_data['embed_id'] = $exploded_path[2];
    
    if ($api_data['provider'] == 'youtube') { 
      $api_data['thumb_src'] = "http://img.youtube.com/vi/" . $api_data['embed_id']."/hqdefault.jpg";
    } elseif ($api_data['provider'] == 'vimeo') {

      // Tomado de los ejemplos de la API De Vimeo: 
      // https://github.com/vimeo/vimeo-api-examples/blob/master/oembed/php-example.php
      // y un pequeño ajuste al usar la opción follow location de curl.
      
      $oembed_endpoint = 'http://vimeo.com/api/oembed';
      $video_url = ($_GET['url']) ? $_GET['url'] : 'http://vimeo.com/'.$api_data['embed_id']; 
      $json_url =  $oembed_endpoint . '.json?url='. rawurlencode($video_url).'&width=640';
      
      $api_request = json_decode(self::requestFromVimeo($json_url), true);

      $api_data['thumb_src'] = $api_request['thumbnail_url'];
    }
    return $api_data;
  }
 
  private function requestFromVimeo($json_url) {
    $curl = curl_init($json_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);

    $base_dir = ini_get('open_basedir');

    if(empty($base_dir)) {
      curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    }

    $response = curl_exec($curl);
    curl_close($curl);
    
    return $response;
  }
}
  
?>
