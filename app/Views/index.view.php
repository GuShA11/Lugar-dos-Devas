
<main>

    <section id="fondo">
        <h2>Turismo de Aldea Rural</h2>
        <p>Una experiencia relajante en la naturaleza.</p>
        <a href="/reservas" class="btn btn-light">¡Reserva ya!</a>
    </section>
    <?php
    if (isset($habitaciones) && count($habitaciones) > 0) {
        ?>
        <section class="slider-wrapper">
            <?php
            if (isset($mensaje)) {
                ?>
                <div class="col-12" style="margin-top:20px;">
                    <div class="alert alert-<?php echo $mensaje['class']; ?>"><p><?php echo $mensaje['texto']; ?></p></div>
                </div>
                <?php
            }
            ?>
            <h2>Nuestras Habitaciones</h2>
            <button class="slide-arrow" id="slide-arrow-prev">
                &#8249;
            </button>
            <button class="slide-arrow" id="slide-arrow-next">
                &#8250;
            </button>
            <ul class="slides-container" id="slides-container">
                <?php
                foreach ($habitaciones as $habitacion) {
                    ?>
                    <li class="slide">
                        <img src="<?php echo '/assets/img/' . $habitacion['src'] ?>" alt="<?php echo $habitacion['nombre_habitacion'] ?>">
                        <h3><?php echo $habitacion['nombre_habitacion'] ?></h3>
                        <p>Descripcion <?php echo $habitacion['descripcion'] ?> desde <?php echo $habitacion['precio_noche'] ?>€/noche</p>
                        <a href="/reservas" class="btn btn-dark">¡Reserva ya!</a>
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
                <img src="/assets/img/piscina.jpg" alt="piscina">
                <h3>Piscina</h3>
                <p>Piscina relajante</p>
            </li>
            <li>
                <img src="/assets/img/salon.jpg" alt="salon de meditacion">
                <h3>Salón de meditación</h3>
                <p>Conecta con la paz local</p>
            </li>
            <li>
                <img src="/assets/img/masajes.jpeg" alt="masajes">
                <h3>Masajes</h3>
                <p>Tratamientos y masajes</p>
            </li>
        </ul>
    </section>

    <script>
        const slidesContainer = document.getElementById("slides-container");
        const slide = document.querySelector(".slide");
        const prevButton = document.getElementById("slide-arrow-prev");
        const nextButton = document.getElementById("slide-arrow-next");

        nextButton.addEventListener("click", () => {
            const slideWidth = slide.clientWidth;
            slidesContainer.scrollLeft += slideWidth;
        });

        prevButton.addEventListener("click", () => {
            const slideWidth = slide.clientWidth;
            slidesContainer.scrollLeft -= slideWidth;
        });
    </script>
</main>
