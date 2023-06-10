<main id="editUsuario">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $tituloDiv; ?></h6>                                    
            </div>
            <div class="card-body">
                <form action="<?php echo $seccion; ?>" method="post" enctype="multipart/form-data">         
                    <div class="row">
                        <div class="mb-3 col-sm-6">
                            <label for="nombre_habitacion">Nombre Habitación</label>
                            <input class="form-control" id="nombre_habitacion" type="text" name="nombre_habitacion" placeholder="Inserte un nombre" value="<?php echo isset($input['nombre_habitacion']) ? $input['nombre_habitacion'] : ''; ?>">
                            <p class="text-danger"><?php echo isset($errores['nombre_habitacion']) ? $errores['nombre_habitacion'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="precio_noche">Precio noche (€)</label>
                            <input class="form-control" id="precio_noche" type="number" name="precio_noche" placeholder="Inserte un precio" value="<?php echo isset($input['precio_noche']) ? $input['precio_noche'] : ''; ?>">
                            <p class="text-danger"><?php echo isset($errores['precio_noche']) ? $errores['precio_noche'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="descripcion">Descripción</label>
                            <input class="form-control" id="descripcion" type="text" name="descripcion" placeholder="Inserte una descripcion" value="<?php echo isset($input['descripcion']) ? $input['descripcion'] : ''; ?>">
                            <p class="text-danger"><?php echo isset($errores['descripcion']) ? $errores['descripcion'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="src">Imagen</label> 
                            <input class="form-control" id="src" type="file" name="src"  accept="image/*" value="<?php echo (isset($input['src'])) ? $input['src'] : ''; ?>">
                            <?php
                            if (isset($input['src']) && $input['src'] != '/assets/img/default.png') {
                                ?>
                                <img style="max-height: 150px !important;max-width: 100% !important;" src='<?php echo $input['src'] ?>'>
                                <input type="hidden" id="foto" name="foto" value="<?php echo $input['src'] ?>">
                                <?php
                            }
                            ?>
                            <p class="text-danger"><?php echo isset($errores['src']) ? $errores['src'] : ''; ?></p>
                        </div>

                        <div class="col-12 text-right">                            
                            <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                            <a href="/habitacionesAdmin" class="btn btn-danger ml-3">Cancelar</a>                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>