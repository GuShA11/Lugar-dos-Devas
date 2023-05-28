
<main>
    <section id="fondo">
        <h2>Turismo de Aldea Rural</h2>
        <?php
        if (isset($reservaCreada) && ($reservaCreada === true)) {
            ?>
            <script>
                window.addEventListener("load", (event) => {
                    window.alert("La reserva ha sido creada correctamente!")
                });
            </script>
            <?php
        }
        ?>
        <p>Una experiencia relajante en la naturaleza.</p>
        <a href="/reservas" class="btn">¡Reserva ya!</a>
    </section>
    <?php
    if (isset($habitaciones) && count($habitaciones) > 0) {
        ?>
        <section id="habitaciones">
            <h2>Nuestras habitaciones</h2>
            <ul>
                <?php
                foreach ($habitaciones as $habitacion) {
                    ?>
                    <li>
                        <img src="<?php echo $habitacion['src'] ?>" alt="<?php echo $habitacion['nombre_habitacion'] ?>">
                        <h3><?php echo $habitacion['nombre_habitacion'] ?></h3>
                        <p>Desde <?php echo $habitacion['precio_noche'] ?>€/noche</p>
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
    <section id="contact">
        <h2>Contact Us</h2>
        <form>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <label for="message">Message:</label>
            <textarea id="message" name="message"></textarea>
            <button type="submit" class="btn">Send</button>
        </form>
    </section>
</main>
