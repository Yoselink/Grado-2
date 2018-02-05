<?
 require_once 'funciones/niveles.php';
	$niveles = new \Funciones\Niveles(); 
?>
<section class="content-header">
  <h1> Niveles </h1>
</section>

<div class="content">
<?
	switch($opc){
		case 'ver':
		$user = $niveles->obtener($id); 
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
		if($id>0){$nivel = $niveles->obtener($id);}else{$nivel=NULL;} 
		 
	?>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="box box-success">
						<div class="box-header">
							;<h3 class="box-title"><i class="fa <?=($id>0)? 'fa-pencil':'fa-user-plus'?>"></i> <?=($id>0)?'Modificar':'Agregar'?> Niveles</h3><br>
						</div>

						<div class="box-body">
							<form id="registro" class="form-horizontal" action="funciones/niveles.php" method="POST">
								<input type="hidden" name="action" value="<?=($id>0)?'edit':'add'?>">
								<?
								if($id>0){ ?>
									<input type="hidden" name="id" value="<?=$id?>">
								<?}?>
								<div class="form-group">
									<label for="nivel" class="col-md-4 control-label">Nivel: *</label>
									<div class="col-md-5">
										<input id="nivel" class="form-control" type="text" name="nivel" value="<?=($id>0)?$nivel->nombre_nivel:'' ?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="descripcion" class="col-md-4 control-label">Descripcion: *</label>
									<div class="col-md-5">
										<input id="descripcion" class="form-control" type="text" name="descripcion" value="<?=($id>0)?$nivel->descripcion:'' ?>" required>
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
										<a class="btn btn-flat btn-default" href="?ver=niveles">Volver</a>
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
		$niv = $niveles->consulta();
	?>
		  <div class="box box-default color-palette-box">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-users"></i> Niveles registrados</h3>
		      <div class="pull-right">
            <a class="btn btn-flat btn-sm btn-success" href="?ver=niveles&opc=add"><i class="fa fa-user-plus" aria-hidden="true"></i> Agregar nivel</a>
          </div>
		    </div>
		    <div class="box-body">
			    <table class="table table-striped table-bordered">
			      <thead>
			        <tr>
			          <th class="text-center">#</th>
			          <th>Nombre</th>
			          <th>Descripcion</th>
			          <th>Accion</th>
			        </tr>
			      </thead>
			      <tbody>
						<? $i = 1;
							foreach ($niv as $d) {
						?>
							<tr>
								<td class="text-center"><?=$i?></td>
								<td><?=$d->nombre_nivel?></td>
								<td><?=$d->descripcion?></td>
								<td class="text-center">
									<a class="btn btn-flat btn-primary btn-sm" href="?ver=niveles&opc=ver&id=<?=$d->id_nivel?>"><i class="fa fa-search"></i></a>
									<a class="btn btn-flat btn-success btn-sm" href="?ver=niveles&opc=edit&id=<?=$d->id_nivel?>"><i class="fa fa-pencil"></i></a>
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