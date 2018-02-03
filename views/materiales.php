<?
 require_once 'funciones/material.php';
	$materiales = new materiales(); 
?>
<section class="content-header">
  <h1> Productos</h1>
</section>

<div class="content">
<?
	switch($opc){
		case 'ver':
		$materiales = $material->obtener($id); 
	?>
	<div class="row">
		<div class="col-md-4 col-md-offset-4">
			<div class="box box-primary">
	          <div class="box-body box-profile">
	            <h3 class="profile-username text-center"><?=$user->nombre." ".$user->apellido?></h3>
	            <ul class="list-group list-group-unbordered">
	              <li class="list-group-item">
	                <b>Cedula</b> <span class="pull-right"><?=$user->cedula?></span>
	              </li>
	              <li class="list-group-item">
	                <b>Email:</b> <span class="pull-right"><?=$user->email?></span>
	              </li>
	              <li class="list-group-item">
	                <b>Nivel</b> <span class="pull-right"><?=$user->nivel?></span>
	              </li>
	              <li class="list-group-item">
	                <b>Division</b> <span class="pull-right"><?=$user->division_id?></span>
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
		case 'edit':
		if($id>0){$material = $materiales->obtener($id);}else{$material=NULL;} 
		 
	?>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="box box-success">
						<div class="box-header">
							;<h3 class="box-title"><i class="fa <?=($id>0)? 'fa-pencil':'fa-user-plus'?>"></i> <?=($id>0)?'Modificar':'Agregar'?> Productos</h3><br>
						</div>

						<div class="box-body">
							<form id="registro" class="form-horizontal" action="funciones/material.php" method="POST">
								<input type="hidden" name="action" value="<?=($id>0)?'edit':'add'?>">
								<?
								if($id>0){ ?>
									<input type="hidden" name="id" value="<?=$id?>">
								<?}?>
								<div class="form-group">
									<label for="material" class="col-md-4 control-label">Nombre del producto: *</label>
									<div class="col-md-5">
										<input id="material" class="form-control" type="text" name="material" value="<?=($id>0)?$material->nombre_material:'' ?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="descripcion" class="col-md-4 control-label">Descripcion: *</label>
									<div class="col-md-5">
										<input id="descripcion" class="form-control" type="text" name="descripcion" value="<?=($id>0)?$material->descripcion:'' ?>" required>
									</div>
								</div>
								
								<div class="form-group">
									<label for="cantidad" class="col-md-4 control-label">Cantidad: *</label>
									<div class="col-md-5">
										<input id="cantidad" class="form-control" type="text" name="cantidad" value="<?=($id>0)?$material->cantidad:'' ?>" required>
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
										<a class="btn btn-flat btn-default" href="?ver=materiales">Volver</a>
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
		$mat = $materiales->consulta();
	?>
		  <div class="box box-default color-palette-box">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-users"></i>Productos registrados</h3>
		      <div class="pull-right">
            <a class="btn btn-flat btn-sm btn-success" href="?ver=materiales&opc=add"><i class="fa fa-user-plus" aria-hidden="true"></i> Agregar producto</a>
          </div>
		    </div>
			
			<!--Tabla inicio-->
		    <div class="box-body">
			    <table class="table table-striped table-bordered">
			      <thead>
			        <tr>
			          <th class="text-center">#</th>
			          <th>Nombre</th>
			          <th>Descripcion</th>
			          <th>cantidad</th>
			        </tr>
			      </thead>


			      <tbody>
						<? $i = 1;
							foreach ($mat as $d) {
						?>
							<tr>
								<td class="text-center"><?=$i?></td>
								<td><?=$d->nombre_material?></td>
								<td><?=$d->descripcion?></td>
								<td><?=$d->cantidad?></td>
								<td class="text-center">
									<a class="btn btn-flat btn-primary btn-sm" href="?ver=materiales&opc=ver&id=<?=$d->id_material?>"><i class="fa fa-search"></i></a>
									<a class="btn btn-flat btn-success btn-sm" href="?ver=materiales&opc=edit&id=<?=$d->id_material?>"><i class="fa fa-pencil"></i></a>

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