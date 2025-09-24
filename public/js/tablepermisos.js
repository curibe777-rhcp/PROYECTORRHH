document.addEventListener("DOMContentLoaded", function() {
    const tbody = document.querySelector(".employee-table tbody");

    function cargarPermisos() {
        fetch("../controllers/PermisoController.php?action=listar")
            .then(res => res.json())
            .then(data => {
                tbody.innerHTML = "";
                if (data.success && data.data.length > 0) {
                    data.data.forEach(p => {
                        const row = `
                            <tr>
                                <td>${p.idPermiso}</td>
                                <td>${p.nombreEmpleado}</td>
                                <td>${p.tipoPermiso}</td>
                                <td>${p.motivo}</td>
                                <td>${p.fechaInicio}</td>
                                <td>${p.fechaFin}</td>
                                <td>${p.descripcion}</td>
                                <td>
                                    <button class="btn-edit" data-id="${p.idPermiso}">Editar</button>
                                    <button class="btn-delete" data-id="${p.idPermiso}">Eliminar</button>
                                </td>
                            </tr>
                        `;
                        tbody.insertAdjacentHTML("beforeend", row);
                    });
                }
            });
    }

    cargarPermisos();
});
