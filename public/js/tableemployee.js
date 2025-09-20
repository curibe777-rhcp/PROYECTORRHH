document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.querySelector(".employee-table tbody");

    async function cargarEmpleados() {
        try {
            const response = await fetch("../controller/EmpleadoController.php?action=listarEmpleados");
            const result = await response.json();

            const empleados = Array.isArray(result) ? result : (result.data || []);
            tbody.innerHTML = "";

            if (empleados.length === 0) {
                const tr = document.createElement("tr");
                tr.innerHTML = `<td colspan="9" style="text-align:center;">No hay empleados para mostrar</td>`;
                tbody.appendChild(tr);
                return;
            }

            empleados.forEach(emp => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${emp.idEmpleado}</td>
                    <td>${emp.nombres}</td>
                    <td>${emp.apellidos}</td>
                    <td>${emp.numeroDocumento}</td>
                    <td>${emp.email}</td>
                    <td>${emp.area_trabajo}</td>
                    <td>${emp.cargo}</td>
                    <td>${emp.estado}</td>
                    <td style="display:flex; gap:5px; justify-content:center;">
                        <button class="btn-edit" data-id="${emp.idEmpleado}" title="Editar" 
                            style="
                                width:30px; height:30px; display:flex; align-items:center; justify-content:center;
                                border:none; border-radius:5px; background:#007bff; color:white; cursor:pointer;
                                transition:0.3s;
                            ">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-delete" data-id="${emp.idEmpleado}" title="Eliminar"
                            style="
                                width:30px; height:30px; display:flex; align-items:center; justify-content:center;
                                border:none; border-radius:5px; background:#dc3545; color:white; cursor:pointer;
                                transition:0.3s;
                            ">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;

                tbody.appendChild(tr);
            });

            document.querySelectorAll(".btn-edit").forEach(btn => {
                btn.addEventListener("mouseenter", () => btn.style.filter = "brightness(85%)");
                btn.addEventListener("mouseleave", () => btn.style.filter = "brightness(100%)");
                btn.addEventListener("click", () => {
                    const id = btn.getAttribute("data-id");
                    console.log("Editar ID:", id);
                });
            });

            document.querySelectorAll(".btn-delete").forEach(btn => {
                btn.addEventListener("mouseenter", () => btn.style.filter = "brightness(85%)");
                btn.addEventListener("mouseleave", () => btn.style.filter = "brightness(100%)");
                btn.addEventListener("click", () => {
                    const id = btn.getAttribute("data-id");
                    console.log("Eliminar ID:", id);
                });
            });

        } catch (error) {
            console.error("Error al cargar empleados:", error);
            tbody.innerHTML = `<tr><td colspan="9" style="text-align:center;">Error cargando empleados</td></tr>`;
        }
    }

    cargarEmpleados();
});
