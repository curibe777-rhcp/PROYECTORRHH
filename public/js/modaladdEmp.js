document.addEventListener("DOMContentLoaded", function() {
    const btnAdd = document.querySelector(".btn-add");
    const modal = document.getElementById("modalEmpleado");

    btnAdd.addEventListener("click", function() {
        modal.classList.add("show");
    });

    modal.addEventListener("click", function(e) {
        if (e.target === this) {
            modal.classList.remove("show");
        }
    });

    const stepCircles = document.querySelectorAll('.step-number');
    const stepLabels = document.querySelectorAll('.step-label');
    const stepLines  = document.querySelectorAll('.step-line');
    let currentStep = 0;
    const steps = document.querySelectorAll('.step');

    function updateStepVisual() {
    stepCircles.forEach((circle, index) => {
        circle.classList.remove('active', 'completed');
        stepLabels[index].classList.remove('active-label');

        if(index < currentStep) {
            circle.classList.add('completed');
            circle.innerHTML = '<i class="fas fa-check"></i>';
            stepLabels[index].classList.add('active-label');
        } else if(index === currentStep) {
            circle.classList.add('active');
            circle.innerHTML = '<i class="fas fa-lock"></i>';
            stepLabels[index].classList.add('active-label');
        } else {
            circle.innerHTML = '<i class="fas fa-lock"></i>';
        }
    });

    stepLines.forEach((line, index) => {
        if(index < currentStep - 1) {
            line.style.background = 'green';
        } else if(index === currentStep - 1) {
            line.style.background = 'green';
        } else if(index === currentStep) {
            line.style.background = 'linear-gradient(to right, purple 50%, gray 50%)';
        } else {
            line.style.background = 'gray';
        }
    });

    steps.forEach((step, index) => {
        if(index === currentStep) {
            step.style.display = 'block';
        } else {
            step.style.display = 'none';
        }
    });

}

    document.querySelectorAll('.next-step').forEach(btn => {
    btn.addEventListener('click', () => {
        const currentStepDiv = steps[currentStep];
        const inputs = currentStepDiv.querySelectorAll('input, select, textarea');
        let camposVacios = false;

        inputs.forEach(input => {
            if (input.value.trim() === '') {
                camposVacios = true;
            }
        });

        if (camposVacios) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos vacíos',
                text: 'Hay uno o más campos vacíos. Por favor complete todos los campos para continuar.',
                confirmButtonColor: '#007bff'
            });
        } else {
            if(currentStep < stepCircles.length -1) {
                currentStep++;
                updateStepVisual();
            }
        }
    });
});

    document.querySelectorAll('.prev-step').forEach(btn => {
        btn.addEventListener('click', () => {
            if(currentStep > 0) {
                currentStep--;
                updateStepVisual();
            }
        });
    });

    updateStepVisual();


    document.querySelectorAll('.btn-cancel').forEach(btn => {
    btn.addEventListener('click', () => {
        const inputs = modal.querySelectorAll('input, select, textarea');
        let hayCambios = false;

        inputs.forEach(input => {
            if (input.value.trim() !== '') {
                hayCambios = true;
            }
        });

        const resetModal = () => {
            inputs.forEach(input => input.value = '');
            currentStep = 0;
            updateStepVisual();
            modal.classList.remove('show');
        };

        if (!hayCambios) {
            resetModal();
        } else {
            Swal.fire({
                title: '¿Seguro que quieres salir?',
                text: "Si sales, perderás los datos que ingresaste.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    resetModal();
                }
            });
        }
    });
});

 fetch("../controller/EmpleadoController.php?action=tiposDocumento")
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById("tipo_documento");
            if (select) {
                data.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.idTipoDocumento;
                    option.textContent = item.tipoDocumento;
                    select.appendChild(option);
                });
            }
        })
        .catch(error => console.error("Error cargando tipos de documento:", error));

