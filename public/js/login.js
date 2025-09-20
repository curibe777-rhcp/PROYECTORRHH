
document.getElementById("formLogin").addEventListener("submit", function(e) {
    e.preventDefault(); 

    let datos = new FormData(this);

    fetch("../controller/LoginController.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: "success",
                title: "Bienvenido",
                text: "Hola " + data.usuario,
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = "DashBoard.php";
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message || "Usuario o contraseña incorrectos",
                confirmButtonText: "Intentar de nuevo"
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: "error",
            title: "Error en el servidor",
            text: error,
            confirmButtonText: "OK"
        });
    });
});