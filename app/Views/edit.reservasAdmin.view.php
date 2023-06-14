<main id="editReservas">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $tituloDiv; ?></h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form action="<?php echo $seccion; ?>" method="post">         
                    <!--form method="get"-->
                    <div class="row">
                        <div class="mb-3 col-sm-6">
                            <label for="id_reserva">ID Reserva</label>
                            <input disabled class="form-control" id="id_reserva" type="text" name="id_reserva" value="<?php echo isset($input['id_reserva']) ? $input['id_reserva'] : ''; ?>">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="email">Email</label>
                            <input class="form-control" id="email" type="text" name="email" value="<?php echo isset($input['email']) ? $input['email'] : ''; ?>"">
                            <p class="text-danger"><?php echo isset($errores['email']) ? $errores['email'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" id="nombre" type="text" name="nombre" value="<?php echo isset($input['nombre']) ? $input['nombre'] : ''; ?>">
                            <p class="text-danger"><?php echo isset($errores['nombre']) ? $errores['nombre'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="precio_total">Precio total</label>
                            <input disabled class="form-control" id="precio_total" type="text" name="precio_total" value="<?php echo isset($input['precio_total']) ? $input['precio_total'] . '€' : ''; ?>">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="fecha_llegada">Fecha llegada</label>
                            <input disabled class="form-control" id="fecha_llegada" type="text" name="fecha_llegada" value="<?php echo isset($input['fecha_llegada']) ? $input['fecha_llegada'] : ''; ?>">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="fecha_salida">Fecha salida</label>
                            <input disabled class="form-control" id="fecha_salida" type="text" name="fecha_salida" value="<?php echo isset($input['fecha_salida']) ? $input['fecha_salida'] : ''; ?>">
                        </div>
                        <div class="mb-3 col-sm-6">
                            <label for="nombre_habitacion">Habitacion</label>
                            <input disabled class="form-control" id="nombre_habitacion" type="text" name="nombre_habitacion" value="<?php echo isset($input['nombre_habitacion']) ? $input['nombre_habitacion'] : ''; ?>">
                        </div>

                        <div class="col-12 text-right">                            
                            <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                            <a href="/reservasAdmin" class="btn btn-danger ml-3">Cancelar</a>                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</main>