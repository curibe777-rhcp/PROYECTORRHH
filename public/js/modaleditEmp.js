
document.addEventListener("DOMContentLoaded", () => {
    const modalPrincipal = document.getElementById("modal-edit");
    const modalDatos = document.getElementById("modalDatos");
    const modalUbicacion = document.getElementById("modalUbicacion");
    const modalLaborales = document.getElementById("modalLaborales");

    const depSelect = document.getElementById("editDepartamento");
    const provSelect = document.getElementById("editProvincia");
    const distSelect = document.getElementById("editDistrito");

    document.querySelector(".employee-table tbody").addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-edit");
        if (!btn) return;
        modalPrincipal.dataset.idEmpleado = btn.dataset.id;
        modalPrincipal.classList.add("show");
    });

    document.getElementById("btnDatos").addEventListener("click", async () => {
        const idEmpleado = modalPrincipal.dataset.idEmpleado;
        try {
            const res = await fetch(`../controller/EmpleadoController.php?action=datosPersonales&idEmpleado=${idEmpleado}`);
            const text = await res.text();
            const data = text ? JSON.parse(text) : {};
            document.getElementById("editNombre").value = data.nombres || "";
            document.getElementById("editApellidoP").value = data.apellidopaterno || "";
            document.getElementById("editApellidoM").value = data.apellidomaterno || "";
            modalPrincipal.classList.remove("show");
            modalDatos.classList.add("show");
        } catch (err) {
            console.error("Error al obtener datos personales:", err);
        }
    });

    document.getElementById("btnUbicacion").addEventListener("click", async () => {
        const idEmpleado = modalPrincipal.dataset.idEmpleado;

        try {
            const res = await fetch(`../controller/EmpleadoController.php?action=datosUbicacion&idEmpleado=${idEmpleado}`);
            const text = await res.text();
            const data = text ? JSON.parse(text) : {};
            console.log("Ubicación del empleado:", data);

            const idDep = data.iddepartamento || "";
            const idProv = data.idprovincia || "";
            const idDist = data.iddistrito || "";

            document.getElementById("editDireccion").value = data.direccion || "";

            const depsRes = await fetch("../controller/EmpleadoController.php?action=departamentos");
            const depsText = await depsRes.text();
            const deps = depsText ? JSON.parse(depsText) : [];

            depSelect.innerHTML = "";
            deps.forEach(dep => {
                const option = document.createElement("option");
                option.value = dep.idDepartamento || "";
                option.textContent = dep.departamento || "";
                if (dep.idDepartamento && dep.idDepartamento.toString() === idDep.toString()) {
                    option.selected = true;
                }
                depSelect.appendChild(option);
            });

            const provsRes = await fetch(`../controller/EmpleadoController.php?action=provincias&idDepartamento=${idDep}`);
            const provsText = await provsRes.text();
            const provs = provsText ? JSON.parse(provsText) : [];

            provSelect.innerHTML = '<option value="">Seleccione provincia</option>';
            provs.forEach(p => {
                const option = document.createElement("option");
                option.value = p.idProvincia || "";
                option.textContent = p.provincia || "";
                if (p.idProvincia && p.idProvincia.toString() === idProv.toString()) option.selected = true;
                provSelect.appendChild(option);
            });

            const distsRes = await fetch(`../controller/EmpleadoController.php?action=distritos&idProvincia=${idProv}`);
            const distsText = await distsRes.text();
            const dists = distsText ? JSON.parse(distsText) : [];

            distSelect.innerHTML = '<option value="">Seleccione distrito</option>';
            dists.forEach(di => {
                const option = document.createElement("option");
                option.value = di.idDistrito || "";
                option.textContent = di.distrito || "";
                if (di.idDistrito && di.idDistrito.toString() === idDist.toString()) option.selected = true;
                distSelect.appendChild(option);
            });

            modalPrincipal.classList.remove("show");
            modalUbicacion.classList.add("show");

        } catch (err) {
            console.error("Error al cargar ubicación:", err);
        }
    });

    depSelect.addEventListener("change", async (e) => {
        const idDep = e.target.value;
        provSelect.innerHTML = '<option value="">Seleccione provincia</option>';
        distSelect.innerHTML = '<option value="">Seleccione distrito</option>';
        if (!idDep) return;

        try {
            const provsRes = await fetch(`../controller/EmpleadoController.php?action=provincias&idDepartamento=${idDep}`);
            const provs = await provsRes.json();
            provs.forEach(p => {
                const option = document.createElement("option");
                option.value = p.idProvincia || "";
                option.textContent = p.provincia || "";
                provSelect.appendChild(option);
            });
        } catch (err) {
            console.error("Error al cargar provincias:", err);
        }
    });

    provSelect.addEventListener("change", async (e) => {
        const idProv = e.target.value;
        distSelect.innerHTML = '<option value="">Seleccione distrito</option>';
        if (!idProv) return;

        try {
            const distsRes = await fetch(`../controller/EmpleadoController.php?action=distritos&idProvincia=${idProv}`);
            const dists = await distsRes.json();
            dists.forEach(di => {
                const option = document.createElement("option");
                option.value = di.idDistrito || "";
                option.textContent = di.distrito || "";
                distSelect.appendChild(option);
            });
        } catch (err) {
            console.error("Error al cargar distritos:", err);
        }
    });

    document.getElementById("btnLaborales").addEventListener("click", async () => {
        const idEmpleado = modalPrincipal.dataset.idEmpleado;

        try {
            const res = await fetch(`../controller/EmpleadoController.php?action=datosLaborales&idEmpleado=${idEmpleado}`);
            const text = await res.text();
            const data = text ? JSON.parse(text) : {};
            console.log("Datos laborales:", data);

            const idArea = data.idAreaTrabajo || "";
            const idCargo = data.idCargo || "";

            document.getElementById("editTelefono").value = data.telefono || "";
            document.getElementById("editSalario").value = data.salario || "";

            const areasRes = await fetch("../controller/EmpleadoController.php?action=areasTrabajo");
            const areasText = await areasRes.text();
            const areas = areasText ? JSON.parse(areasText) : [];

            const areaSelect = document.getElementById("editArea");
            areaSelect.innerHTML = '<option value="">Seleccione área</option>';
            areas.forEach(a => {
                const option = document.createElement("option");
                option.value = a.idAreaTrabajo || "";
                option.textContent = a.areaTrabajo || "";
                if (a.idAreaTrabajo && a.idAreaTrabajo.toString() === idArea.toString()) {
                    option.selected = true;
                }
                areaSelect.appendChild(option);
            });

            const cargosRes = await fetch(`../controller/EmpleadoController.php?action=cargos&idAreaTrabajo=${idArea}`);
            const cargosText = await cargosRes.text();
            const cargos = cargosText ? JSON.parse(cargosText) : [];

            const cargoSelect = document.getElementById("editCargo");
            cargoSelect.innerHTML = '<option value="">Seleccione cargo</option>';
            cargos.forEach(c => {
                const option = document.createElement("option");
                option.value = c.idCargo || "";
                option.textContent = c.cargo || "";
                if (c.idCargo && c.idCargo.toString() === idCargo.toString()) {
                    option.selected = true;
                }
                cargoSelect.appendChild(option);
            });

            modalPrincipal.classList.remove("show");
            modalLaborales.classList.add("show");

        } catch (err) {
            console.error("Error al cargar datos laborales:", err);
        }
    });

    document.getElementById("editArea").addEventListener("change", async (e) => {
        const idArea = e.target.value;
        const cargoSelect = document.getElementById("editCargo");
        cargoSelect.innerHTML = '<option value="">Seleccione cargo</option>';
        if (!idArea) return;

        try {
            const cargosRes = await fetch(`../controller/EmpleadoController.php?action=cargos&idAreaTrabajo=${idArea}`);
            const cargos = await cargosRes.json();
            cargos.forEach(c => {
                const option = document.createElement("option");
                option.value = c.idCargo || "";
                option.textContent = c.cargo || "";
                cargoSelect.appendChild(option);
            });
        } catch (err) {
            console.error("Error al cargar cargos:", err);
        }
    });

    document.querySelectorAll(".btn-cancel-edit").forEach(btn => {
        btn.addEventListener("click", (e) => {
            const modal = e.target.closest(".modal");
            if (modal) modal.classList.remove("show");
        });
    });

    document.querySelectorAll(".modal").forEach(modal => {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) modal.classList.remove("show");
        });
    });

    document.getElementById("btnSaveDatos").addEventListener("click", async () => {
        const modal = modalDatos;
        const idEmpleado = modal.dataset.idEmpleado || modalPrincipal.dataset.idEmpleado;

        const nombre = document.getElementById("editNombre").value.trim();
        const apePaterno = document.getElementById("editApellidoP").value.trim();
        const apeMaterno = document.getElementById("editApellidoM").value.trim();

        if (!nombre || !apePaterno || !apeMaterno) {
            await Swal.fire({
                title: "Campos vacíos",
                text: "Por favor completa todos los campos para guardar.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3085d6"
            });
            return;
        }

        try {
            const response = await fetch("../controller/EmpleadoController.php?action=actualizarDatosPersonales", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ idEmpleado, nombre, apePaterno, apeMaterno })
            });

            const result = await response.json();

            if (result.success) {
                await Swal.fire({
                    title: "Actualizado",
                    text: result.message || "Datos personales actualizados correctamente",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });

                modal.classList.remove("show");
            } else {
                await Swal.fire({
                    title: "Error",
                    text: result.error || "No se pudo actualizar los datos",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#dc3545"
                });
            }
        } catch (err) {
            console.error("Error al actualizar datos personales:", err);
            await Swal.fire({
                title: "Error",
                text: err.message,
                icon: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#dc3545"
            });
        }
    });

    document.getElementById("btnSaveUbicacion").addEventListener("click", async () => {
        const modal = modalUbicacion;
        const idEmpleado = modal.dataset.idEmpleado || modalPrincipal.dataset.idEmpleado;

        const idDep = depSelect.value;
        const idProv = provSelect.value;
        const idDist = distSelect.value;
        const direccion = document.getElementById("editDireccion").value.trim();

        if (!idDep || !idProv || !idDist || !direccion) {
            await Swal.fire({
                title: "Campos vacíos",
                text: "Por favor completa todos los campos para guardar.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3085d6"
            });
            return;
        }

        try {
            const response = await fetch("../controller/EmpleadoController.php?action=actualizarUbicacion", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ 
                    idEmpleado, 
                    idDepartamento: idDep, 
                    idProvincia: idProv, 
                    idDistrito: idDist, 
                    direccion 
                })
            });

            const text = await response.text();
            const result = text ? JSON.parse(text) : { success: false, error: 'No hay respuesta del servidor' };

            if (result.success) {
                await Swal.fire({
                    title: "Actualizado",
                    text: result.message || "Ubicación actualizada correctamente",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });

                modal.classList.remove("show");
            } else {
                await Swal.fire({
                    title: "Error",
                    text: result.error || "No se pudo actualizar la ubicación",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#dc3545"
                });
            }
        } catch (err) {
            console.error("Error al actualizar ubicación:", err);
            await Swal.fire({
                title: "Error",
                text: err.message,
                icon: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#dc3545"
            });
        }
    });

    document.getElementById("btnSaveLaborales").addEventListener("click", async () => {
        const modal = modalLaborales;
        const idEmpleado = modal.dataset.idEmpleado || modalPrincipal.dataset.idEmpleado;

        const idArea = document.getElementById("editArea").value;
        const idCargo = document.getElementById("editCargo").value;
        const telefono = document.getElementById("editTelefono").value.trim();
        const salario = document.getElementById("editSalario").value.trim();

        if (!idArea || !idCargo || !telefono || !salario) {
            await Swal.fire({
                title: "Campos vacíos",
                text: "Por favor completa todos los campos para guardar.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#3085d6"
            });
            return;
        }

        try {
            const response = await fetch("../controller/EmpleadoController.php?action=actualizarDatosLaborales", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ idEmpleado, idArea, idCargo, telefono, salario })
            });

            const result = await response.json();

            if (result.success) {
                await Swal.fire({
                    title: "Actualizado",
                    text: result.message || "Datos laborales actualizados correctamente",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                });

                modal.classList.remove("show");
            } else {
                await Swal.fire({
                    title: "Error",
                    text: result.error || "No se pudo actualizar los datos laborales",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#dc3545"
                });
            }
        } catch (err) {
            console.error("Error al actualizar datos laborales:", err);
            await Swal.fire({
                title: "Error",
                text: err.message,
                icon: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#dc3545"
            });
        }
    });
});


