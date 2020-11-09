<?php

$blog = ControladorBlog::ctrMostrarBlog();
$categorias = ControladorBlog::ctrMostrarCategorias(null , null);
$articulos = ControladorBlog::ctrMostrarConInnerJoin(0, 5, null, null);
$totalArticulos = ControladorBlog::ctrMostrarTotalArticulos(null, null);

$totalPaginas = ceil(count($totalArticulos) / 5);

?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php

	$validarRuta = "";

	if (isset($_GET["pagina"])) {

		$rutas = explode("/", $_GET["pagina"]);

		foreach ($categorias as $key => $value) {

			if ($rutas[0] == $value["ruta_categoria"] && !is_numeric($rutas[0])) {
				$validarRuta = "categorias";
				break;
			}
		}

		if (isset($rutas[1])) {
			if (is_numeric($rutas[1])) {
				foreach ($categorias as $key => $value) {
					$validarRuta = "categorias";
					break;
				}
			} else {
				foreach ($totalArticulos as $key => $value) {
					if ($rutas[1] == $value["ruta_articulo"] && !is_numeric($rutas[1])) {
						$validarRuta = "articulos";
						break;
					}
				}
			}
		}

		if ($validarRuta == "categorias") {

			echo '<title>' . $blog["titulo"] . ' | ' . $value["descripcion_categoria"] . '</title>

					<meta name="title" content="' . $value["titulo_categoria"] . '">
				
					<meta name="description" content="' . $value["titulo_categoria"] . '">';

			echo '
			<meta property="og:site_name" content="' . $value["titulo_categoria"] . '">
			<meta property="og:title" content="' . $value["titulo_categoria"] . '">
			<meta property="og:description" content="' . $value["descripcion_categoria"] . '">
			<meta property="og:type" content="Type">
			<meta property="og:image" content="' . $blog["dominio"] . $value["img_categoria"] . '">
			<meta property="og:url" content="' . $blog["dominio"] . $value["ruta_categoria"] . '">
			';

			$palabrasClaves =  json_decode($value["p_claves_categorias"], true);

			$p_claves = "";

			foreach ($palabrasClaves as $key => $value) {

				$p_claves .= $value . ", ";
			}

			$p_claves = substr($p_claves, 0, -2);

			echo '<meta name="keywords" content="' . $p_claves . '">';
		} else if ($validarRuta == "articulos") {

			echo '<title>' . $blog["titulo"] . ' | ' . $value["titulo_articulo"] . '</title>

					<meta name="title" content="' . $value["titulo_articulo"] . '">
				
					<meta name="description" content="' . $value["descripcion_articulo"] . '">';
			echo '
			<meta property="og:site_name" content="' . $value["titulo_articulo"] . '">
			<meta property="og:title" content="' . $value["titulo_articulo"] . '">
			<meta property="og:description" content="' . $value["descripcion_articulo"] . '">
			<meta property="og:type" content="Type">
			<meta property="og:image" content="' . $blog["dominio"] . $value["portada_articulo"] . '">
			<meta property="og:url" content="' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '">
			';

			$palabrasClaves =  json_decode($value["p_claves_articulo"], true);

			$p_claves = "";

			foreach ($palabrasClaves as $key => $value) {

				$p_claves .= $value . ", ";
			}

			$p_claves = substr($p_claves, 0, -2);

			echo '<meta name="keywords" content="' . $p_claves . '">';
		} else {
			echo '<title>' . $blog["titulo"] . '</title>

				<meta name="title" content="' . $blog["titulo"] . '">
			
				<meta name="description" content="' . $blog["titulo"] . '">';

			$palabrasClaves =  json_decode($blog["palabras_claves"], true);

			$p_claves = "";

			foreach ($palabrasClaves as $key => $value) {

				$p_claves .= $value . ", ";
			}

			$p_claves = substr($p_claves, 0, -2);

			echo '<meta name="keywords" content="' . $p_claves
				. '">';

			echo '
				<meta property="og:site_name" content="' . $blog["titulo"] . '">
				<meta property="og:title" content="' . $blog["titulo"] . '">
				<meta property="og:description" content="' . $blog["descripcion"] . '">
				<meta property="og:type" content="Type">
				<meta property="og:image" content="' . $blog["dominio"] . $blog["portadas"] . '">
				<meta property="og:url" content="' . $blog["dominio"] . '">
			';
		}
	} else {

		echo '<title>' . $blog["titulo"] . '</title>

			<meta name="title" content="' . $blog["titulo"] . '">
		
			<meta name="description" content="' . $blog["titulo"] . '">';

		$palabrasClaves =  json_decode($blog["palabras_claves"], true);

		$p_claves = "";

		foreach ($palabrasClaves as $key => $value) {

			$p_claves .= $value . ", ";
		}

		$p_claves = substr($p_claves, 0, -2);

		echo '<meta name="keywords" content="' . $p_claves .
			'">';

		echo '
		<meta property="og:site_name" content="' . $blog["titulo"] . '">
		<meta property="og:title" content="' . $blog["titulo"] . '">
		<meta property="og:description" content="' . $blog["descripcion"] . '">
		<meta property="og:type" content="Type">
		<meta property="og:image" content="' . $blog["dominio"] . $blog["portadas"] . '">
		<meta property="og:url" content="' . $blog["dominio"] . '">
		';
	}

	?>
	<link rel="icon" href="<?php echo $blog["dominio"]; ?>views/img/icono.jpg">

	<!--=====================================
	PLUGINS DE CSS
	======================================-->
	<!--Notie css-->
	<link rel="stylesheet" href="<?php echo $blog["dominio"]; ?>views/css/plugins/notie.min.css">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

	<link href="https://fonts.googleapis.com/css?family=Chewy|Open+Sans:300,400" rel="stylesheet">

	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.0/css/all.css" integrity="sha384-aOkxzJ5uQz7WBObEZcHvV5JvRW3TUc2rNPA7pe3AwnsUohiw1Vj2Rgx2KSOkF5+h" crossorigin="anonymous">

	<!-- JdSlider -->
	<!-- https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
	<link rel="stylesheet" href="<?php echo $blog["dominio"]; ?>views/css/plugins/jquery.jdSlider.css">

	<link rel="stylesheet" href="<?php echo $blog["dominio"]; ?>views/css/style.css">

	<!--=====================================
	PLUGINS DE JS
	======================================-->

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

	<!-- JdSlider -->
	<!-- https://www.jqueryscript.net/slider/Carousel-Slideshow-jdSlider.html -->
	<script src="<?php echo $blog["dominio"]; ?>views/js/plugins/jquery.jdSlider-latest.js"></script>

	<!-- pagination -->
	<!-- http://josecebe.github.io/twbs-pagination/ -->
	<script src="<?php echo $blog["dominio"]; ?>views/js/plugins/pagination.min.js"></script>

	<!-- scrollup -->
	<!-- https://markgoodyear.com/labs/scrollup/ -->
	<!-- https://easings.net/es# -->
	<script src="<?php echo $blog["dominio"]; ?>views/js/plugins/scrollUP.js"></script>
	<script src="<?php echo $blog["dominio"]; ?>views/js/plugins/jquery.easing.js"></script>

	<!--
		Shape Share
	-->
	<script src="<?php echo $blog["dominio"]; ?>views/js/plugins/shape.share.js"></script>
	<!--Notie.js plugins-->
	<script src="<?php echo $blog["dominio"]; ?>views/js/plugins/notie.min.js"></script>

