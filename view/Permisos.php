<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permisos</title>
    <link rel="stylesheet" href="../public/css/siderbar.css">
    <link rel="stylesheet" href="../public/css/permisos.css">
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
            <h1>Gestión de Permisos</h1>
            <p>Aquí puedes visualizar y administrar los permisos de los empleados.</p>

            <!-- Botón agregar -->
            <div class="actions">
                <button class="btn-add">+ Agregar Permiso</button>
            </div>

            <!-- Modal registrar permiso -->
            <div id="modalPermiso" class="modal">
                <div class="modal-content">
                    <div class="modal-left">
                        <img src="../public/images/permiso.jpg" alt="Permiso">
                    </div>
                    <div class="modal-right">
                        <h2>Registrar Permiso</h2>

                        <div class="form-group">
                            <label for="idEmpleado">Empleado</label>
                            <select id="idEmpleado">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="idTipoPermiso">Tipo de Permiso</label>
                            <select id="idTipoPermiso">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="idMotivoPermiso">Motivo</label>
                            <select id="idMotivoPermiso">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fechaInicio">Fecha Inicio</label>
                            <input type="datetime-local" id="fechaInicio">
                        </div>

                        <div class="form-group">
                            <label for="fechaFin">Fecha Fin</label>
                            <input type="datetime-local" id="fechaFin">
                        </div>
                        <div class="form-group">
                            <label for="estadoPermiso">Estado</label>
                            <select id="estadoPermiso">
                                <option value="">Seleccione</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" rows="3"></textarea>
                        </div>

                        <div class="form-buttons">
                            <button type="button" class="btn-cancel">Cancelar</button>
                            <div class="right-buttons">
                                <button type="button" class="btn-save">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla permisos -->
            <div class="table-container">
                <table class="permission-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empleado</th>
                            <th>Tipo</th>
                            <th>Motivo</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Estado</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Filas cargadas dinámicamente -->
                    </tbody>
                </table>
            </div>

            <!-- Modal eliminar -->
            <div id="modalEliminarPermiso" class="modal-retiro">
                <div class="modal-content-retiro">
                    <h2>Eliminar Permiso</h2>
                    <p>¿Estás seguro de que quieres eliminar este permiso? Esta acción no se puede deshacer.</p>
                    <div class="modal-buttons">
                        <button type="button" class="btn-cancel-eliminar">Cancelar</button>
                        <button type="button" class="btn-eliminar">Eliminar</button>
                    </div>
                </div>
            </div>

            <!-- Modal editar -->
            <div id="modal-edit-permiso" class="modal modal-edit">
                <div class="modal-edit-content">
                    <h2 style="text-align: center; margin-bottom: 15px;">Editar Permiso</h2>
                    
                    <div class="form-group">
                        <label for="editEmpleado">Empleado</label>
                        <select id="editEmpleado">
                            <option value="">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editTipoPermiso">Tipo de Permiso</label>
                        <select id="editTipoPermiso">
                            <option value="">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editMotivo">Motivo</label>
                        <select id="editMotivo">
                            <option value="">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="editFechaInicio">Fecha Inicio</label>
                        <input type="datetime-local" id="editFechaInicio">
                    </div>

                    <div class="form-group">
                        <label for="editFechaFin">Fecha Fin</label>
                        <input type="datetime-local" id="editFechaFin">
                    </div>

                    <div class="form-group">
                        <label for="editDescripcion">Descripción</label>
                        <textarea id="editDescripcion" rows="3"></textarea>
                    </div>

                    <div class="modal-buttons">
                        <button class="btn-save-edit" id="btnSavePermiso">Guardar</button>
                        <button class="btn-cancel-edit-permiso">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/modaladdPer.js"></script>
    <script src="../public/js/modaldelPer.js"></script>
    <script src="../public/js/modaleditPer.js"></script>
    <script src="../public/js/tablepermisos.js"></script>
</body>
</html>
