<?php
defined('_JEXEC') or die('Direct access is not allowed');

require_once JPATH_SITE.'/components/com_content/helpers/route.php';

JModelLegacy::addIncludePath(JPATH_SITE.'/components/com_content/models', 'ContentModel');

abstract class modFeaturedImagesHelper {
    public static function randomCategoryArticlesImages(&$params) {
        $db = JFactory::getDbo();

        $items = $params->get('catid');
        $item = $items[rand(0,count($items) -1)];


        $model = JModelLegacy::getInstance('Articles', 'ContentModel', array('ignore_request' => true));

        $app = JFactory::getApplication();
        $appParams = $app->getParams();

        $model->setState('params', $appParams);
        $model->setState('list.select', 'a.id, a.fulltext, a.images, a.title, a.alias');
        $model->setState('filter.category_id', $item);
        $model->setState('filter.published', 1);

        $articles = $model->getItems();
        
        $imgs = [];

        foreach($articles as $article) {
            $block = [];
            $text = $article->fulltext;
            $title = $article->title;
            $id = $article->id;
            $imageIntro = json_decode($article->images)->image_intro;

            preg_match_all('#(<img.*?>)#', $text, $match, PREG_SET_ORDER); 
            $imgLimit = array_slice($match, 0 , $params->get('imgLimit'));

            $article->slug = $article->id.':'.$article->alias;
            $article->catslug = $item.':'.$article->category_alias;

            $article->link = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug));

            $block['article-title'] = $title;
            $block['article-cat-url'] = $article->link;
            $block['article-imgs'] = $imgLimit;
            $block['image-intro'] = $imageIntro;

            array_push($imgs, $block);
        };
        return $imgs;

    }
}

?>
