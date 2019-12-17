<?php 

function getExtension($str) {

	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

/**
 * Opens new image
 *
 * @param $filename
 */
function icreate($filename)
{
  $isize = getimagesize($filename);
  if ($isize['mime']=='image/jpeg')
    return imagecreatefromjpeg($filename);
  elseif ($isize['mime']=='image/png')
    return imagecreatefrompng($filename);
  /* Add as many formats as you can */
}

/**
 * Resize image maintaining aspect ratio, occuping
 * as much as possible with width and height inside
 * params.
 *
 * @param $image
 * @param $width
 * @param $height
 */
function resizeMax($image, $width, $height)
{
  /* Original dimensions */
  $origw = imagesx($image);
  $origh = imagesy($image);

  $ratiow = $width / $origw;
  $ratioh = $height / $origh;
  $ratio = min($ratioh, $ratiow);

  $neww = $origw * $ratio;
  $newh = $origh * $ratio;

  $new = imageCreateTrueColor($neww, $newh);

  imagecopyresampled($new, $image, 0, 0, 0, 0, $neww, $newh, $origw, $origh);
  return $new;
}

$imgh = icreate($_FILES["file$n"]["tmp_name"]);
$imgr = resizeMax($imgh, 400, 200);



$temp = explode(".", $_FILES["file1"]["name"]);
$extension = end($temp);

$Input =  $_FILES["file1"]["name"];

for ($n=1; $n<=1; $n++){
	
	$temp = explode(".", $_FILES["file$n"]["name"]);
	$extension = end($temp);
				
		if (($_FILES["file$n"]["error"] > 0))
		{
			echo "<script language='JavaScript'>alert('Error 113 cargando el archivo, intente nuevamente. Codigo 113');</script>";
		}
		else
		{		
			define ("MAX_SIZE","50000");
			$errors=0;
			if($_SERVER["REQUEST_METHOD"] == "POST")
			{
				echo 2;
				$image =$_FILES["file$n"]["name"];
				$uploadedfile = $_FILES['file$n']['tmp_name'];
			}
			//Si no hay errores registrados
			if(isset($_POST['Submit']) && !$errors)
			{
				echo "Imagen subida satisfactoriamente!";
			}
			$tamano = $_FILES["file$n"]["size"] / 1024;
			$nombrearchivo = utf8_decode($_FILES["file$n"]["name"]);				
			echo "<br>";
			// Si el tamaño es mayor o igual a Ejecutar acción
			if ($tamano >= "0" ){

				//Parámetros optimización, resolución máxima permitida
				$max_ancho = 1280;
				$max_alto = 900;



				echo "ext:".$extension;echo "<br>";echo "<br>";
				//$nombrearchivo = str_replace("%.$extension%", "", $nombrearchivo);
				$nombrearchivo = preg_replace("/\.[^.]+$/", "", $nombrearchivo);
				echo "nombre archivo:".$nombrearchivo;
				echo "<br>";echo "<br>";
				$nombrereal = $nombrearchivo.".".$extension;
				$nombrecolocar = uniqid();	
				$nombrecolocar = $nombrecolocar.".".$extension;
				$urlarchivo = "arch/".$nombrecolocar;				
				$filename1 = $urlarchivo;	
				$a = 1;
				$resultado = move_uploaded_file($_FILES["file$n"]["tmp_name"],$urlarchivo);
				//imagejpeg($tmp1,$filename1,100);
				
			} 

			// Si el tamaño es distinto del declarado arriba en la variable $tamano

			else {

			//Redimensionar
			$rtOriginal=$_FILES["file$n"]['tmp_name'];

			if($_FILES["file$n"]['type']=='image/jpeg'){
			$original = imagecreatefromjpeg($rtOriginal);
			}
			else if($_FILES["file$n"]['type']=='image/png'){
			$original = imagecreatefrompng($rtOriginal);
			}
			else if($_FILES["file$n"]['type']=='image/gif'){
			$original = imagecreatefromgif($rtOriginal);
			}

 
			list($ancho,$alto)=getimagesize($rtOriginal);

			$x_ratio = $max_ancho / $ancho;
			$y_ratio = $max_alto / $alto;


			if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
			    $ancho_final = $ancho;
			    $alto_final = $alto;
			}
			elseif (($x_ratio * $alto) < $max_alto){
			    $alto_final = ceil($x_ratio * $alto);
			    $ancho_final = $max_ancho;
			}
			else{
			    $ancho_final = ceil($y_ratio * $ancho);
			    $alto_final = $max_alto;
			}

			$lienzo=imagecreatetruecolor($ancho_final,$alto_final); 

			imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
			 
			//imagedestroy($original);
			 
			$cal=8;

			echo "ext:".$extension;echo "<br>";echo "<br>";
			//$nombrearchivo = str_replace("%.$extension%", "", $nombrearchivo);
			$nombrearchivo = preg_replace("/\.[^.]+$/", "", $nombrearchivo);
			echo "nombre archivo:".$nombrearchivo;
			echo "<br>";echo "<br>";
			$nombrereal = $nombrearchivo.".".$extension;
			$nombrecolocar = uniqid();	
			$nombrecolocar = $nombrecolocar.".".$extension;
			$urlarchivo = "arch/".$nombrecolocar;				
			$filename1 = $urlarchivo;	
			$a = 1;

			if($_FILES["file$n"]['type']=='image/jpeg'){
			imagejpeg($lienzo,"arch/".$nombrecolocar);
			move_uploaded_file($imgr,$urlarchivo);
			}
			else if($_FILES["file$n"]['type']=='image/png'){
			imagepng($lienzo,"arch/".$nombrecolocar);
			move_uploaded_file($imgr,$urlarchivo);
			}
			else if($_FILES["file$n"]['type']=='image/gif'){
			imagegif($lienzo,"arch/".$nombrecolocar);
			move_uploaded_file($imgr,$urlarchivo);
			}



			}
		}
		
	

		
}

echo "imagen subida correctamente";




?>

