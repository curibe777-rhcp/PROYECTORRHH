
document.getElementById("btnLogout").addEventListener("click", function(e) {
    e.preventDefault();

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Se cerrará tu sesión",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, salir",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch("../view/Logout.php", { method: "POST" })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Sesión cerrada",
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "Login.php";
                        });
                    }
                });
        }
    });
});
