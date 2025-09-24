document.addEventListener("click", e => {
    if (e.target.classList.contains("btn-edit")) {
        const idPermiso = e.target.dataset.id;

        Swal.fire({
            title: "Actualizar estado",
            showDenyButton: true,
            confirmButtonText: "Aprobar",
            denyButtonText: "Rechazar"
        }).then(result => {
            if (result.isConfirmed) {
                actualizarEstado(idPermiso, 2); // 2 = aprobado
            } else if (result.isDenied) {
                actualizarEstado(idPermiso, 3); // 3 = rechazado
            }
        });
    }
});

function actualizarEstado(idPermiso, estado) {
    fetch("../controllers/PermisoController.php?action=actualizarEstado", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({
            idPermiso: idPermiso,
            idEstadoPermiso: estado,
            usuario_mod: 1
        })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            Swal.fire("Éxito", res.message, "success");
            document.dispatchEvent(new Event("permisoGuardado"));
        } else {
            Swal.fire("Error", res.error || "No se pudo actualizar", "error");
        }
    });
}
