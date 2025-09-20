<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados</title>
    <link rel="stylesheet" href="../public/css/siderbar.css">
    <link rel="stylesheet" href="../public/css/employee.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    

    <style>
        .container {
            display: flex;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'Sidebar.php'; ?>
        <div class="content">
    <h1>Gestión de Empleados</h1>
    <p>Aquí puedes visualizar y administrar a los empleados.</p>

    <div class="actions">
        <button class="btn-add">+ Agregar Empleado</button>
    </div>

    <!--MODAL EMPLEADO-->
    <div id="modalEmpleado" class="modal">
    <div class="modal-content">
        <div class="modal-left">
            <img src="../public/images/modalemp.jpg" alt="Empleado">
        </div>
        <div class="modal-right">
             <div class="stepper">
                <div class="step-wrapper">
                    <div class="step-number"></div>
                    <div class="step-label">Datos Personales (1/3)</div>
                </div>
                <div class="step-line"></div>
                <div class="step-wrapper">
                    <div class="step-number"></div>
                    <div class="step-label">Datos Personales (2/3)</div>
                </div>
                <div class="step-line"></div>
                <div class="step-wrapper">
                    <div class="step-number"></div>
                    <div class="step-label">Datos Laborales</div>
                </div>
            </div>

            <div class="step step-1">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre">
            </div>

            <div class="form-group">
                <label for="apellido_paterno">Apellido Paterno</label>
                <input type="text" id="apellido_paterno" name="apellido_paterno">
            </div>

            <div class="form-group">
                <label for="apellido_materno">Apellido Materno</label>
                <input type="text" id="apellido_materno" name="apellido_materno">
            </div>

            <div class="form-group">
                <label for="tipo_documento">Tipo de Documento</label>
                <select id="tipo_documento" name="tipo_documento">
                    <option value="">Seleccione</option>
                </select>
            </div>

            <div class="form-group">
                <label for="numero_documento">Número de Documento</label>
                <input type="number" id="numero_documento" name="numero_documento">
            </div>

                <div class="form-buttons">
                    <button type="button" class="btn-cancel">Cancelar</button>
                    <div class="right-buttons">
                        <button type="button" class="next-step">Siguiente</button>
                    </div>
                </div>
            </div>

            <div class="step step-2" style="display: none;">

                

                <div class="form-group">
                    <label for="departamento">Departamento</label>
                    <select id="departamento" name="departamento">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="provincia">Provincia</label>
                    <select id="provincia" name="provincia">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="distrito">Distrito</label>
                    <select id="distrito" name="distrito">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion">
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                </div>

                <div class="form-buttons">
                    <button type="button" class="btn-cancel">Cancelar</button>
                    <div class="right-buttons">
                        <button type="button" class="prev-step">Anterior</button>
                        <button type="button" class="next-step">Siguiente</button>
                    </div>
                </div>
            </div>

            <div class="step step-3" style="display:none">
                
                <div class="form-group">
                    <label for="telefono3">Teléfono</label>
                    <input type="text" id="telefono3" name="telefono3">
                </div>

                <div class="form-group">
                    <label for="email3">Email</label>
                    <input type="text" id="email3" name="email3">
                </div>

                <div class="form-group">
                    <label for="fecha_ingreso">Fecha de Ingreso</label>
                    <input type="date" id="fecha_ingreso" name="fecha_ingreso">
                </div>

                <div class="form-group">
                    <label for="area_trabajo">Área de Trabajo</label>
                    <select id="area_trabajo" name="area_trabajo">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cargo">Cargo</label>
                    <select id="cargo" name="cargo">
                        <option value="">Seleccione</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="salario">Salario</label>
                    <input type="number" id="salario" name="salario">
                </div>

                <div class="form-buttons">
                    <button type="button" class="btn-cancel">Cancelar</button>
                    <div class="right-buttons">
                        <button type="button" class="prev-step">Anterior</button>
                        <button type="button" class="save-step">Guardar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


         


    <div class="table-container">
        <table class="employee-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Nro de Documento</th>
                    <th>Email</th>
                    <th>Area de Trabajo</th>
                    <th>Cargo</th>
                    <th>Estado</th>
                    <th>Acciones</th>

                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>
    </div>
</div>

        <div id="modalRetiro" class="modal-retiro">
        <div class="modal-content-retiro">
            <h2>Retirar Empleado</h2>
            <p>Por favor seleccione el motivo y agregue una descripción antes de retirar al empleado.</p>

            <div class="form-group">
                <label for="motivo_retiro">Motivo</label>
                <select id="motivo_retiro" name="motivo_retiro">
                    <option value="">Seleccione el motivo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="descripcion_retiro">Descripción</label>
                <textarea id="descripcion_retiro" name="descripcion_retiro" rows="4" placeholder="Describa el motivo del retiro..."></textarea>
            </div>

            <div class="modal-buttons">
                <button type="button" class="btn-cancel-retiro">Cancelar</button>
                <button type="button" class="btn-retirar">Retirar</button>
            </div>
        </div>
    </div>



<!-- MODAL EDITAR: Selección de sección a editar -->
<div id="modal-edit" class="modal-edit">
    <div class="modal-edit-content">
        <h2 style="text-align: center; margin-bottom: 10px;">Editar Empleado</h2>
        <p style="text-align: center; margin-bottom: 25px;">Seleccione una sección a editar</p>

        <div class="modal-edit-buttons">
            <button id="btnDatos" class="btn-edit-section">Datos Personales</button>
            <button id="btnUbicacion" class="btn-edit-section">Ubicación</button>
            <button id="btnLaborales" class="btn-edit-section">Datos Laborales</button>
        </div>

        <div class="modal-edit-footer">
            <button class="btn-cancel-edit">Cancelar</button>
        </div>
    </div>
</div>

<div id="modalDatos" class="modal modal-datos">
    <div class="modal-content">
        <h2>Editar Datos Personales</h2>
        <div class="form-group">
            <label for="editNombre">Nombre</label>
            <input type="text" id="editNombre">
        </div>
        <div class="form-group">
            <label for="editApellidoP">Apellido Paterno</label>
            <input type="text" id="editApellidoP">
        </div>
        <div class="form-group">
            <label for="editApellidoM">Apellido Materno</label>
            <input type="text" id="editApellidoM">
        </div>
        <div class="modal-buttons">
            <button class="btn-save-edit">Guardar</button>
            <button class="btn-cancel-edit">Cancelar</button>
        </div>
    </div>
</div>

<div id="modalUbicacion" class="modal modal-ubicacion">
    <div class="modal-content">
        <h2>Editar Ubicación</h2>
        <div class="form-group">
            <label for="editDepartamento">Departamento</label>
            <select id="editDepartamento"></select>
        </div>
        <div class="form-group">
            <label for="editProvincia">Provincia</label>
            <select id="editProvincia"></select>
        </div>
        <div class="form-group">
            <label for="editDistrito">Distrito</label>
            <select id="editDistrito"></select>
        </div>
        <div class="form-group">
            <label for="editDireccion">Dirección</label>
            <input type="text" id="editDireccion">
        </div>
        <div class="modal-buttons">
            <button class="btn-save-edit">Guardar</button>
            <button class="btn-cancel-edit">Cancelar</button>
        </div>
    </div>
</div>

<div id="modalLaborales" class="modal modal-laborales">
    <div class="modal-content">
        <h2>Editar Datos Laborales</h2>
        <div class="form-group">
            <label for="editArea">Área de Trabajo</label>
            <select id="editArea"></select>
        </div>
        <div class="form-group">
            <label for="editCargo">Cargo</label>
            <select id="editCargo"></select>
        </div>
        <div class="form-group">
            <label for="editTelefono">Teléfono</label>
            <input type="text" id="editTelefono">
        </div>
        <div class="form-group">
            <label for="editSalario">Salario</label>
            <input type="number" id="editSalario" step="0.01">
        </div>
        <div class="modal-buttons">
            <button class="btn-save-edit">Guardar</button>
            <button class="btn-cancel-edit">Cancelar</button>
        </div>
    </div>
</div>


         
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/modaladdEmp.js"></script>
    <script src="../public/js/tableemployee.js"></script>
    <script src="../public/js/modaldelEmp.js"></script>
    <script src="../public/js/modaleditEmp.js"></script>
</body>
</html>