<?php
session_start();
include_once 'includes/functions.php';
sessionTimeOut();
sessioncheck(1);

include_once 'includes/db.php';
$semana = date('W');
$mostrarTabla = false;
$requete = $pdo->query('SELECT * FROM usuarios');
$users = $requete->fetchAll();
$req = 'SELECT proyectos.proyecto, proyectos.id_proyecto, cargahoras.horas, cargahoras.id_cargahoras
                            FROM cargahoras
                            LEFT JOIN proyectos ON proyectos.id_proyecto = cargahoras.id_proyecto
                            LEFT JOIN semanas ON semanas.id_semana = cargahoras.id_semana
                            WHERE cargahoras.id_usuario = ? AND cargahoras.id_semana = ?';
//    echo '<pre>';
//    print_r($_GET);
//    echo '</pre>';

if (isset($_SESSION['user']->id_usuario)) {
    $requeteProyectos = $pdo->prepare('SELECT proyectos.proyecto, proyectos.id_proyecto, usuarios.usuario FROM asignacion
                                       LEFT JOIN proyectos ON proyectos.id_proyecto = asignacion.id_proyecto
                                       LEFT JOIN usuarios ON usuarios.id_usuario = asignacion.id_usuario
                                       WHERE asignacion.id_usuario = ? AND proyectos.inactivo IS NULL');
    $requeteProyectos->execute([$_SESSION['user']->id_usuario]);
    $proyectosDisponibles = $requeteProyectos->fetchAll();
    if (empty($proyectosDisponibles)) {
        $_SESSION['usuarioSinAsignacion'] = "No asignado";
        header('Location: cargaHoras.php');
        exit();
    }
}

if (isset($_SESSION['user']->id_usuario,$_GET['semana'])) {
    $mostrarTabla = true;
    $requete = $pdo->prepare($req);
    $requete->execute([$_SESSION['user']->id_usuario,$_GET['semana']]);
    $requeteHorasTotal = $pdo->prepare('SELECT sum(cargahoras.horas) as horas FROM cargahoras WHERE cargahoras.id_usuario = ? AND cargahoras.id_semana = ?');
    $requeteHorasTotal->execute([$_SESSION['user']->id_usuario,$_GET['semana']]);
    $cantHoras = $requeteHorasTotal->fetch();
    $tabla = $requete->fetchAll();
    $queryCantDisponible = $pdo->prepare('SELECT semanas.horas_habiles FROM semanas WHERE id_semana = ?');
    $queryCantDisponible->execute([$_GET['semana']]);
    $horasDisponibles = $queryCantDisponible->fetch();
}

if (!empty($_SESSION['user']->id_usuario) AND !empty($_GET['proyecto']) AND !empty($_GET['horas']) AND !empty($_GET['carga'])){
    $mostrarTabla = true;
    // carga * 40 / 100 e insertarlo
    $carga = $_GET['horas'] * 40 / 100;
    $requeteInsert = $pdo->prepare('INSERT INTO cargahoras SET id_proyecto = ?, id_usuario = ?, id_semana = ?, horas = ? ');
    $requeteInsert->execute([$_GET['proyecto'],$_SESSION['user']->id_usuario,$_GET['semana'],$_GET['horas']]);
    $requete = $pdo->prepare($req);
    $requete->execute([$_SESSION['user']->id_usuario,$_GET['semana']]);
    $tabla = $requete->fetchAll();
    $requeteHorasTotal = $pdo->prepare('SELECT sum(cargahoras.horas) as horas FROM cargahoras WHERE cargahoras.id_usuario = ? AND cargahoras.id_semana = ?');
    $requeteHorasTotal->execute([$_SESSION['user']->id_usuario,$_GET['semana']]);
    $cantHoras = $requeteHorasTotal->fetch();
}

include_once 'includes/header.php'
?>
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <form class="form-horizontal" method="get">
                <fieldset>
                    <legend>Carga de esfuerzo</legend>
                    <?php if (isset($_SESSION['user']->id_usuario)):?>
                        <div class="form-group">
                            <label for="semana" class="col-lg-2 control-label">Semana</label>
                            <div class="col-lg-10">
                                <select name="semana" id="semana" <?php if (isset($_GET['semana'])) {echo "disabled"; } ?>>
                                <?php for($i = $semana ; $i > $semana-3 ; $i--):?>
                                    <option value="<?=$i?>"<?php if(isset($_GET['semana']) AND $_GET['semana'] == $i) {echo ' selected'; } ?>>S<?=$i?></option>
                                <?php endfor;?>
                            </select>
                                <?php if (isset($_GET['semana'])) :?>
                                    <a href="cargaHoras.php">Cambiar semana</a>
                                <?php endif;?>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if (isset($_SESSION['user']->id_usuario,$_GET['semana'])) :?>
                        <div class="form-group">
                            <label for="proyecto" class="col-lg-2 control-label">Proyecto</label>
                            <div class="col-lg-10">
                                <select name="proyecto" id="proyecto" <?php if (isset($_GET['proyecto'])) {echo 'disabled'; }?> >
                                    <?php foreach($proyectosDisponibles as $key => $value):?>
                                        <option value="<?php echo $value->id_proyecto;?>" <?php if(!empty($_SESSION['user']->id_usuario) AND !empty($_GET['proyecto']) AND $_GET['proyecto'] == $value->id_proyecto) { echo 'selected';}?> ><?php echo $value->proyecto?></option>
                                    <?php endforeach;?>
                                </select>
                                <?php if (isset($_GET['proyecto'])) :?>
                                    <a href="cargaHoras.php?semana=<?=$_GET['semana'];?>">Cambiar proyecto</a>
                                <?php endif;?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['proyecto'])):?>
                        <div class="form-group">
                            <label for="horas" class="col-lg-2 control-label">% Esfuerzo</label>
                            <div class="col-lg-8">
                                <?php if ($cantHoras->horas < $horasDisponibles->horas_habiles) :?>
                                    <input style="width: 55px;" type="number" name="horas" id="horas" min="1" max="<?php if (isset($horasDisponibles)) { echo $horasDisponibles->horas_habiles - $cantHoras->horas;} else { echo 40; }?>" value="<?php if(isset($_GET['horas'])) {echo $_GET['horas']; } else echo 1?>" <?php if (isset($_GET['carga'])) { echo "disabled"; } ?>>
                                    <br>
                                    <h5><label class="label label-info">% de esfuerzo restante <?=$horasDisponibles->horas_habiles - $cantHoras->horas;?></label></h5>
                                    <?php if (isset($_GET['carga'])) :?>
                                        <a href="cargaHoras.php?semana=<?=$_GET['semana']?>">Nueva carga</a>
                                    <?php endif;?>
                                <?php else : ?>
                                    <h5><label class="label label-danger">No es posible cargar horas debido a que se ha alcanzado el maximo disponible</label></h5>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION['user']->id_usuario,$_GET['proyecto'],$_GET['semana'],$_GET['horas'],$_GET['carga'])):?>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <?php if (isset($_SESSION['user']->id_usuario,$_GET['semana'])) :?>
                                <input type="hidden" name="semana" value="<?=$_GET['semana'];?>">
                            <?php endif;?>
                            <?php if (isset($_GET['proyecto'])) :?>
                                <input type="hidden" name="proyecto" value="<?=$_GET['proyecto'];?>">
                            <?php endif;?>
                            <a href="cargaHoras.php" class="btn btn-default">Cancel</a>
                            <button type="submit" class="btn btn-primary" <?php if (isset($_GET['proyecto']) AND $cantHoras->horas < $horasDisponibles->horas_habiles) { echo 'name="carga" value="ok"'; } else { echo '';}?>>Siguiente</button>
                        </div>
                    </div>
                    <?php endif;?>
                </fieldset>
            </form>
            <?php if ($mostrarTabla === true AND $cantHoras->horas > 0) :?>
                <?php require 'tablaResultado.php'; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include_once 'includes/footer.php'?>