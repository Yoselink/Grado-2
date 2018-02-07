<?
	$productos = new \Funciones\productos(); 
?>
<section class="content-header">
  <h1> Productos</h1>
</section>

<div class="content">
<?
	switch($opc){
		case 'ver':
		$producto = $productos->obtener($id);
	?>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<a href="?ver=productos" class="btn btn-default btn-flat">Volver</a>
			<a href="?ver=productos&opc=edit&id=<?=$id?>" class="btn btn-success btn-flat">Editar</a>
			<a href="?ver=salidas&opc=add&id=<?=$id?>" class="btn btn-primary btn-flat">Registrar salida</a>
		</div>
		<div class="col-md-4 col-md-offset-4">
			<div class="box box-primary">
        <div class="box-body box-profile">
          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Nombre</b> <span class="pull-right"><?=$producto->nombre_producto?></span>
            </li>
            <li class="list-group-item">
              <b>Descripcion:</b> <span class="pull-right"><?=$producto->descripcion?></span>
            </li>
            <li class="list-group-item">
              <b>Tipo</b> <span class="pull-right"><?=$producto->tipo?'Ganchos':'Gomas'?></span>
            </li>
            <li class="list-group-item">
              <b>Modelo</b> <span class="pull-right"><?=$producto->modelo?></span>
            </li>
            <li class="list-group-item">
              <b>Cantidad</b> <span class="pull-right"><?=$producto->cantidad?></span>
            </li>
          </ul>
        </div>
        <!-- /.box-body -->
      </div>
		</div>

		<div class="col-md-10 col-md-offset-1">
			<div class="box box-default color-palette-box">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-list"></i> Salidas registradas</h3>
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
							foreach ($productos->salidas() as $d) {
						?>
							<tr>
								<td class="text-center"><?=$i?></td>
								<td><a href="?ver=usuarios&opc=ver&id=<?=$d->id_user?>" title="Ver usuario"><?="{$d->nombre} {$d->apellido}"?></a></td>
								<td><?=$d->cantidad?></td>
								<td><?=$d->registrado?></td>
								<td>
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
		</div>
	</div>
	<?
		break;
		case 'add':
		case 'edit':
		if($id>0){$producto = $productos->obtener($id);}else{$producto=NULL;} 
		 
	?>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="box box-success">
						<div class="box-header">
							<h3 class="box-title"><i class="fa fa-cubes"></i> <?=($id>0)?'Modificar':'Agregar'?> Productos</h3><br>
						</div>

						<div class="box-body">
							<form id="registro" class="form-horizontal" action="funciones/productos.php" method="POST">
								<input type="hidden" name="action" value="<?=($id>0)?'edit_producto':'add_producto'?>">
								<?
								if($id>0){ ?>
									<input type="hidden" name="id" value="<?=$id?>">
								<?}?>
								<div class="form-group">
									<label for="producto" class="col-md-4 control-label">Nombre del producto: *</label>
									<div class="col-md-5">
										<input id="producto" class="form-control" type="text" name="producto" value="<?=($id>0)?$producto->nombre_producto:'' ?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="tipo" class="col-md-4 control-label">Tipo: *</label>
									<div class="col-md-5">
										<select id="tipo" class="form-control" name="tipo" required>
											<option value="">Seleccione...</option>
											<option value="0" <?=($id>0)?($producto->tipo == 0)?'selected':'':''?>>Gomas</option>
											<option value="1" <?=($id>0)?($producto->tipo == 1)?'selected':'':''?>>Ganchos</option>
										</select>
									</div>
								</div>

								<div class="form-group">
									<label for="descripcion" class="col-md-4 control-label">Descripcion: *</label>
									<div class="col-md-5">
										<input id="descripcion" class="form-control" type="text" name="descripcion" value="<?=($id>0)?$producto->descripcion:'' ?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="descripcion" class="col-md-4 control-label">Modelo: *</label>
									<div class="col-md-5">
										<input id="modelo" class="form-control" type="text" name="modelo" value="<?=($id>0)?$producto->modelo:'' ?>" required>
									</div>
								</div>
								
								<div class="form-group">
									<label for="cantidad" class="col-md-4 control-label">Cantidad: *</label>
									<div class="col-md-5">
										<input id="cantidad" class="form-control" type="number" min="1" max="999" name="cantidad" value="<?=($id>0)?$producto->cantidad:'' ?>" required>
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
										<a class="btn btn-flat btn-default" href="?ver=productos">Volver</a>
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
		$producto = $productos->consulta();
		$gomas    = $productos->selectByType(0);
		$ganchos  = $productos->selectByType(1);
	?>
			<div class="row">
	      <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	          <span class="info-box-icon bg-green"><i class="fa fa-cubes"></i></span>
	          <div class="info-box-content">
	            <div class="description-block border-right">
	              <h5 class="description-header"><?=$gomas?></h5>
	              <span class="description-text">GOMAS</span>
	            </div>
	          </div><!-- /.info-box-content -->
	        </div><!-- /.info-box -->
	      </div>


	      <div class="col-md-3 col-sm-6 col-xs-12">
	        <div class="info-box">
	          <span class="info-box-icon bg-green"><i class="fa fa-cubes"></i></span>
	          <div class="info-box-content">
	            <div class="description-block border-right">
	              <h5 class="description-header"><?=$ganchos?></h5>
	              <span class="description-text">GANCHOS</span>
	            </div>
	          </div><!-- /.info-box-content -->
	        </div><!-- /.info-box -->
	      </div>

				<div class="col-md-12">
				  <div class="box box-default color-palette-box">
				    <div class="box-header with-border">
				      <h3 class="box-title"><i class="fa fa-cubes"></i>Productos registrados</h3>
				      <div class="pull-right">
		            <a class="btn btn-flat btn-sm btn-success" href="?ver=productos&opc=add"><i class="fa fa-cubes" aria-hidden="true"></i> Agregar producto</a>
		          </div>
				    </div>
					
					<!--Tabla inicio-->
				    <div class="box-body">
					    <table class="table table-striped table-bordered">
					      <thead>
					        <tr>
					          <th class="text-center">#</th>
					          <th>Nombre</th>
					          <th>Tipo</th>
					          <th>Descripcion</th>
					          <th>Modelo</th>
					          <th>Cantidad</th>
					          <th>Accion</th>
					        </tr>
					      </thead>
					      <tbody>
								<? $i = 1;
									foreach ($producto as $d) {
								?>
									<tr>
										<td class="text-center"><?=$i?></td>
										<td><?=$d->nombre_producto?></td>
										<td><?=$d->tipo?'Ganchos':'Gomas'?></td>
										<td><?=$d->descripcion?></td>
										<td><?=$d->modelo?></td>
										<td><?=$d->cantidad?></td>
										<td class="text-center">
											<a class="btn btn-flat btn-primary btn-sm" href="?ver=productos&opc=ver&id=<?=$d->id_producto?>"><i class="fa fa-search"></i></a>
											<a class="btn btn-flat btn-success btn-sm" href="?ver=productos&opc=edit&id=<?=$d->id_producto?>"><i class="fa fa-pencil"></i></a>
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
				</div>
			</div>
		  
	<?
		break;
	}
?>
</div> 