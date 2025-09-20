<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="sidebar">
    <div class="logo">
        <img src="../public/images/sise.png" alt="Logo" class="logo-img">
        <p class="logo-text">SISE</p>
    </div>

    <div class="home">
        <a href="DashBoard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'DashBoard.php' ? 'active' : ''; ?>">
            <i class='bx bxs-home'></i> Principal
        </a>
    </div>

    <div class="gestion">
        <label>Gestión</label>
        <a href="Empleados.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'Empleados.php' ? 'active' : ''; ?>">
            <i class='bx bxs-user'></i> Empleados
        </a>
        <a href="#">
            <i class='bx bxs-file-doc'></i> Contratos
        </a>
        <a href="#">
            <i class='bx bxs-calendar-check'></i> Permisos
        </a>
    </div>

    <div class="other">
        <label>Otros</label>
        <a href="#">
            <i class='bx bxs-time-five'></i> Asistencias
        </a>
    </div> 

    <div class="logout">
        <a href="#" id="btnLogout">
            <i class='bx bx-log-out'></i> Salir
        </a>
    </div>
</div>

<script src="../public/js/logout.js"></script>