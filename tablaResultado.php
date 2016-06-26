<div>
    <h2>% de Esfuerzo total <?php if ($cantHoras->horas < 30) { echo "<label class=\"label label-success\">$cantHoras->horas</label>";} elseif ($cantHoras->horas >= 30 AND $cantHoras->horas <= 35) { echo "<label class=\"label label-warning\">$cantHoras->horas</label>"; } else echo "<lablel class=\"label label-danger\">$cantHoras->horas</lablel>"?></h2>
    <?php if ($cantHoras->horas > 40) :?>
        <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Sobrecarga de esfuerzo en el proyecto</strong>
        </div>
    <?php endif;?>
    <div class="row">
        <div class="col-md-8">
            <table class="table table-striped table-hover ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Proyecto</th>
                    <th>Esfuerzo</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>#</th>
                    <th>Proyecto</th>
                    <th>Esfuerzo</th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>
                <?php for ($i = 0 ; $i < count($tabla) ; $i++): ?>
                    <tr <?php if (isset($_GET['lineaModif']) AND $_GET['lineaModif'] === $tabla[$i]->id_cargahoras ) { echo 'class="warning"';}?>>
                        <td><?=$tabla[$i]->id_cargahoras?></td>
                        <td><?=$tabla[$i]->proyecto; ?></td>
                        <td><?=$tabla[$i]->horas;?></td>
                        <td><a href="#" data-toggle="modal" data-target="#myModal<?=$i;?>" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span></a></td>
                        <td><a href="deleteTask.php?linea=<?=$tabla[$i]->id_cargahoras?><?php if (isset($_GET['proyecto'])) { echo "&amp;proyecto=".$tabla[$i]->id_proyecto;}?>&amp;usuario=<?=$_SESSION['user']->id_usuario;?>&amp;semana=<?=$_GET['semana'];?>" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a></td>
                    </tr>
                <?php endfor;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div>
<?php for ($i = 0 ; $i < count($tabla) ; $i++): ?>
    <div class="modal fade" id="myModal<?=$i;?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Modificar esfuerzo de proyecto <?=$tabla[$i]->proyecto;?></h4>
                </div>
                <div class="modal-body">
                    <h5><label class="label label-info">Cantidad maxima de esfuerzo a imputar <?=$horasDisponibles->horas_habiles - $cantHoras->horas?></label></h5>
                    <form method="get" action="modifyTask.php">
                        <label for="horaModificada"></label> la carga <input type="number" value="<?=$tabla[$i]->horas?>" max="<?=$horasDisponibles->horas_habiles - $cantHoras->horas;?>" style="width: 50px;" id="horaModificada" name="nuevaCarga">
                        <input type="hidden" name="linea" value="<?=$tabla[$i]->id_cargahoras?>">
                        <input type="hidden" name="cargaActual" value="<?=$tabla[$i]->horas?>">
                        <?php if (isset($_GET['proyecto'])) :?>
                            <input type="hidden" name="proyecto" value="<?=$tabla[$i]->id_proyecto?>">
                        <?php endif;?>
                        <input type="hidden" name="usuario" value="<?=$_SESSION['user']->id_usuario?>">
                        <input type="hidden" name="semana" value="<?=$_GET['semana'];?>">
                        <button class="btn btn-danger" type="submit">Modificar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endfor;?>
</div>