fetch("../controller/EmpleadoController.php?action=departamentos")
    .then(response => response.json())
    .then(data => {
        const select = document.getElementById("departamento");
        if (select) {
            data.forEach(item => {
                const option = document.createElement("option");
                option.value = item.idDepartamento;
                option.textContent = item.departamento;
                select.appendChild(option);
            });
        }
    })
    .catch(error => console.error("Error cargando departamentos:", error));

    const departamentoSelect = document.getElementById("departamento");
    const provinciaSelect = document.getElementById("provincia");

    if (departamentoSelect && provinciaSelect) {
        departamentoSelect.addEventListener("change", function() {
            const idDepartamento = this.value;

            provinciaSelect.innerHTML = '<option value="">Seleccione</option>';
            distritoSelect.innerHTML = "<option value=''>Seleccione</option>";

            if (idDepartamento) {
                fetch(`../controller/EmpleadoController.php?action=provincias&idDepartamento=${idDepartamento}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            const option = document.createElement("option");
                            option.value = item.idProvincia;
                            option.textContent = item.provincia;
                            provinciaSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Error cargando provincias:", error));
            }
        });
    }


    const distritoSelect = document.getElementById("distrito");

    if (provinciaSelect && distritoSelect) {
        provinciaSelect.addEventListener("change", function() {
            const idProvincia = this.value;

            distritoSelect.innerHTML = '<option value="">Seleccione</option>';

            if (idProvincia) {
                fetch(`../controller/EmpleadoController.php?action=distritos&idProvincia=${idProvincia}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(item => {
                            const option = document.createElement("option");
                            option.value = item.idDistrito;
                            option.textContent = item.distrito;
                            distritoSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error("Error cargando distritos:", error));
            }
        });
    }


    const areaTrabajoSelect = document.getElementById("area_trabajo");

    fetch("../controller/EmpleadoController.php?action=areasTrabajo")
        .then(response => response.json())
        .then(data => {
            areaTrabajoSelect.innerHTML = '<option value="">Seleccione</option>';

            data.forEach(area => {
                const option = document.createElement("option");
                option.value = area.idAreaTrabajo;
                option.textContent = area.areaTrabajo;
                areaTrabajoSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error al cargar áreas de trabajo:", error);
        });

        


    const cargoSelect = document.getElementById("cargo");

    areaTrabajoSelect.addEventListener("change", function () {
        const idAreaTrabajo = this.value;

        cargoSelect.innerHTML = '<option value="">Seleccione</option>';

        if (idAreaTrabajo) {
            fetch(`../controller/EmpleadoController.php?action=cargos&idAreaTrabajo=${idAreaTrabajo}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(cargo => {
                        const option = document.createElement("option");
                        option.value = cargo.idCargo;
                        option.textContent = cargo.cargo;
                        cargoSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Error al cargar cargos:", error);
                });
        }
    });


    document.querySelector(".save-step").addEventListener("click", async () => {
    const currentStepDiv = steps[currentStep];
    const inputs = currentStepDiv.querySelectorAll("input, select, textarea");
    let camposVacios = false;

    inputs.forEach(input => {
        if (input.value.trim() === "") {
            camposVacios = true;
        }
    });

     const resetModal = () => {
        const inputs = modal.querySelectorAll('input, select, textarea');
        inputs.forEach(input => input.value = '');
        currentStep = 0;
        updateStepVisual();
        modal.classList.remove('show');
    };

    if (camposVacios) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos vacíos',
            text: 'Hay uno o más campos vacíos. Por favor complete todos los campos para continuar.',
            confirmButtonColor: '#007bff'
        });
        return;
    }

    Swal.fire({
        title: "¿Deseas continuar?",
        text: "⚠️ Si guardas, no podrás modificar algunos campos más adelante.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, guardar",
        cancelButtonText: "Cancelar"
    }).then(async (result) => {
        if (result.isConfirmed) {
            const data = {
                nombres: document.getElementById("nombre").value.trim(),
                apellidoPaterno: document.getElementById("apellido_paterno").value.trim(),
                apellidoMaterno: document.getElementById("apellido_materno").value.trim(),
                idTipoDocumento: document.getElementById("tipo_documento").value,
                numeroDocumento: document.getElementById("numero_documento").value.trim(),
                idDepartamento: document.getElementById("departamento").value,
                idProvincia: document.getElementById("provincia").value,
                idDistrito: document.getElementById("distrito").value,
                direccion: document.getElementById("direccion").value.trim(),
                telefono: document.getElementById("telefono3").value.trim(),
                email: document.getElementById("email3").value.trim(),
                fechaNacimiento: document.getElementById("fecha_nacimiento").value,
                fechaIngreso: document.getElementById("fecha_ingreso").value,
                idAreaTrabajo: document.getElementById("area_trabajo").value,
                idCargo: document.getElementById("cargo").value,
                salario: document.getElementById("salario").value,
                usuario_reg: 3 
            };

            try {
                const response = await fetch("../controller/EmpleadoController.php?action=registrarEmpleadoUsuario", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                console.log("Respuesta:", result);

                if (result.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Empleado creado",
                        text: "✅ Empleado y usuario creados correctamente",
                        timer: 2000,
                        showConfirmButton: false
                    });

                    resetModal();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "❌ " + result.error
                    });
                }
            } catch (error) {
                console.error("Error en fetch:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error inesperado",
                    text: "Ocurrió un error al registrar el empleado"
                });
            }
        }
    });
});

});

