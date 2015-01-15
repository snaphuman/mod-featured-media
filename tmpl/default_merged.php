<?php 
defined('_JEXEC') or die('Direct Access is not allowed');
?>

<style type="text/css">
* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}

.thumb-block {
  position: relative;
  -webkit-transform-origin: center center;
  -moz-transform-origin: center center;
  -ms-transform-origin: center center;
  -o-transform-origin: center center;
  transform-origin: center center;
}

.thumb-block.off-screen-top {
  -webkit-transform: translateY(-150px);
  -moz-transform: translateY(-150px);
  -ms-transform: translateY(-150px);
  -o-transform: translateY(-150px);
  transform: translateY(-150px);

}

.thumb-block.off-screen-bottom {
  -webkit-transform: translateY(150px);
  -moz-transform: translateY(150px);
  -ms-transform: translateY(150px);
  -o-transform: translateY(150px);
  transform: translateY(150px);

}
 
.come-in {

  -webkit-transform: translateY(0);
  -moz-transform: translateY(0);
  -ms-transform: translateY(0);
  -o-transform: translateY(0);
  transform: translateY(0);

  -webkit-transition: transform 0.8s ease-out;
  -moz-transition: transform 0.8s ease-out;
  -ms-transition: transform 0.8s ease-out;
  -o-transition: transform 0.8s ease-out;
  transition: transform 0.8s ease-out;

}
.come-in:nth-child(odd) {

  -webkit-transition-duration: 0.9s;
  -moz-transition-duration: 0.9s;
  -ms-transition-duration: 0.9s;
  -o-transition-duration: 0.9s;
  transition-duration: 0.9s;

}
.already-visible {

  -webkit-transform: translateY(0);
  -moz-transform: translateY(0);
  -ms-transform: translateY(0);
  -o-transform: translateY(0);
  transform: translateY(0);


  -webkit-transition: none;
  -moz-transition: none;
  -ms-transition: none;
  -o-transition: none;
  transition: none;

}

</style>
<!-- Markup para las imágenes combinadas desde el helper solo con los elementos media-->
<div class="media">
  <?php foreach ($items as $media) :?>
  <div class="thumb-block">
    <div class="thumb-inner">
      <?php if($media['type'] == 'iframe') $media['src'] = $media['data']['thumb_src']; ?>
      <a href="#" data-toggle="modal" data-target="#show-modal" role="button">
        <img class="thumb-img"
             src="<?php echo $media['src']?>" 
             alt="<?php echo $media['alt']?>" 
             data-link="<?php echo $media['data']['link'] ?>" 
             data-title="<?php echo $media['data']['title'] ?>" 
             data-type="<?php echo $media['type'] ?>" 
             data-id="<?php echo $media['data']['embed_id']?>" 
             data-provider="<?php echo $media['data']['provider'] ?>" 
             data-src="<?php echo $media['data']['src'] ?>"
             data-relative-height="<?php echo $styles['image_relative_height'] ?>"
             />
      </a>
    </div>
  </div>
  <?php endforeach; ?>
  
</div>

<script type="text/javascript">
// Gracias a las contribuciones y comentarios en este 
// post http://css-tricks.com/slide-in-as-you-scroll-down-boxes/
// específicamente al fork de @PawelGIX en http://codepen.io/PawelGIX/pen/kmhLl :)
(function($) {
    $.fn.offScreen = function(distance) {
      var $t = $(this),
      $w = $(window),
      viewTop = $w.scrollTop(),
      viewBottom = viewTop + $w.height(),
      _top = $t.offset().top - distance,
      _bottom = $t.offset().top + $t.height() + distance;
      
      return {
        top: _bottom <= viewTop,
        bottom: _top >= viewBottom
      }

    }
})(jQuery);

var win = $(window);
var thumbs = $('.thumb-block');

    thumbs.each(function(i,el) {
    var el = $(el);
    if (!el.offScreen(150).bottom) {
      el.addClass('already-visible');
    }
  });
    
win.on('scroll resize', function(event){
    thumbs.each(function(i, el) {
        var el = $(el);
        if (!el.offScreen(0).top && !el.offScreen(0).bottom) {
          el.removeClass('already-visible off-screen-top off-screen-bottom');
          el.addClass('come-in');
        } else {
          if(el.offScreen(0).top) {
            el.addClass('off-screen-top');
          }
          else if(el.offScreen(0).bottom){
            el.addClass('off-screen-bottom');
          }
        }
      });
   });

win.trigger('scroll');
        

$(window).load(function (){
        
        $('.media').coolGalleryDisplay();
      
      });
</script>
