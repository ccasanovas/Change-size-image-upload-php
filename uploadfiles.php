<?php 

function getExtension($str) {

	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	return $ext;
}

function resize_image($file, $width, $height) {
    list($w, $h) = getimagesize($file);
    /* calculo la nueva imagen manteniendo relación ancho/alto */
    $ratio = max($width/$w, $height/$h);
    $h = ceil($height / $ratio);
    $x = ($w - $width / $ratio) / 2;
    $w = ceil($width / $ratio);
    /* leo los datos binarios del archivo */
    $imgString = file_get_contents($file);
    /* creo la imagen de una cadena */
    $image = imagecreatefromstring($imgString);
    $tmp = imagecreatetruecolor($width, $height);
    imagecopyresampled($tmp, $image,
    0, 0,
    $x, 0,
    $width, $height,
    $w, $h);
    imagejpeg($tmp, $file, 100);
    return $file;
    /* limpio la memoria */
    imagedestroy($image);
    imagedestroy($tmp);
}



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
			// Si el tamaño es mayor o igual a Ejecutar función resize
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
				$resultado = move_uploaded_file(resize_image($_FILES["file$n"]["tmp_name"], 200, 100),$urlarchivo);
				//imagejpeg($tmp1,$filename1,100);
				echo "subida de imagen modificada";
			} 

			// Si el tamaño es distinto del declarado arriba en la variable $tamano

			else {

			

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
			$resultado = move_uploaded_file(($_FILES["file$n"]["tmp_name"], 200, 100),$urlarchivo);

			echo "subida de imagen sin modificar";



			}
		}
		
	

		
}





?>

