<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permisos</title>
    <link rel="stylesheet" href="../public/css/siderbar.css">
    <link rel="stylesheet" href="../public/css/employee.css">
    <link rel="stylesheet" href="../public/css/employeedit.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .container { display: flex; }
        .content { flex: 1; padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <?php include 'Sidebar.php'; ?>
        <div class="content">
            <h1>Gestión de Permisos</h1>
            <p>Aquí puedes visualizar y administrar los permisos de empleados.</p>

            <div class="actions">
                <button class="btn-add">+ Agregar Permiso</button>
            </div>

            <!-- MODAL AGREGAR PERMISO -->
            <div id="modalPermiso" class="modal">
                <div class="modal-content">
                    <div class="modal-left">
                        <img src="../public/images/modalemp.jpg" alt="Permiso">
                    </div>
                    <div class="modal-right">
                        <div class="stepper">
                            <div class="step-wrapper">
                                <div class="step-number"></div>
                                <div class="step-label">Empleado</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step-wrapper">
                                <div class="step-number"></div>
                                <div class="step-label">Fechas</div>
                            </div>
                            <div class="step-line"></div>
                            <div class="step-wrapper">
                                <div class="step-number"></div>
                                <div class="step-label">Motivo</div>
                            </div>
                        </div>

                        <!-- Paso 1 -->
                        <div class="step step-1">
                            <div class="form-group">
                                <label for="empleado">Empleado</label>
                                <select id="empleado" name="empleado">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="tipo_permiso">Tipo de Permiso</label>
                                <select id="tipo_permiso" name="tipo_permiso">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>

                            <div class="form-buttons">
                                <button type="button" class="btn-cancel">Cancelar</button>
                                <div class="right-buttons">
                                    <button type="button" class="next-step">Siguiente</button>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 2 -->
                        <div class="step step-2" style="display: none;">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha Inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio">
                            </div>

                            <div class="form-group">
                                <label for="fecha_fin">Fecha Fin</label>
                                <input type="date" id="fecha_fin" name="fecha_fin">
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select id="estado" name="estado">
                                    <option value="">Seleccione</option>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Aprobado">Aprobado</option>
                                    <option value="Rechazado">Rechazado</option>
                                </select>
                            </div>

                            <div class="form-buttons">
                                <button type="button" class="btn-cancel">Cancelar</button>
                                <div class="right-buttons">
                                    <button type="button" class="prev-step">Anterior</button>
                                    <button type="button" class="next-step">Siguiente</button>
                                </div>
                            </div>
                        </div>

                        <!-- Paso 3 -->
                        <div class="step step-3" style="display:none">
                            <div class="form-group">
                                <label for="motivo">Motivo</label>
                                <textarea id="motivo" name="motivo" rows="4" placeholder="Ingrese el motivo..."></textarea>
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

            <!-- TABLA DE PERMISOS -->
            <div class="table-container">
                <table class="employee-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empleado</th>
                            <th>Tipo</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estado</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- MODAL ELIMINAR -->
            <div id="modalEliminarPermiso" class="modal-retiro">
                <div class="modal-content-retiro">
                    <h2>Eliminar Permiso</h2>
                    <p>¿Estás seguro que deseas eliminar este permiso?</p>
                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel-retiro">Cancelar</button>
                        <button type="button" class="btn-retirar">Eliminar</button>
                    </div>
                </div>
            </div>

            <!-- MODAL EDITAR -->
<div id="modal-edit" class="modal modal-edit">
  <div class="modal-edit-content">
    <h2 style="text-align: center; margin-bottom: 10px;">Editar Permiso</h2>
    <p style="text-align: center; margin-bottom: 25px;">Modifique los datos del permiso</p>

    <!-- oculto para guardar ID -->
    <input type="hidden" id="editIdPermiso">

    <div class="form-group">
      <label for="editEmpleado">Empleado</label>
      <select id="editEmpleado"></select>
    </div>

    <div class="form-group">
      <label for="editTipoPermiso">Tipo de Permiso</label>
      <select id="editTipoPermiso"></select>
    </div>

    <div class="form-group">
      <label for="editFechaInicio">Fecha Inicio</label>
      <input type="date" id="editFechaInicio">
    </div>

    <div class="form-group">
      <label for="editFechaFin">Fecha Fin</label>
      <input type="date" id="editFechaFin">
    </div>

    <div class="form-group">
      <label for="editEstado">Estado</label>
      <select id="editEstado">
        <option value="Pendiente">Pendiente</option>
        <option value="Aprobado">Aprobado</option>
        <option value="Rechazado">Rechazado</option>
      </select>
    </div>

    <div class="form-group">
      <label for="editMotivo">Motivo</label>
      <textarea id="editMotivo" rows="3"></textarea>
    </div>

    <div class="modal-buttons">
      <button class="btn-save-edit" id="btnSavePermiso">Guardar</button>
      <button class="btn-cancel-edit">Cancelar</button>
    </div>
  </div>
</div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/modaladdPer.js"></script>
    <script src="../public/js/tablepermisos.js"></script>
    <script src="../public/js/modaldelPer.js"></script>
    <script src="../public/js/modaleditPer.js"></script>
</body>
</html>

