<main>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h4 class="m-0 font-weight-bold text-primary">Alta reserva</h4>     
            </div>
            <div class="card-body">
                <p>Por favor indique las fechas de su estadía para comprobar la disponibilidad de nuestras habitaciones!</p>

                <form action="reservasAdmin/add" method="POST">
                    <div class="row">
                        <div class="mb-3 col-sm-3">
                            <label for="fecha-llegada">Fecha de Llegada:</label>
                            <input class="form-control" type="date" id="fecha-llegada" name="fecha-llegada"  value="<?php echo isset($input['fecha-llegada']) ? $input['fecha-llegada'] : ''; ?>">
                            <p class="text-danger"><?php echo isset($errores['fecha']) ? $errores['fecha'] : ''; ?></p>
                        </div>
                        <div class="mb-3 col-sm-3">
                            <label for="fecha-salida">Fecha de Salida:</label>
                            <input class="form-control" type="date" id="fecha-salida" name="fecha-salida" value="<?php echo isset($input['fecha-salida']) ? $input['fecha-salida'] : ''; ?>">
                        </div>
                        <div class="col-12 text-right">                            
                            <input type="submit" value="Submit" name="enviar" class="btn btn-primary"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>