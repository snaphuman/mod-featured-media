# Módulo multimedia destacada

> Una forma simple de obtener las imágenes y embeds de tus artículos, organizarlos y presentarlos como galería multimedia en cualquier posición y página de tu sitio

Este módulo escanea los textos de los artículos de las categorías seleccionadas desde el backend de administración, agrupando todos los elementos multimedia como imágenes y videos provenientes de los servicios de Youtube y Vimeo.
Cada elemento multimedia genera una imágen miniatura que es utilizada en la presentación del módulo en forma de galería.

El usuario en el Front End podrá seleccionar la miniatura para mostrar la imágen en forma de popup, si el elemento seleccionado es un video este se mostrará iguamente en forma de popup. Dentro de esta visualización se podrá acceder al artículo donde se encuentra originalmente el elemento multimedia.

El usuario administrador podrá manipular la forma como estos elementos mutimedia presentados en el módulo ya que dispone de las siguientes opciones:

## Prerequisitos

* Jokte! CMS 1.x
* Joomla CMS 2.5.x

## Instalación

Utiliza el gestor de extensiones para instalar el módulo

## Configuración

Las siguientes opciones están disponibles desde el backend de en la gestión del módulo

### Opciones básicas

#### Seleccionar la categoría

Esta opción permite seleccionar una o múltiples categorías, de las cuales se obtendrán los elementos __<img>__ o __<iframe>__ por acada artículo relacionado. La información mulrimedia que acá se obtiene, podrá ser organizada y presentada en diferentes formas como se describe a continuación.


### Opciones de visualización

#### Filtro de Categoría

* **Mostrar todos los artículos:** Reúne todos los elementos multimedia de todos los artículos de las categorías seleccionadas. Las imágenes miniatura son segmentadas por los titulos de los artículos
* **Mostrar artículo aleatorio:** Selecciona un artículo de forma aleatoria dentro de todos los artículos existentes en las categorías seleccionadas. Las imágenes miniatura varían al recargar la página que contiene el módulo.
* **Mostrar artículos destacados:** Muestra los elementos multimedia de los artículos que se encuenten destacados de las categorías seleccionadas. Las imágenes miniatura son agrupadas por artículos

#### Combinar resultados

Esta opción permitirá que las imágenes miniatura de múltiples artículos conformen un solo bloque, esta opción es útil cuando el fitro de categoría __mostrar todos__ o __mostrar destacados__ se encuentre habilitado.

#### Limitar resultados

Esta opción permite limitar el número de artículos por categoría y el número de elementos multimedia encontrados en cada artículo. Si la opción combinar resutados se encuentra habilitada, el número de imágenes miniatura total será el número de artículos por el número total de imágenes permitidas en cada uno.

#### Mostrar título, imágen introductoria, enlace a artículo o separados.

Estas cuatro opciones habilitan o deshabilitan la información útil que se desea presentar en el módulo

#### Tipo de multimedia

Estas opciones definen cuales elementos multimedia serán capturados del texto del artículo y presentados en el módulo. Es posible seleccionar entre los elementos HTML __<img>__ o __<iframe>__.
En el Caso de que el módulo encuentre un elemento __<iframe>__, se encargará de identificar a cual servicio de video pertenece __youtube__ o __vimeo__, para realizar la conexión a la API correspondiente y obtener la imágen miniatura del video e incluirla en la galería.

#### Opciones de diagramación

* **Número de columnas:** Permite seleccionar al usuario en cuantas columnas desea visualizar las imágenes miniatura de los elementos multimedia
* **Espaciado vertical y horizontal:** Separa las imágenes miniatura unas de las otras de acuerdo a los valores especificados. estos valores están en pixeles.
* **Altura relativa:** Este valor permite realizar los cálculos para adecuar una altura uniforme en los elementos de una fila y conservar la relación de aspecto de los elementos redimensionados. Esto permitirá tener un efecto collage para la galería al estilo de flickr :)

## Licencia

GPL v3
