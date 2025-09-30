document.addEventListener("DOMContentLoaded", () => {
    document.querySelector(".employee-table tbody").addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-delete");
        if (!btn) return;

        const idPermiso = btn.dataset.id;

        const confirm = await Swal.fire({
            title: "¿Eliminar permiso?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        });

        if (!confirm.isConfirmed) return;

        try {
            const res = await fetch("../controller/PermisoController.php?action=eliminarPermiso", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ idPermiso })
            });
            const result = await res.json();

            if (result.success) {
                Swal.fire("Eliminado", "El permiso fue eliminado", "success");
                setTimeout(() => location.reload(), 1000);
            } else {
                Swal.fire("Error", result.error || "No se pudo eliminar", "error");
            }
        } catch (err) {
            console.error(err);
            Swal.fire("Error", "Error en la conexión con el servidor", "error");
        }
    });
});
