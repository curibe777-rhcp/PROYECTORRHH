
document.addEventListener("DOMContentLoaded", () => {
    const modalRetiro = document.getElementById("modalRetiro");
    const btnCancelar = document.querySelector(".btn-cancel-retiro");
    const btnRetirar = document.querySelector(".btn-retirar");
    const selectMotivo = document.getElementById("motivo_retiro");
    const descripcionRetiro = document.getElementById("descripcion_retiro");

    document.querySelector(".employee-table tbody").addEventListener("click", (e) => {
        if (e.target.closest(".btn-delete")) {
            const btn = e.target.closest(".btn-delete");
            modalRetiro.dataset.idEmpleado = btn.dataset.id;
            modalRetiro.classList.add("show");
        }
    });

    btnCancelar.addEventListener("click", () => {
        verificarCierreModal();
    });

    modalRetiro.addEventListener("click", e => {
        if (e.target === modalRetiro) verificarCierreModal();
    });

    function verificarCierreModal() {
        if (selectMotivo.value || descripcionRetiro.value.trim() !== "") {
            Swal.fire({
                title: '¿Seguro que quieres salir?',
                text: "Si sales, perderás los datos que ingresaste.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar',
                zIndex: 20000
            }).then((result) => {
                if (result.isConfirmed) {
                    cerrarModal();
                }
            });
        } else {
            cerrarModal();
        }
    }

    function cerrarModal() {
        modalRetiro.classList.remove("show");
        selectMotivo.value = "";
        descripcionRetiro.value = "";
    }

    async function cargarMotivos() {
        try {
            const response = await fetch("../controller/EmpleadoController.php?action=motivos");
            const data = await response.json();

            selectMotivo.innerHTML = '<option value="">Seleccione el motivo</option>';
            data.forEach(motivo => {
                const option = document.createElement("option");
                option.value = motivo.idMotivo;
                option.textContent = motivo.descripcion;
                selectMotivo.appendChild(option);
            });
        } catch (error) {
            console.error("Error al cargar motivos:", error);
        }
    }

    cargarMotivos();

    btnRetirar.addEventListener("click", async () => {
        const idEmpleado = modalRetiro.dataset.idEmpleado;
        const idMotivo = selectMotivo.value;
        const descripcion = descripcionRetiro.value.trim();

        if (!idMotivo || !descripcion) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos Vacios',
                text: 'Hay uno o más campos vacíos. Por favor complete todos los campos para continuar.',
                zIndex: 20000
            });
            return;
        }

        const confirm = await Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás deshacer esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, retirar',
            cancelButtonText: 'Cancelar',
            zIndex: 20000
        });

        if (!confirm.isConfirmed) return;

        try {
            const response = await fetch("../controller/EmpleadoController.php?action=retirarEmpleado", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ idEmpleado, idMotivo, descripcion })
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Empleado retirado',
                    text: 'El empleado ha sido retirado correctamente.',
                    zIndex: 20000
                });
                cerrarModal();
                setTimeout(() => location.reload(), 1000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.error || 'Ocurrió un error al retirar el empleado.',
                    zIndex: 20000
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo conectar con el servidor.',
                zIndex: 20000
            });
        }
    });
});

