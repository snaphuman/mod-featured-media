<?php
defined('_JEXEC') or die('Direct Access is not allowed');

$document =& JFactory::getDocument();
$document->addStylesheet(JURI::base() . 'modules/mod_featured_images/assets/css/mod_featured_images.css');
?>

<div id="mod-featured-imgs" class="images-container">
    <?php foreach ($randomCategoryArticlesImgs as $article) : ?>
        <div class="title-container">
            <div class="title-container-in">
                <div class="title-container-bg">
                </div>
                <div class="title-container-text">
                    <h4 class="title">
                        <?php echo $article['article-title'] ?>
                    </h4>
                </div>
            </div>
        </div>
        <div class="column pull-left">
            <?php if (!$article['image-intro']) : ?>
                <div class="image-thumb">
                    <img src="http://placehold.it/400x800" />
                </div>
            <?php else : ?>
                <div class="image-thumb">
                <img src="<?php echo $article['image-intro']?>" alt="<?php echo $article['article-title'] ?>" />
                </div>
            <?php endif; ?>
        </div>
        <div class="column pull-right">
            <?php foreach ($article['article-imgs'] as $img) : ?>
                <div class="image-thumb" >
                    <a href="<?php echo $article['article-cat-url'] ?>">
                        <?php echo $img[0]; ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <hr class="clearfix" />
    <?php endforeach; ?>
</div>
