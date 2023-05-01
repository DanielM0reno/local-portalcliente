<?php

/*
 * Aticsoft S.L.
 */
class lib {

	static function upload_image ($files) {

		global $_install_path;
		
		$out = '';
		$info = pathinfo ($files ['name']);
		$extension = strtolower ($info ['extension']);
		
		if (in_array ($extension, array (
				'jpeg', 'jpg', 'gif', 'png' 
		))) {
			
			$image = false;
			
			if ($extension == 'jpeg' or $extension == 'jpg') {
				
				$image = imagecreatefromjpeg ($files ['tmp_name']);
			} elseif ($extension == 'png') {
				
				$image = imagecreatefrompng ($files ['tmp_name']);
			} elseif ($extension == 'gif') {
				
				$image = imagecreatefromgif ($files ['tmp_name']);
			}
			
			if ($image) {
				
				$max = 1280; // Máximo ancho o alto de la imagen
				$width = imagesx ($image);
				$height = imagesy ($image);
				
				if ($width > $max) {
					
					$height = round ($height * $max / $width);
					$width = $max;
				}
				
				if ($height > $max) {
					
					$width = round ($width * $max / $height);
					$height = $max;
				}
				
				$target = imagecreatetruecolor ($width, $height);
				imagecopyresampled ($target, $image, 0, 0, 0, 0, $width, $height, imagesx ($image), imagesy ($image));
				
				$outname = lib::get_filename () . '.' . $extension;
				$targetname = $_install_path . 'ficheros_sw/images/' . $outname;
				
				if ($extension == 'jpeg' or $extension == 'jpg') {
					
					$image = imagejpeg ($target, $targetname, 88);
				} elseif ($extension == 'png') {
					
					$image = imagepng ($target, $targetname, 9);
				} elseif ($extension == 'gif') {
					
					$image = imagegif ($target, $targetname);
				}
				
				imagedestroy ($image);
				imagedestroy ($target);
				
				if (is_file ($targetname)) {
					
					$out = $outname;
				}
			}
		}
		
		return $out;
	}

	static function get_filename () {

		return 'f' . time () . '-' . md5 (uniqid () . 'lcp0fC.-xS3"zaQ14Cd#Dc72');
	}

	/**
	 * Para internacionalización
	 *
	 * @param string $string
	 * @param boolean $escaped Si queremos devolver el string escapado para usar en html
	 * @return string Traducción
	 */
	static function d ($string, $escaped = true) {

		global $_lang;
		
		$out = isset ($_lang [$string]) ? $_lang [$string] : $string;
		
		return $escaped ? lib::htmlentities ($out) : $out;
	}

	static function date_convert ($fecha) {

		if (! $fecha)
			return '';
		
		$fecha = trim ($fecha);
		
		list ($date, $time) = explode (' ', $fecha);
		
		if ($date and $time) { // datetime
			list ($dia, $mes, $ano) = explode ('/', $date);
			
			if ($dia and $mes and $ano) {
				
				return ($ano . '-' . $mes . '-' . $dia . ' ' . $time);
			} else {
				
				list ($ano, $mes, $dia) = explode ('-', $date);
				
				return ($dia . '/' . $mes . '/' . $ano . ' ' . $time);
			}
		} else { // date
			list ($dia, $mes, $ano) = explode ('/', $fecha);
			
			if ($dia and $mes and $ano) {
				
				return ($ano . '-' . $mes . '-' . $dia);
			} else {
				
				list ($ano, $mes, $dia) = explode ('-', $fecha);
				
				return ($dia . '/' . $mes . '/' . $ano);
			}
		}
	}

	static function number_convert ($num, $decimales = 2) {

		return number_format (round ($num, $decimales), $decimales, ',', '.');
	}

	static function htmlentities ($string) {

		return htmlentities ($string, ENT_QUOTES, 'UTF-8');
	}

	/**
	 * Devuelve un código javascript que inicializa un datatables con consulta de datos
	 * en modo ajax.
	 * Como parámetros se le pasan el id de la tabla html que va a mostrar
	 * los datos, la url del php que retornara el json asíncrono con los datos y la url
	 * al fichero de traducción de idioma
	 *
	 * @param string $uniqid
	 * @param string $urlajax
	 * @param string $lang
	 * @return string
	 */
	static function init_datatables ($uniqid, $urlajax, $lang, $items = 30, $session_key = false) {

		?>
<script>

		var <?php echo $uniqid; ?> = null;
		f_queue.push(function(){
			
			<?php echo $uniqid; ?> = $("#<?php echo $uniqid; ?>").dataTable({
				"ajax": {
					"url": "<?php echo $urlajax; ?>",
					"type": "POST"
				},
				"searchDelay": 800,
				"lengthChange": false,
				"processing": true,
				"deferRender": true,
				"serverSide": true,
				"pageLength": <?php echo intval ( $items ); ?>,
				"language": {
				    "url": "<?php echo $lang; ?>"
				},
				"bSort": false,
				"paging": false,
				"searching": false,
				"info": false
				// Selector de páginas con select
				//"sPaginationType": "selectnumbers"
			})/*.on('draw.dt', function () {
				// Convertimos la tabla en responsive
				// Son necesarias el css pertinente para ocultar/mostrar filas dependiendo del tamaño del dispositivo
				var headers = $(this).children("thead").children("tr:first-child").children("th");				
				var text = '';
				var ncolumn = $(this).children("tbody").children("tr:first-child").children("td").length;
				var item = 0;
			    $(this).children("tbody").children("tr").each(function(){
				    text += '<tr class="responsive-tr">';
				    text += '<td colspan="' + ncolumn + '">';
				    item = 0;
				    $(this).children("td").each(function(){				    	
					    text += headers[item].innerHTML ? '<strong>' + headers[item].innerHTML + ':</strong>&nbsp;' : '';
					    text += $(this).html() + "<br/>";
					    item++;
				    });
				    text += '</td>';
				    text += '</tr>';				    
			    });
			    $(this).children("tbody").append(text);
			    $(this).children("thead").children("tr").children("th").children("i.tablesortingitem").remove();
			    $(this).children("thead").children("tr").children("th.sorting_asc").each(function(){
				    $(this).html('<i class="fa fa-angle-up tablesortingitem"></i>'+$(this).html());
			    });
			    $(this).children("thead").children("tr").children("th.sorting_desc").each(function(){
				    $(this).html('<i class="fa fa-angle-down tablesortingitem"></i>'+$(this).html());
			    });
			})*/;
		});
		</script>
<?php
	}
}