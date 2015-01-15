<?php
defined('_JEXEC') or die('Direct Access is not allowed');

$document =& JFactory::getDocument();
$document->addStylesheet(JURI::base() . 'modules/mod_featured_media/assets/css/mod_featured_media.css');

$alt_image_uri = JURI::root() . 'modules/mod_featured_media/assets/img';
?>
<style type="text/css">

.images-container {
  position: relative;
}

.preloader {
  display:block;
  position: absolute;
  background: #111111;
  width: 100%;
  height: 100%;
  z-index: 9999;
  text-align: center;
}

.media {
  margin: 0;
  padding: 0;
}

.media ul {
  list-style: none;
  margin: 0;
  padding: 0;
  text-decoration: none;
}

.media ul li {
  float: left;
}

.media .thumb-inner {
  margin: <?php echo $styles['item_margin'] ?>
}

.media .thumb-row {
  float: left;
}

.media .thumb-block {
  background: none;
  float: left;
}

.hover > .thumb-inner {
  background-color: #ffffff;
  background-position: 50% 50%;
  background-repeat: no-repeat;
}

.hover .thumb-img {
  opacity: 0.5;
}

</style>
<div id="mod-featured-imgs" class="images-container">
<div class="preloader"><img src="<?php echo $alt_image_uri . '/preload-black-bg.gif' ?>"/></div>

  <?php 
  if($params->get('display_media_as') == 'merge_results') { 
    require JModuleHelper::getLayoutPath('mod_featured_media', 'default_merged');
  } elseif($params->get('display_media_as') == 'only_intro_images') {
    require JModuleHelper::getLayoutPath('mod_featured_media', 'default_intro');
  } elseif($params->get('display_media_as') == 'separated_by_article') {
    require JModuleHelper::getLayoutPath('mod_featured_media', 'default_segmented');
   } ?>
</div>
<!-- Bootstrap Modal Markup -->
<div id="show-modal" class="modal hide white-box">
  <div class="modal-inner">
    <div class="modal-header">
      <div class="inner">
        <button type="button" class="close-custom" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Nombre del contenido multimedia</h3>
      </div>
    </div>
    <div class="modal-body">
      <div class="inner">
      </div>
    </div>
    <div class="modal-footer">
      <div class="inner">
      <a href="#" class="btn-custom" data-dismiss="modal">Cerrar</a>
      <a href="#" class="goto btn-custom btn-primary">Ampliar detalles</a>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo JURI::base() . 'modules/mod_featured_media/assets/js/jquery.coolgallerydisplay.js'; ?>"></script>

<script type="text/javascript">

$(window).load(function(){
    $('.preloader').fadeOut(2000);
});

(function(b) {
    b.fn.adjustModalToScreen = function(options) {

      var settings = $.extend({
          modalProportion: 80,
          contentType: null
        }, options);
      
      return this.each(function () {

          $(this).on('shown', function() {

              var 
              m = $(this),
              win = $(window),
              mIn   = $('.modal-inner'),
              mHead = $('.modal-header'),
              mBody = $('.modal-body'),
              mFoot = $('.modal-footer'),
              img   = m.find('img')[0],
              part  = settings.modalProportion,
              type  = settings.contentType;

              // Alto del modal con relación al alto máximo permitido
              mH = win.height() / (100/part);

              headHeight = mHead.outerHeight(true);
              footHeight = mFoot.outerHeight(true);
              bodyHeight = mH - (headHeight + footHeight);

              switch(type) {
                case "img" :
                aR = img.naturalHeight / img.naturalWidth;

                if(img.naturalHeight > mH) {
                  mBody.height(bodyHeight).width(bodyHeight*(1/aR));
                  $(img).css({
                      'text-align': 'center'
                    })
                } else {
                  mBody.height(img.naturalHeight).width(img.naturalWidth);
                  $(img).css({
                      'text-align': 'center'
                    })
                }
                break;
                
                case "iframe" :
                
                var 
                  ifr = m.find('iframe')[0];
                $(ifr).css({'height': bodyHeight, 'width': '100%', 'overflow': 'none'})
                ifrW = $(ifr).width();
                break;   
              }

              // Procedo a centrar el modal verticalmente
              mYPos = ((win.height() - m.outerHeight()) / 2);
                      
              // Procedo a centrar el modal horizontalmente
              mXPos = ((win.width() - m.outerWidth()) / 2); 
              
              // Asigno las nuevas posiciones al modal
              m.css({'top': mYPos, 'left': mXPos});


            });                 
        });
    }
    
  })(jQuery);

function showMedia (data) {
  var data = $(data);
  var modal = $("#show-modal");
  var title = modal.find('h3');
  var body = modal.find('.modal-body');
  var goto = modal.find('.goto');
  var type = data.data('type');
  title.text(data.data('title'));
  //console.log(data);
  goto.attr('href', data.data('link'));
  //console.log(goto);

  el = $("<" + type + ">", {src: data.data('src'), height: '100%', width:'100%'});
  el.css({'border':'none'});
  body.html(el);

  modal.adjustModalToScreen({
      contentType: type
    });

  console.log(el)

}

$('.thumb-block').on({
    click: function (event) {      
      target = $(event.target);
      showMedia (target);
    },
    mouseenter: function () {
      thumb = $(this);
      thumb.addClass('hover');
      type = thumb.find('img');
      
      if(type.data('type') == "img") {
        $('.thumb-inner').css({
            'background-image': "url(<?php echo $alt_image_uri . '/magnifying_glass_32x32.png'?>)",
            'position':'relative',
            'z-index':'999'
          
          }); 
      } else if(type.data('type') == "iframe") {
        $('.thumb-inner').css({
            'background-image': "url(<?php echo $alt_image_uri . '/play_alt_32x32.png'?>)"});
      }
    },
      mouseleave: function () {
      $('.thumb-block').removeClass('hover');
    }
  });

</script>
