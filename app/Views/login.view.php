<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lugar dos Devas | Log in</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="assets/css/adminlte.min.css">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>Lugar Dos Devas</b></a>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Iniciar sesión como administrador</p>
                    <form action="/login" method="post">
                        <div class="input-group mb-3">
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="pass" placeholder="Contraseña">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>          
                        </div> 
                        <?php
                        if (isset($loginError) && !empty($loginError) > 0) {
                            ?>    
                            <p class="login-box-msg text-danger"><?php echo $loginError; ?></p>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-3 text-right">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <div class="col-6">
                                <a href="/" class="btn btn-light">Volver</a>   
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
    </body>
</html>
