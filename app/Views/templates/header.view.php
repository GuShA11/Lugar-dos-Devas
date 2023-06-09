<!DOCTYPE html>
<html lang="en">
    <head>
        <base href="/">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lugar dos Devas</title>
        <link rel="icon" type="image/x-icon" href="/assets/img/LOGO.svg">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="assets/css/css.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/adminlte.min.css">
        <link href="assets/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    </head>
</head>
<body>
    <header>
        <h1 id="titulo_pagina">Lugar dos Devas</h1>
        <img src="/assets/img/LOGO2.svg" alt="Logo">
        <nav>
            <ul class="menu">
                <?php
                if (isset($_SESSION['permisos'])) {
                    ?>
                    <li class="nav-link <?php echo isset($seccion) && $seccion === '/usuariosAdmin' ? 'active' : ''; ?>"><a href="/usuariosAdmin">Usuarios</a></li>
                    <li class="nav-link <?php echo isset($seccion) && $seccion === '/reservasAdmin' ? 'active' : ''; ?>"><a href="/reservasAdmin">Reservas</a></li>
                    <li class="nav-link <?php echo isset($seccion) && $seccion === '/habitacionesAdmin' ? 'active' : ''; ?>"><a href="/habitacionesAdmin">Habitaciones</a></li>
                    <?php
                } else {
                    ?>
                    <li class="nav-link <?php echo isset($seccion) && $seccion === '/' ? 'active' : ''; ?>"><a href="/">Inicio</a></li>
                    <li class="nav-link <?php echo isset($seccion) && $seccion === '/reservas' ? 'active' : ''; ?>"><a href="/reservas">Reservas</a></li>
                    <li class="nav-link <?php echo isset($seccion) && $seccion === '/restaurante' ? 'active' : ''; ?>"><a href="/restaurante">Restaurante</a></li>
                    <li class="nav-link <?php echo isset($seccion) && $seccion === '/contacto' ? 'active' : ''; ?>"><a href="/contacto">Contacto</a></li>
                <?php }
                ?>
                <li><a class="nav-link" href="<?php echo isset($_SESSION['usuario']['id_usuario']) ? '/session/borrar' : '/login'; ?>" role="button">
                        <?php if (isset($_SESSION['usuario']['id_usuario'])) { ?>
                            <i class="material-icons">logout</i>
                            <?php
                        } else {
                            ?>
                            <i class="material-icons">login</i>
                            <?php
                        }
                        ?>
                    </a></li>        
            </ul>
            <div class="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>