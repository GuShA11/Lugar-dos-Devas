<main id="contacto">
    <?php
    if (isset($mensaje)) {
        ?>
        <div class="col-12" style="margin-top:20px;">
            <div class="alert alert-<?php echo $mensaje['class']; ?>"><p><?php echo $mensaje['texto']; ?></p></div>
        </div>
        <?php
    }
    ?>
    <div class="container">
        <h1>Contacto</h1>
        <form action="contacto" method="get">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="mensaje">Mensaje:</label>
                <textarea name="mensaje" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Enviar Mensaje</button>
            </div>
        </form>
    </div>
</main>