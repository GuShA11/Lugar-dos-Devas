<main>
    <section id="error">
        <div>
            <h1 style="color:red;">Error 404 - Página no encontrada</h1>
            <p>La página que estás buscando no existe.</p>
            <a href="<?php echo (isset($_SESSION['usuario'])) ? '/usuariosAdmin' : '/' ?>">Volver a la página de inicio</a>
        </div>
    </section>
</main>
