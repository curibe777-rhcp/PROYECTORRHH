<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login RRHH</title>
    <link rel="stylesheet" href="../public/css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="left-section">
            <img src="../public/images/loginhr2.jpg" alt="Login Image">
        </div>
        <div class="right-section">
            <div class="login-form">
                <h2 class="roboto-mono-title">Inicia Sesion</h2>
                <form id="formLogin" action="#" method="post">
                    <div class="input-group">
                        <div class="input-icon">
                            <i class="bx bx-user"></i> 
                            <input type="text" name="usuario" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-icon">
                            <i class="bx bx-lock"></i> 
                            <input type="password" name="clave" required>
                        </div>
                    </div>
                    <button type="submit" class="login-btn roboto-mono-button">Ingresar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../public/js/login.js"></script>
</body>
</html>