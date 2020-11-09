<?php
if (isset($rutas[1])) {
	$articulo = ControladorBlog::ctrMostrarConInnerJoin(0, 1, "ruta_articulo", $rutas[1]);
	$totalArticulos = ControladorBlog::ctrMostrarTotalArticulos("id_cat", $articulo[0]["id_cat"]);
	$opiniones = ControladorBlog::ctrMostrarOpiniones("id_art", $articulo[0]["id_articulo"]);

	$actualizarVistaArticulo = ControladorBlog::ctrActualizarVista($rutas[1]);

}
/*======================================
Función Limitar foreach
=======================================*/
function limitarForeach($array, $limite)
{
	foreach ($array as $key => $value) {
		if (!$limite--) break;
		yield $key => $value;
	}
}
?>
<!--=====================================
CONTENIDO ARTÍCULO
======================================-->

<div class="container-fluid bg-white contenidoInicio py-2 py-md-4">

	<div class="container">

		<!-- BREADCRUMB -->

		<a href="categorias.html">

			<button class="d-block d-sm-none btn btn-info btn-sm mb-2">

				REGRESAR

			</button>

		</a>

		<ul class="breadcrumb bg-white p-0 mb-2 mb-md-4 breadArticulo">

			<li class="breadcrumb-item inicio"><a href="<?php echo $blog["dominio"]; ?>">Inicio</a></li>

			<li class="breadcrumb-item"><a href="<?php echo $blog["dominio"] . $articulo[0]["ruta_categoria"]; ?>"><?php echo $articulo[0]["descripcion_categoria"]; ?></a></li>

			<li class="breadcrumb-item active"><?php echo $articulo[0]["titulo_articulo"]; ?></li>

		</ul>

		<div class="row">

			<!-- COLUMNA IZQUIERDA -->

			<div class="col-12 col-md-8 col-lg-9 p-0 pr-lg-5">

				<!-- ARTÍCULO 01 -->

				<div class="container">

					<div class="d-flex">

						<div class="fechaArticulo"><?php echo $articulo[0]["fecha_articulo"]; ?></div>

						<h3 class="tituloArticulo text-right text-muted pl-3 pt-lg-2"><?php echo $articulo[0]["titulo_articulo"]; ?></h3>

					</div>

					<?php
					echo $articulo[0]["contenido_articulo"];
					?>

					<!-- COMPARTIR EN REDES -->

					<div class="float-right my-3 btnCompartir">

						<div class="btn-group text-secondary">

							Si te gustó compártelo:

						</div>

						<div class="btn-group">

							<button type="button" class="btn border-0 text-white social-share" style="background: #1475E0" data-share="facebook">

								<span class="fab fa-facebook pr-1"></span>

								Facebook

							</button>

						</div>

						<div class="btn-group">

							<button type="button" class="btn border-0 text-white social-share" style="background: #00A6FF" data-share="twitter">

								<span class="fab fa-twitter pr-1"></span>

								Twitter

							</button>

						</div>

					</div>

					<div class="clearfix"></div>

					<!-- ETIQUETAS -->

					<div>

						<h4>Etiquetas</h4>

						<a href="#suramerica" class="btn btn-secondary btn-sm m-1">suramerica</a>

						<a href="#colombia" class="btn btn-secondary btn-sm m-1">colombia</a>

						<a href="#peru" class="btn btn-secondary btn-sm m-1">peru</a>

						<a href="#argentina" class="btn btn-secondary btn-sm m-1">argentina</a>

						<a href="#chile" class="btn btn-secondary btn-sm m-1">chile</a>

						<a href="#brasil" class="btn btn-secondary btn-sm m-1">brasil</a>

						<a href="#ecuador" class="btn btn-secondary btn-sm m-1">ecuador</a>

						<a href="#venezuela" class="btn btn-secondary btn-sm m-1">venezuela</a>

						<a href="#paraguay" class="btn btn-secondary btn-sm m-1">paraguay</a>

						<a href="#uruguay" class="btn btn-secondary btn-sm m-1">uruguay</a>

						<a href="#bolivia" class="btn btn-secondary btn-sm m-1">bolivia</a>

					</div>

					<!-- AVANZAR - RETROCEDER -->

					<?php
					foreach ($totalArticulos as $key => $value) {
						if ($articulo[0]["id_articulo"] == $value["id_articulo"]) {
							$posicion = $key;
						}
					}
					?>

					<div class="d-md-flex justify-content-between my-3 d-none">
						<?php if (($posicion - 1) > 0) : ?>
							<a href="<?php echo $blog["dominio"] . $articulo[0]["ruta_categoria"] . '/' . $totalArticulos[($posicion - 1)]["ruta_articulo"] ?>">Leer artículo anterior</a>
						<?php endif ?>

						<?php if (($posicion + 1) < count($totalArticulos)) : ?>
							<a href="<?php echo $blog["dominio"] . $articulo[0]["ruta_categoria"] . '/' . $totalArticulos[($posicion + 1)]["ruta_articulo"] ?>">Leer artículo siguiente</a>
						<?php endif ?>

					</div>

					<!-- DESLIZADOR DE ARTÍCULOS -->

					<section class="jd-slider deslizadorArticulos my-4">

						<div class="slide-inner">

							<ul class="slide-area">

								<?php foreach ($totalArticulos as $key => $value) : ?>
									<li class="px-3">

										<a href="<?php echo $blog["dominio"] . $articulo[0]["ruta_categoria"] . '/' . $value["ruta_articulo"]; ?>" class="text-secondary">

											<img src="<?php echo $blog["dominio"] . $value["portada_articulo"]; ?>" alt="Lorem ipsum dolor sit amet" class="img-fluid">

											<h6 class="py-2"><?php echo $value["titulo_articulo"]; ?></h6>

										</a>

										<p class="small"><?php echo substr($value["descripcion_articulo"], 0. - 100) . "..."; ?></p>

									</li>
								<?php endforeach ?>

							</ul>

							<a class="prev" href="#">

								<i class="fas fa-angle-left text-muted"></i>

							</a>

							<a class="next" href="#">

								<i class="fas fa-angle-right text-muted"></i>

							</a>

						</div>

						<div class="controller">

							<div class="indicate-area"></div>

						</div>

					</section>

					<!-- BLOQUE DE OPINIONES -->

					<h3 style="color:#8e4876">Opiniones</h3>

					<hr style="border: 1px solid #79FF39">

					<div class="row opiniones">

						<?php if (count($opiniones) != 0) : ?>

							<?php foreach ($opiniones as $key => $value) : ?>

								<?php if ($value["aprobacion_opinion"] == 1) : ?>

									<div class="col-3 col-sm-4 col-lg-2 p-2">

										<img src="<?php echo $blog["dominio"] . $value["foto_opinion"]; ?>" class="img-thumbnail">

									</div>

									<div class="col-9 col-sm-8 col-lg-10 p-2 text-muted">

										<p><?php echo $value["contenido_opinion"]; ?></p>

										<?php
										$formatofecha = strtotime($value["fecha_opinion"]);
										$formatofecha = date('d.m.Y', $formatofecha)
										?>

										<span class="small float-right"><?php echo $value["nombre_opinion"]; ?> | <?php echo $formatofecha; ?></span>

									</div>

									<?php if ($value["respuesta_opinion"] != null) : ?>
										<div class="col-9 col-sm-8 col-lg-10 p-2 text-muted">

											<p><?php echo $value["respuesta_opinion"]; ?></p>

											<?php
											$formatoR = strtotime($value["fecha_respuesta"]);
											$formatoR = date('d.m.Y', $formatoR)
											?>

											<span class="small float-right"><?php echo $value["nombre_admin"]; ?> | <?php echo $formatoR; ?></span>

										</div>

										<div class="col-3 col-sm-4 col-lg-2 p-2">

											<img src="<?php echo $blog["dominio"] . $value["foto_admin"]; ?>" class="img-thumbnail">

										</div>
									<?php endif ?>

								<?php endif ?>

							<?php endforeach ?>

						<?php else : ?>
							<p class="pl-3 text-secondary">¡Este artículo no tiene opiniones!</p>
						<?php endif ?>

					</div>

					<hr style="border: 1px solid #79FF39">

					<!-- FORMULARIO DE OPINIONES -->

					<form method="POST" enctype="multipart/form-data">

						<input type="hidden" name="id_articulo" value="<?php echo $articulo[0]["id_articulo"]; ?>">
						<label class="text-muted lead">¿Qué tal te pareció el artículo?</label>

						<div class="row">

							<div class="col-12 col-md-8 col-lg-9">

								<div class="input-group-lg">

									<input type="text" class="form-control my-3" placeholder="Tu nombre" name="nombre_opinion" required>

									<input type="email" class="form-control my-3" placeholder="Tu email" name="email_opinion" required>

								</div>

							</div>

							<input type="file" name="foto_opinion" id="fotoOpinion" class="d-none">

							<label for="fotoOpinion" class="d-none d-md-block col-md-4 col-lg-3">

								<img src="<?php echo $blog["dominio"]; ?>views/img/subirFoto.png" class="img-fluid mt-md-3 mt-xl-2 prevFotoOpinion">

							</label>

						</div>

						<textarea class="form-control my-3" rows="7" placeholder="Escribe aquí tu mensaje" name="contenido_opinion" required></textarea>

						<input type="submit" class="btn btn-dark btn-lg btn-block" value="Enviar">

						<?php

						$EnviarOpinion = ControladorBlog::ctrEnviarOpinion();

						if ($EnviarOpinion != "") {
							echo '<script>
									if (window.history.replaceState){
										
										window.history.replaceState( null, null, window.location.href );

									}
								</script>';

							if ($EnviarOpinion == "ok") {
								echo '<script>
										notie.alert({
											type: 1,
											text: "La opinión ha sido enviada correctamente",
											time: 5
										})
									</script>';
							}
							if ($EnviarOpinion == "error") {
								echo '<script>
										notie.alert({
											type: 3,
											text: "No se permíten caracteres especiales en el formulario",
											time: 5
										})
									</script>';
							}
							if ($EnviarOpinion == "error-formato") {
								echo '<script>
										notie.alert({
											type: 3,
											text: "Error en el formato de la imagen, debe ser JPG o PNG",
											time: 5
										})
									</script>';
							}
						}

						?>

					</form>

					<!-- PUBLICIDAD -->

					<img src="<?php echo $blog["dominio"]; ?>views/img/ad01.jpg" class="img-fluid my-3 d-block d-md-none" width="100%">


				</div>

			</div>

			<!-- COLUMNA DERECHA -->

			<div class="d-none d-md-block pt-md-4 pt-lg-0 col-md-4 col-lg-3">

				<!-- ARTÍCULOS RECIENTES -->

				<div class="my-4">

					<h4>Artículos Recientes</h4>

					<?php foreach (limitarForeach($totalArticulos, 3) as $key => $value) : ?>
						<div class="d-flex my-3">

							<div class="w-100 w-xl-50 pr-3 pt-2">

								<a href="<?php echo $blog["dominio"].$articulo[0]["ruta_categoria"]."/".$value["ruta_articulo"]; ?>">

									<img src="<?php echo $blog["dominio"].$value["portada_articulo"]; ?>" alt="<?php echo $value["titulo_articulo"]; ?>" class="img-fluid">

								</a>

							</div>

							<div>

								<a href="<?php echo $blog["dominio"].$articulo[0]["ruta_categoria"]."/".$value["ruta_articulo"]; ?>" class="text-secondary">

									<p class="small"><?php echo substr($value["descripcion_articulo"],0,-150)."..."; ?></p>

								</a>

							</div>

						</div>
					<?php endforeach ?>

				</div>
				<!-- PUBLICIDAD -->

				<div class="mb-4">

					<img src="<?php echo $blog["dominio"]; ?>views/img/ad03.png" class="img-fluid">

				</div>

				<div class="my-4">

					<img src="<?php echo $blog["dominio"]; ?>views/img/ad02.jpg" class="img-fluid">

				</div>

				<div class="my-4">

					<img src="<?php echo $blog["dominio"]; ?>views/img/ad06.png" class="img-fluid">

				</div>

			</div>

		</div>

	</div>

</div>