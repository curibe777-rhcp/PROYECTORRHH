document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("modalPermiso");
    const btnAdd = document.querySelector(".btn-add");

    const stepCircles = document.querySelectorAll('.step-number');
    const stepLabels = document.querySelectorAll('.step-label');
    const stepLines  = document.querySelectorAll('.step-line');
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;

    // Abrir modal
    btnAdd.addEventListener("click", () => modal.classList.add("show"));
    modal.addEventListener("click", (e) => { if (e.target === modal) modal.classList.remove("show"); });

    // Actualizar stepper
    function updateStepVisual() {
        stepCircles.forEach((circle, index) => {
            circle.classList.remove('active', 'completed');
            stepLabels[index].classList.remove('active-label');
            if (index < currentStep) {
                circle.classList.add('completed');
                circle.innerHTML = '<i class="fas fa-check"></i>';
            } else if (index === currentStep) {
                circle.classList.add('active');
                circle.innerHTML = '<i class="fas fa-lock"></i>';
            } else {
                circle.innerHTML = '<i class="fas fa-lock"></i>';
            }
        });

        steps.forEach((step, index) => {
            step.style.display = (index === currentStep) ? "block" : "none";
        });
    }

    document.querySelectorAll('.next-step').forEach(btn => {
        btn.addEventListener("click", () => {
            const inputs = steps[currentStep].querySelectorAll("input, select, textarea");
            let vacios = false;
            inputs.forEach(i => { if (!i.value.trim()) vacios = true; });
            if (vacios) {
                Swal.fire("Campos vacíos", "Completa todos los campos antes de continuar", "warning");
                return;
            }
            if (currentStep < steps.length - 1) {
                currentStep++;
                updateStepVisual();
            }
        });
    });

    document.querySelectorAll('.prev-step').forEach(btn => {
        btn.addEventListener("click", () => {
            if (currentStep > 0) {
                currentStep--;
                updateStepVisual();
            }
        });
    });

    // Botón cancelar
    document.querySelectorAll('.btn-cancel').forEach(btn => {
        btn.addEventListener("click", () => modal.classList.remove("show"));
    });

    updateStepVisual();

    // Guardar
    document.querySelector(".save-step").addEventListener("click", async () => {
        const data = {
            idEmpleado: document.getElementById("idEmpleado").value,
            idTipoPermiso: document.getElementById("tipo_permiso").value,
            fechaInicio: document.getElementById("fecha_inicio").value,
            fechaFin: document.getElementById("fecha_fin").value,
            estado: document.getElementById("estado_permiso").value,
            motivo: document.getElementById("motivo").value.trim()
        };

        if (Object.values(data).some(v => v === "")) {
            Swal.fire("Campos vacíos", "Completa todos los campos antes de guardar", "warning");
            return;
        }

        try {
            const response = await fetch("../controller/PermisoController.php?action=registrarPermiso", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (result.success) {
                Swal.fire("Éxito", "Permiso registrado correctamente", "success");
                modal.classList.remove("show");
                location.reload();
            } else {
                Swal.fire("Error", result.error || "No se pudo registrar el permiso", "error");
            }
        } catch (err) {
            console.error(err);
            Swal.fire("Error", "Error en la conexión con el servidor", "error");
        }
    });

    // Cargar combos
    async function cargarCombos() {
        try {
            const empleadosRes = await fetch("../controller/PermisoController.php?action=listarEmpleados");
            const empleados = await empleadosRes.json();
            const selectEmp = document.getElementById("idEmpleado");
            selectEmp.innerHTML = '<option value="">Seleccione</option>';
            empleados.forEach(e => {
                const opt = document.createElement("option");
                opt.value = e.idEmpleado;
                opt.textContent = `${e.nombres} ${e.apellidos}`;
                selectEmp.appendChild(opt);
            });

            const tiposRes = await fetch("../controller/PermisoController.php?action=tiposPermiso");
            const tipos = await tiposRes.json();
            const selectTipo = document.getElementById("tipo_permiso");
            selectTipo.innerHTML = '<option value="">Seleccione</option>';
            tipos.forEach(t => {
                const opt = document.createElement("option");
                opt.value = t.idTipoPermiso;
                opt.textContent = t.tipoPermiso;
                selectTipo.appendChild(opt);
            });
        } catch (err) {
            console.error("Error cargando combos:", err);
        }
    }

    cargarCombos();
});
