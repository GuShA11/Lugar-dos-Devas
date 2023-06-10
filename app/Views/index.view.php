
<main>

    <section id="fondo">
        <h2>Turismo de Aldea Rural</h2>
        <p>Una experiencia relajante en la naturaleza.</p>
        <a href="/reservas" class="btn primary">¡Reserva ya!</a>
    </section>
    <?php
    if (isset($habitaciones) && count($habitaciones) > 0) {
        ?>
        <section id="habitaciones">
            <?php
            if (isset($mensaje)) {
                ?>
                <div class="col-12">
                    <div class="alert alert-<?php echo $mensaje['class']; ?>"><p><?php echo $mensaje['texto']; ?></p></div>
                </div>
                <?php
            }
            ?>
            <h2>Nuestras habitaciones</h2>
            <ul>
                <?php
                foreach ($habitaciones as $habitacion) {
                    ?>
                    <li>
                        <img src="<?php echo '/assets/img/' . $habitacion['src'] ?>" alt="<?php echo $habitacion['nombre_habitacion'] ?>">
                        <h3><?php echo $habitacion['nombre_habitacion'] ?></h3>
                        <p>Descripcion <?php echo $habitacion['descripcion'] ?> desde <?php echo $habitacion['precio_noche'] ?>€/noche</p>
                        <a href="/reservas" class="btn">¡Reserva ya!</a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </section>
        <?php
    }
    ?>
    <section id="facilities">
        <h2>Nuestros Servicios</h2>
        <ul>
            <li>
                <img src="/assets/img/vale.jpg" alt="Swimming Pool">
                <h3>Piscina</h3>
                <p>Piscina relajante</p>
            </li>
            <li>
                <img src="/assets/img/vale.jpg" alt="Gym">
                <h3>Salón de meditación</h3>
                <p>Para relajar la mente y conectar con la paz local</p>
            </li>
            <li>
                <img src="/assets/img/vale.jpg" alt="Spa">
                <h3>Masajes</h3>
                <p>Tratamientos y masajes</p>
            </li>
        </ul>
    </section>
</main>
