<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <link rel="stylesheet" href="../public/css/siderbar.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .container {
            display: flex;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'Sidebar.php'; ?>
        
        <div class="content">
            <h1>Página Principal</h1>
            <p>Bienvenido al sistema de gestión de Recursos Humanos.</p>
            <p>Aquí podrás acceder a un resumen general del sistema.</p>
        </div>
    </div>
</body>
</html>