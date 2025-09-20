document.addEventListener("DOMContentLoaded", () => {
    const modalPrincipal = document.getElementById("modal-edit");
    const modalDatos = document.getElementById("modalDatos");
    const modalUbicacion = document.getElementById("modalUbicacion");
    const modalLaborales = document.getElementById("modalLaborales");

    document.querySelector(".employee-table tbody").addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-edit");
        if (!btn) return;

        const idEmpleado = btn.dataset.id;
        modalPrincipal.dataset.idEmpleado = idEmpleado;

        modalPrincipal.classList.add("show");
    });

    document.getElementById("btnDatos").addEventListener("click", () => {
        const idEmpleado = modalPrincipal.dataset.idEmpleado;

        fetch(`../controller/EmpleadoController.php?action=datosPersonales&idEmpleado=${idEmpleado}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById("editNombre").value = data.nombres || "";
                document.getElementById("editApellidoP").value = data.apellidopaterno || "";
                document.getElementById("editApellidoM").value = data.apellidomaterno || "";

                modalPrincipal.classList.remove("show");
                modalDatos.classList.add("show");
            })
            .catch(err => {
                console.error("Error al obtener datos personales:", err);
            });
    });

    document.getElementById("btnUbicacion").addEventListener("click", () => {
    const idEmpleado = modalPrincipal.dataset.idEmpleado;

    fetch(`../controller/EmpleadoController.php?action=datosUbicacion&idEmpleado=${idEmpleado}`)
        .then(res => res.json())
        .then(data => {
            console.log("Ubicación del empleado:", data);

            const idDep = data.iddepartamento;
            const idProv = data.idprovincia;
            const idDist = data.iddistrito;

            document.getElementById("editDireccion").value = data.direccion || "";

            fetch("../controller/EmpleadoController.php?action=listarDepartamentos")
                .then(res => res.json())
                .then(deps => {
                    const selectDep = document.getElementById("editDepartamento");
                    selectDep.innerHTML = "";
                    deps.forEach(dep => {
                        const option = document.createElement("option");
                        option.value = dep.iddepartamento;
                        option.textContent = dep.nombre;
                        if (dep.iddepartamento == idDep) option.selected = true;
                        selectDep.appendChild(option);
                    });

                    return fetch(`../controller/EmpleadoController.php?action=listarProvincias&idDepartamento=${idDep}`);
                })
                .then(res => res.json())
                .then(provs => {
                    const selectProv = document.getElementById("editProvincia");
                    selectProv.innerHTML = "";
                    provs.forEach(p => {
                        const option = document.createElement("option");
                        option.value = p.idprovincia;
                        option.textContent = p.nombre;
                        if (p.idprovincia == idProv) option.selected = true;
                        selectProv.appendChild(option);
                    });

                    return fetch(`../controller/EmpleadoController.php?action=listarDistritos&idProvincia=${idProv}`);
                })
                .then(res => res.json())
                .then(dists => {
                    const selectDist = document.getElementById("editDistrito");
                    selectDist.innerHTML = "";
                    dists.forEach(di => {
                        const option = document.createElement("option");
                        option.value = di.iddistrito;
                        option.textContent = di.nombre;
                        if (di.iddistrito == idDist) option.selected = true;
                        selectDist.appendChild(option);
                    });
                })
                .catch(err => console.error("Error al cargar ubicación:", err));

            modalPrincipal.classList.remove("show");
            modalUbicacion.classList.add("show");
        })
        .catch(err => {
            console.error("Error al obtener datos de ubicación:", err);
        });
});



    document.getElementById("btnLaborales").addEventListener("click", () => {
        modalPrincipal.classList.remove("show");
        modalLaborales.classList.add("show");
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

    document.querySelectorAll(".btn-save-edit").forEach(btn => {
        btn.addEventListener("click", (e) => {
            const modal = e.target.closest(".modal");
            const idEmpleado = modal.dataset.idEmpleado || modalPrincipal.dataset.idEmpleado;
            console.log("Guardar cambios del empleado ID:", idEmpleado, "en modal:", modal.id);
            modal.classList.remove("show");
        });
    });

    document.getElementById("editDepartamento").addEventListener("change", (e) => {
        let idDep = e.target.value;
        fetch(`../controller/EmpleadoController.php?action=provincias&idDepartamento=${idDep}`)
            .then(res => res.json())
            .then(provs => {
                let provSelect = document.getElementById("editProvincia");
                provSelect.innerHTML = provs.map(p => `<option value="${p.idprovincia}">${p.provincia}</option>`).join("");
                document.getElementById("editDistrito").innerHTML = "";
            });
    });

    document.getElementById("editProvincia").addEventListener("change", (e) => {
        let idProv = e.target.value;
        fetch(`../controller/EmpleadoController.php?action=distritos&idProvincia=${idProv}`)
            .then(res => res.json())
            .then(dists => {
                let distSelect = document.getElementById("editDistrito");
                distSelect.innerHTML = dists.map(di => `<option value="${di.iddistrito}">${di.distrito}</option>`).join("");
            });
    });

document.getElementById("editDepartamento").addEventListener("change", function () {
    const idDep = this.value;
    const provSelect = document.getElementById("editProvincia");
    const distSelect = document.getElementById("editDistrito");

    provSelect.innerHTML = '<option value="">Seleccione</option>';
    distSelect.innerHTML = '<option value="">Seleccione</option>';

    if (idDep) {
        fetch(`../controller/EmpleadoController.php?action=provincias&idDepartamento=${idDep}`)
            .then(res => res.json())
            .then(provs => {
                provs.forEach(p => {
                    const option = document.createElement("option");
                    option.value = p.idProvincia;
                    option.textContent = p.provincia;
                    provSelect.appendChild(option);
                });
            });
    }
});

document.getElementById("editProvincia").addEventListener("change", function () {
    const idProv = this.value;
    const distSelect = document.getElementById("editDistrito");

    distSelect.innerHTML = '<option value="">Seleccione</option>';

    if (idProv) {
        fetch(`../controller/EmpleadoController.php?action=distritos&idProvincia=${idProv}`)
            .then(res => res.json())
            .then(dists => {
                dists.forEach(di => {
                    const option = document.createElement("option");
                    option.value = di.idDistrito;
                    option.textContent = di.distrito;
                    distSelect.appendChild(option);
                });
            });
    }
});


});
