<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contratos</title>
    <link rel="stylesheet" href="../public/css/siderbar.css">
    <link rel="stylesheet" href="../public/css/employee.css"><!-- reutilizado -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">
        <?php include 'Sidebar.php'; ?>
        <div class="content">
            <h1>Gestión de Contratos</h1>
            <p>Aquí puedes visualizar y administrar los contratos.</p>

            <div class="actions">
                <button class="btn-add" id="btnAddContrato">+ Agregar Contrato</button>
            </div>

            <!-- MODAL REGISTRAR CONTRATO -->
            <div id="modalContrato" class="modal">
                <div class="modal-content">
                    <div class="modal-left">
                        <img src="../public/images/modalemp.jpg" alt="Contrato">
                    </div>
                    <div class="modal-right">
                        <h2>Registrar Contrato</h2>

                        <div class="form-group">
                            <label for="empleado">Empleado</label>
                            <select id="empleado" name="empleado">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="fechaInicio">Fecha Inicio</label>
                            <input type="date" id="fechaInicio" name="fechaInicio">
                        </div>

                        <div class="form-group">
                            <label for="fechaFin">Fecha Fin</label>
                            <input type="date" id="fechaFin" name="fechaFin">
                        </div>

                        <div class="form-group">
                            <label for="tipoContrato">Tipo de Contrato</label>
                            <select id="tipoContrato" name="tipoContrato">
                                <option value="">Seleccione</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="estadoContrato">Estado</label>
                            <select id="estadoContrato" name="estadoContrato">
                                <!-- Se llenará dinámicamente -->
                            </select>
                        </div>

                        <div class="form-buttons">
                            <button type="button" class="btn-cancel">Cancelar</button>
                            <button type="button" class="save-step" id="btnGuardarContrato">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL EDITAR CONTRATO -->
            <div id="modalEditContrato" class="modal">
                <div class="modal-content">
                    <div class="modal-left">
                        <img src="../public/images/modalemp.jpg" alt="Contrato">
                    </div>
                    <div class="modal-right">
                        <h2>Editar Contrato</h2>

                        <input type="hidden" id="editIdContrato">

                        <div class="form-group">
                            <label for="editFechaInicio">Fecha Inicio</label>
                            <input type="date" id="editFechaInicio" name="editFechaInicio">
                        </div>

                        <div class="form-group">
                            <label for="editFechaFin">Fecha Fin</label>
                            <input type="date" id="editFechaFin" name="editFechaFin">
                        </div>

                        <div class="form-group">
                            <label for="editTipoContrato">Tipo de Contrato</label>
                            <select id="editTipoContrato" name="editTipoContrato"></select>
                        </div>

                        <div class="form-group">
                            <label for="editEstadoContrato">Estado</label>
                            <select id="editEstadoContrato" name="editEstadoContrato"></select>
                        </div>

                        <div class="form-buttons">
                            <button type="button" class="btn-cancel-edit">Cancelar</button>
                            <button type="button" class="save-step" id="btnActualizarContrato">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABLA CONTRATOS -->
            <div class="table-container">
                <table class="employee-table"><!-- reutilizado estilo -->
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empleado</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyContratos">
                        <!-- Se llena con JS -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../public/js/modaladdContrato.js"></script>
    <script src="../public/js/modaleditContrato.js"></script>
    <script src="../public/js/tablecontract.js"></script>
</body>

</html>