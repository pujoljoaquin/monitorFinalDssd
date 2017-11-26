<?php

namespace Monitor;

require '../includes/config.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'layout/defaultHead.php'; ?>

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">
        <!-- Navigation -->
        <?php include 'layout/navbar.php'; ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tareas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de Tareas Activas
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
                            $response = Task::getTasks();
                            if ($response['success']) {
                                $tasks = $response['data'];
                                ?>
                                <table class="table table-bordered" width="100%" id="tablaTasks"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Id del Proceso</th>
                                        <th>Nombre</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Tipo de Tarea</th>
                                        <th>Asignada</th>
                                        <th>Completada</th>
                                        <th>Prioridad</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($tasks as $task) {
                                   //     var_dump(Users::getUserUsername($task->assigned_id));
                                        var_dump(Users::getUserUserName($task->assigned_id));
                                        var_dump(Users::getUserInfo($task->assigned_id)[1]->role_id->displayName);
                                       // var_dump((Users::getUserInfo($task->assigned_id)[0])->role_id);
                                        echo '<tr>';
                                        echo '<td>' . $task->processId . '</td>';
                                        echo '<td>' . $task->displayName . '</td>';
                                        echo '<td>' . $task->description . '</td>';
                                        echo '<td>' . $task->type . '</td>';
                                        echo '<td>' . $task->assigned_date . '</td>';
                                        echo '<td>' . $task->reached_state_date . '</td>';
                                        echo '<td>' . $task->priority . '</td>';
                                        echo '<td>' . $task->state . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php
                            } else {
                                echo $response['message'];
                            }
                            ?>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de Tareas Archivadas
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <?php
                            $response = Task::getArchivedTasks();
                            if ($response['success']) {
                                $tasks = $response['data'];
                                ?>
                                <table class="table table-bordered" width="100%" id="tablaArchivedTasks"
                                       cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Id del Proceso</th>
                                        <th>Nombre</th>
                                        <th>Descripci&oacute;n</th>
                                        <th>Tipo de Tarea</th>
                                        <th>Asignada</th>
                                        <th>Completada</th>
                                        <th>Prioridad</th>
                                        <th>Estado</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($tasks as $task) {
                                        echo '<tr>';
                                        echo '<td>' . $task->processId . '</td>';
                                        echo '<td>' . $task->displayName . '</td>';
                                        echo '<td>' . $task->description . '</td>';
                                        echo '<td>' . $task->type . '</td>';
                                        echo '<td>' . $task->assigned_date . '</td>';
                                        echo '<td>' . $task->reached_state_date . '</td>';
                                        echo '<td>' . $task->priority . '</td>';
                                        echo '<td>' . $task->state . '</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            <?php
                            } else {
                                echo $response['message'];
                            }
                            ?>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

        </div>
        <!-- /#page-wrapper -->

        <canvas id="barChart"></canvas>

    </div>
    <!-- /#wrapper -->
    <?php include 'layout/defaultFooter.php'; ?>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
        $(document).ready( function() {
            $('#tablaTasks').dataTable( {
                "language": {
                    "lengthMenu": "Mostrar _MENU_ tareas",
                    "search": "Buscar: ",
                    "info": "Mostrando _START_ de _END_ de un total de _TOTAL_ tareas",
                    "infoEmpty":      "No hay tareas para mostrar",
                    "zeroRecords":    "No hay tareas para mostrar. Sin registros.",
                    "emptyTable":     "Tabla vacía",
                    "infoFiltered":   "(filtrados de un total de _MAX_ procesos)",
                    "paginate": {
                        "first":      "Primera",
                        "last":       "Última",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": ordenar ascendente",
                        "sortDescending": ": ordenar descendente"
                    }
                }
            } );

            $('#tablaArchivedTasks').dataTable( {
                "language": {
                    "lengthMenu": "Mostrar _MENU_ tareas",
                    "search": "Buscar: ",
                    "info": "Mostrando _START_ de _END_ de un total de _TOTAL_ tareas",
                    "infoEmpty":      "No hay tareas para mostrar",
                    "zeroRecords":    "No hay tareas para mostrar. Sin registros.",
                    "emptyTable":     "Tabla vacía",
                    "infoFiltered":   "(filtrados de un total de _MAX_ tareas)",
                    "paginate": {
                        "first":      "Primera",
                        "last":       "Última",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": ordenar ascendente",
                        "sortDescending": ": ordenar descendente"
                    }
                }
            } );
        } );
    </script>

    <script type="text/javascript">
        $( document ).ready(function() {
            var ctxP = document.getElementById("barChart").getContext('2d');
            var cantInspectorMueble = 0;
            var cantInspectorCasa = 0;
            var cantInspectorAuto = 0;
            <?php $response = Task::getTasks(); ?>
            <?php foreach ($response['data'] as $task): ?>
                <?php if((Users::getUserInfo($task->assigned_id)[1]->role_id->displayName)=="inspectorCasa"): ?>
                    cantInspectorCasa++;
                <?php endif; ?>
                <?php if((Users::getUserInfo($task->assigned_id)[1]->role_id->displayName)=="inspectorAuto"): ?>
                    cantInspectorAuto++;
                <?php endif; ?>
                <?php if((Users::getUserInfo($task->assigned_id)[1]->role_id->displayName)=="inspectorObjetoMueble"): ?>
                    cantInspectorMueble++;
                <?php endif; ?>
            <?php endforeach; ?>
            var myBarChart = new Chart(ctxP, {
                type: 'bar',
                data: {
                    labels: ["Inspector Auto", "Inspector Casa", "Inspector Objeto Mueble"],
                    datasets: [
                            {"label": "Cantidad de casos",
                            "data": [cantInspectorAuto,cantInspectorCasa,cantInspectorMueble],
                            "fill": false,
                            "backgroundColor": ["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)"],
                            "borderColor": ["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)"],
                            "borderWidth": 1}
                            //: ["#F7464A", "#46BFBD", "#FDB45C"],
                            //hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870"]
                    ]
                },
                options:{
                    "responsive": true,
                    "scales": 
                        {"yAxes":
                            [{"ticks":
                                {"beginAtZero":true}
                            }]
                        }
                }
            });
        });

    </script>



</body>

</html>
