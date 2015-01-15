<?Php 
// Acceso directo a este archivo no permitido
defined('_JEXEC') or die();
 ?>
<!-- Markup para las imágenes introductorias de los artículos de las categorías seleccionadas -->
<div class="media">
  <?php foreach ($items as $item) :?>
  <div class="thumb-block" title="<?php echo $item['title'] ?>">
    <div class="thumb-inner">
      <a href="<?php echo $item['link']?>" >
        <img
             class="thumb-img" 
             src="<?php echo $item['image_intro'] ?>" 
             data-relative-height="<?php echo $styles['image_relative_height'] ?>"

             />
      </a>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<script>
$(window).load(function (){
    $('.media').coolGalleryDisplay();      

  });


</script>