</head>

<body>

	<?php

	/*======================================
	Modulos Fijos Superiores
	=======================================*/

	include "pages/modulos/cabezera.php";
	include "pages/modulos/redes-sociales-moviles.php";
	include "pages/modulos/buscador-movil.php";
	include "pages/modulos/menu.php";

	/*======================================
	Navegar entre Paginas
	=======================================*/

	$validarRuta = "";

	if (isset($_GET["pagina"])) {

		/*======================================
		explode = las diagonales separan indices de array
		=======================================*/
		$rutas = explode("/", $_GET["pagina"]);

		if (is_numeric($rutas[0])) {

			$desde = ($rutas[0] - 1) * 5;

			$cantidad = 5;

			$articulos = ControladorBlog::ctrMostrarConInnerJoin($desde, $cantidad, null, null);
		} else {
			foreach ($categorias as $key => $value) {

				if ($rutas[0] == $value["ruta_categoria"]) {

					$validarRuta = "categorias";
					break;
				}
			}
		}
		/*======================================
		Indice[1]: Rutas de Articulos o la Paginación de Categorias
		=======================================*/
		if (isset($rutas[1])) {
			if (is_numeric($rutas[1])) {

				$desde = ($rutas[1] - 1) * 5;

				$cantidad = 5;

				$articulos = ControladorBlog::ctrMostrarConInnerJoin($desde, $cantidad, null, null);
			} else {
				foreach ($totalArticulos as $key => $value) {

					if ($rutas[1] == $value["ruta_articulo"]) {

						$validarRuta = "articulos";
						break;
					}
				}
			}
		}

		/*======================================
		Validar Las Rutas
		=======================================*/

		if ($validarRuta == "categorias") {
			include "pages/categorias.php";
		} else if ($validarRuta == 'articulos') {
			include "pages/articulos.php";
		} else if (is_numeric($rutas[0]) && $rutas[0] <= $totalPaginas) {
			include "pages/inicio.php";
		} else if (isset($rutas[1]) && is_numeric($rutas[1])) {
			include "pages/inicio.php";
		} else {
			include "pages/404.php";
		}
	} else {
		include "pages/inicio.php";
	}

	/*======================================
	Modulos Fijos Inferiores
	=======================================*/
	include "pages/modulos/footer.php";

	?>
	<input type="hidden" id="rutaActual" value="<?php echo $blog["dominio"] ?>">
	<script src="<?php echo $blog["dominio"]; ?>views/js/script.js"></script>


</body>

</html>