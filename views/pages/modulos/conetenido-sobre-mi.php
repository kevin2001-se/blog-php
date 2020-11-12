<div class="container-fluid bg-white">
    <div class="container py-4">
        <div class="row">
            <div class="col-12 col-lg-6">
                <?php
                echo $blog["sobre_mi_completo"]
                ?>
            </div>
            <div class="col-12 col-lg-6">
                <h4 class="mt-4">Contactanos</h4>
                <form method="post">
                    <input type="text" class="form-control my-3" name="nombreContacto" placeholder="Nombre y Apellido" id="" required>
                    <input type="text" class="form-control my-3" name="emailContacto" placeholder="Escriba su Correo Electronico" id="" required>
                    <textarea class="form-control my-3" name="mensajeContacto" id="" cols="30" rows="10"></textarea>
                    <input type="submit" class="btn btn-primary" value="Enviar">

                    <?php 
                        $enviarCorreo = ControladorCorreo::ctrEnviarCorreo();

                        if ($enviarCorreo != "") {
                            echo '<script>
									if (window.history.replaceState){
										
										window.history.replaceState( null, null, window.location.href );

									}
								</script>';
                        }

                        if ($enviarCorreo == "ok") {
                            echo '<script>
                                    notie.alert({
                                        type: 1,
                                        text: "El Mensaje a sido Enviado Correctamente",
                                        time: 5
                                    })
                                </script>';
                        }
                        if ($enviarCorreo == "error") {
                            echo '<script>
                                    notie.alert({
                                        type: 3,
                                        text: "No se pudo enviar el Mensaje, Intentelo mas tarder",
                                        time: 5
                                    })
                                </script>';
                        }
                    ?>

                </form>
            </div>
        </div>
    </div>
</div>