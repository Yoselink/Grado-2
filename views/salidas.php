<?
 require_once 'funciones/salidas.php';
	$salidas = new \Funciones\Salidas(); 
?>
<section class="content-header">
  <h1> Salidas</h1>
</section>

<div class="content">
<?
	switch($opc){
		case 'ver':
		$salida = $salidas->obtener($id);
	?>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<a href="?ver=salidas" class="btn btn-default btn-flat">Volver</a>
			<a class="btn btn-flat btn-danger" href="reportes/salidas.php?action=salida&id=<?=$salida->id_salida?>"><i class="fa fa-print"></i> Imprimir PDF</a>
		</div>
		<div class="col-md-4 col-md-offset-4">
			<div class="box box-primary">
        <div class="box-body box-profile">
          <h3 class="profile-username text-center">
          	<a href="?ver=usuarios&opc=ver&id=<?=$salida->id_user?>" title="Ver usuario"><?="{$salida->nombre} {$salida->apellido}"?></a>
          </h3>
          <p class="text-muted text-center">Registrado: <?=$salida->registrado?></p>
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <?=$salida->contenido?>
              <br>
              <b>Cantidad</b> <?=$salida->cantidad?>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
		</div>
	</div>

	<?
		break;
		case 'add':
			if($id>0){$salida = $id;}else{$salida = NULL;} 
		 	$productos = new \Funciones\productos;
		 	$productos = $productos->consulta();
	?>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="box box-success">
						<div class="box-header">
							<h3 class="box-title"><i class="fa fa-list"></i> Agregar salida</h3><br>
						</div>

						<div class="box-body">
							<form id="registro" class="form-horizontal" action="funciones/salidas.php" method="POST">
								<input type="hidden" name="action" value="add_salida">

								<div class="form-group">
									<label for="salida" class="col-md-4 control-label">Producto: *</label>
									<div class="col-md-5">
										<select id="producto" class="form-control" name="producto" required>
											<option value="">Seleccione...</option>
											<?
												foreach ($productos as $d) {
											?>
												<option value="<?=$d->id_producto?>" <?=($d->id_producto==$id)?'selected':''?>><?=$d->nombre_producto?></option>
											<?
												}
											?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label for="cantidad" class="col-md-4 control-label">Cantidad: *</label>
									<div class="col-md-5">
										<input id="cantidad" class="form-control" type="number" min="1" max="999" name="cantidad" value="1" required>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-5 col-md-offset-4">
										<div class="progress" style="display:none">
					            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
					            </div>
					          </div>
					          <p class="help-block" style="color:red">* Campos obligatorios</p>
					          <div class="alert" role="alert" style="display:none"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>&nbsp;<span id="msj"></span></div>
									</div>
								</div>

								<div class="form-group">
									<div class="col-md-5 col-md-offset-4">
										<input id="b-user" class="btn btn-flat btn-primary b-submit" type="submit" data-loading-text="Guardando..." value="Guardar">
										<a class="btn btn-flat btn-default" href="?ver=salidas">Volver</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	<?
		break;
		default:
		$mat = $salidas->consulta();
	?>
		  <div class="box box-default color-palette-box">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-list"></i> Salidas registrados</h3>
		      <div class="pull-right">
            <a class="btn btn-flat btn-sm btn-success" href="?ver=salidas&opc=add"><i class="fa fa-cubes" aria-hidden="true"></i> Agregar salida</a>
          </div>
		    </div>
			
				<!--Tabla inicio-->
		    <div class="box-body">
			    <table class="table table-striped table-bordered">
			      <thead>
			        <tr>
			          <th class="text-center">#</th>
			          <th>Usuario</th>
			          <th>Cantidad</th>
			          <th>Fecha</th>
			          <th>Accion</th>
			        </tr>
			      </thead>
			      <tbody>
						<? $i = 1;
							foreach ($mat as $d) {
						?>
							<tr>
								<td class="text-center"><?=$i?></td>
								<td><a href="?ver=usuarios&opc=ver&id=<?=$d->id_user?>" title="Ver usuario"><?="{$d->nombre} {$d->apellido}"?></a></td>
								<td><?=$d->cantidad?></td>
								<td><?=$d->registrado?></td>
								<td class="text-center">
									<a class="btn btn-flat btn-primary btn-sm" href="?ver=salidas&opc=ver&id=<?=$d->id_salida?>"><i class="fa fa-search"></i></a>
									<a class="btn btn-flat btn-danger btn-sm" href="reportes/salidas.php?action=salida&id=<?=$d->id_salida?>"><i class="fa fa-print"></i></a>
								</td>
							</tr>
						<?
							$i++;
							}
						?>        
			      </tbody>
			    </table>
			   </div>
		  </div>
		  
	<?
		break;
	}
?>
</div> 