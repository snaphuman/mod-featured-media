<?php 
defined('_JEXEC') or die('Direct Access is not allowed');
?>
<?php foreach ($items as $item) : ?>

<?php if($params->get('article_title')) : ?>
<div class="title-container">
  <div class="title-container-in">
    <div class="title-container-bg">
    </div>
    <div class="title-container-text">
      <h4 class="title">
        <?php echo $item['title'] ?>
      </h4>
    </div>
  </div>
</div>
<?php endif; ?>
<!-- TODO: Las siguientes opciones de markup se podrían reducir a una sola, revisar la estructura en el helper  -->
<!-- Markup para las imágenes segmentadas por artículos y posibilidad de agregar la imágen de intro en la vista -->
<div class="media">
  <?php if($params->get('show_image_intro') && !empty($item['image_intro'])) :?>
  <div class="thumb-block">
    <div class="thumb-inner">
      <a href="#" data-toggle="modal" data-target="#show-modal" role="button">
        <img class="thumb-img" 
             src="<?php echo $item['image_intro']?>" 
             data-type="img"
             data-src="<?php echo $item['image_intro'] ?>"
             data-relative-height="<?php echo $styles['image_relative_height'] ?>"
             />
      </a>
    </div>
  </div>
  <?php endif; ?>
  <?php foreach($item['media'] as $media) : ?>
  <div class="thumb-block">
    <div class="thumb-inner">
      <a href="#" data-toggle="modal" data-target="#show-modal" role="button">
        <?php if($media['type'] == 'iframe') $media['src'] = $media['data']['thumb_src']; ?>
        <img class="thumb-img" 
             src="<?php echo $media['src']?>" 
             alt="<?php echo $media['alt']?>" 
             data-link = "<?php echo $item['link'] ?>"
             data-title = "<?php echo $item['title'] ?>"
             data-type = "<?php echo $media['type'] ?>"
             data-src = "<?php echo $media['src'] ?>"
             data-relative-height="<?php echo $styles['image_relative_height'] ?>"
             />
      </a>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php if($params->get('horizontal_separator')) :?>
<hr class="clearfix" />
<?php endif; ?>
<?php endforeach; ?>
