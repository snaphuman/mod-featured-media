(function(b) {
    b.fn.coolGalleryDisplay = function() {
	return this.each(function () {  
	    console.log(this);
            // obtengo el ancho del área de la galería para calcular/corregir las proporciones de las imágens
            // garantizando que cada set de imagenes por línea ocupe el ancho total del área
            
            var galleryAreaWidth =  $(this).width()  
	    var	sumAllWidth = 0
            var imgSet = [];
            var row = 0;
            var rows = {};
            
            $.each($('.thumb-img'), function(){
		// dimensiones iniciales con base al alto relativo proporcionado por el usuario
		var img = $(this);
		var ar = this.naturalHeight / this.naturalWidth;
		var height = parseInt(img.data('relative-height'),10);
		var width = height * (1/ar);                   
                
		// Estas reglas se deben re-definir al final de toda la operación
		img.css({
                    'height': height + 'px',
                    'width': width + 'px'
                });
		
		if (sumAllWidth < galleryAreaWidth) {
		    sumAllWidth +=  img.width();
		    imgSet.push(img);
		} else { 
		    row++
		    sumAllWidth = img.width();
		    imgSet = [];
		    imgSet.push(img);
		}

		//console.log(imgSet)

		rows[row] = imgSet;
                
            });

            //console.log(rows);
            $.each(rows, function(i,row) {
		// Ajusto el tamaño de las imágenes distribuyendo el ancho del espacio faltante en la fila
		w = 0;
		m = 0;
		p = [];
		row.forEach(getImagesWidth);
		lW = ((galleryAreaWidth - w - m)/row.length) - 1;

		if(row.length > 1) row.forEach(addCorrectionWidth);

		// Envuelvo las filas en un elemento que las contenga para para futuras aplicaciones de efectos
		// a la galería
		//row.forEach(getImageParents);  		
		//$(p).wrapAll('<div class="thumb-row" />');



            });
            
            function addCorrectionWidth (el) {
		el.css({
                    'width': (el.width()+lW)+'px', 
                    'height': (el.height()+lW)+'px'
		});
            }
            
            function getImagesWidth (el) {
		w += el.width();
		mw = el.parents('.thumb-inner');
		m += parseInt(mw.css('margin-left'), 10) + parseInt(mw.css('margin-right'),10);
            }
            
            function getImageParents (el, index) {
		p[index] = el.parents('.thumb-block')[0];
	
            }

        });
    }
    b.fn.coolGalleryDisplay.defaults = {
    }
})(jQuery, this);
