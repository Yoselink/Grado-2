<?
	require_once 'funciones/usuarios.php';
	$usuarios = new Usuarios();
?>
<section class="content-header">
  <h1> Usuarios </h1>
</section>

<div class="content">
<?
	switch($opc){
		case 'ver':
		$user = $usuarios->obtener($id);
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
		if($id>0){$user = $usuarios->obtener($id);}else{$user=NULL;}
		
	?>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="box box-success">
						<div class="box-header">
							<h3 class="box-title"><i class="fa <?=($id>0)? 'fa-pencil':'fa-user-plus'?>"></i> <?=($id>0)?'Modificar':'Agregar'?> Usuario</h3><br>
						</div>

						<div class="box-body">
							<form id="registro" class="form-horizontal" action="funciones/usuarios.php" method="POST">
								<input type="hidden" name="action" value="<?=($id>0)?'edit':'add'?>">
								<?
								if($id>0){ ?>
									<input type="hidden" name="id" value="<?=$id?>">
								<?}?>
								<div class="form-group">
									<label for="email" class="col-md-4 control-label">Email: *</label>
									<div class="col-md-5">
										<input id="email" class="form-control" type="email" name="email" value="<?=($id>0)?$user->email:'' ?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="nombre" class="col-md-4 control-label">Nombre: *</label>
									<div class="col-md-5">
										<input id="nombre" class="form-control" type="text" name="nombre" value="<?=($id>0)?$user->nombre:'' ?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="apellido" class="col-md-4 control-label">Apellido: *</label>
									<div class="col-md-5">
										<input id="apellido" class="form-control" type="text" name="apellido" value="<?=($id>0)?$user->apellido:''?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="cedula" class="col-md-4 control-label">Cedula: *</label>
									<div class="col-md-5">
										<input id="cedula" class="form-control" type="text" name="cedula" value="<?=($id>0)?$user->cedula:''?>" required>
									</div>
								</div>
							<?php $nivel = $usuarios->consultaNivel();?>
								<div class="form-group">
								<label for="nivel" class="col-md-4 control-label">Nivel * :</label>
									<div class="col-md-5">
									<select for="nivel" id="nivel" class="form-control" name="nivel" required>
							
										<option value="">Seleccione...</option>
												<?php foreach ($nivel as $n){ ?>
											<option value="<?=$n->id_nivel?>" <?if($id>0){ if($user->nivel==$n->id_nivel){echo 'selected';}}?>><?=$n->nombre_nivel?></option>
										<?php } ?>
									</select>
									</div>
								</div>

								<div class="form-group">
									<label for="division" class="col-md-4 control-label">Divisiones: *</label>
									<div class="col-md-5">
										<select id="division" class="form-control" type="text" name="division" value="<?=($id>0)?$user->division_id:''?>" required>

											<?php $divisiones = $usuarios->consultaDivision();?>
											<option value="">Seleccione...</option>
											<?php foreach ($divisiones as $div) { ?>
												
											<option value="<?=$div->id_division?>" <?if($id>0){ if($user->division==$div->id_division){echo 'selected';}}?>><?=$div->nombre?> </option>
										<?php } ?>
										</select>
									</div>
								</div>
								<?if($id===0){?>
								<div class="form-group">
									<label for="password" class="col-md-4 control-label">Contraseña: *</label>
									<div class="col-md-5">
										<input id="password" class="form-control" type="password" name="password" required>
									</div>
								</div>
								<?}?>

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
										<a class="btn btn-flat btn-default" href="?ver=usuarios">Volver</a>
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
		$users = $usuarios->consulta();
	?>
		  <div class="box box-default color-palette-box">
		    <div class="box-header with-border">
		      <h3 class="box-title"><i class="fa fa-users"></i> Usuarios registrados</h3>
		      <div class="pull-right">
            <a class="btn btn-flat btn-sm btn-success" href="?ver=usuarios&opc=add"><i class="fa fa-user-plus" aria-hidden="true"></i> Agregar usuario</a>
          </div>
		    </div>
		    <div class="box-body">
			    <table class="table table-striped table-bordered">
			      <thead>
			        <tr>
			          <th class="text-center">#</th>
			          <th>Nombres</th>
			          <th>Apellidos</th>
			          <th>Email</th>
			         <!-- <th>Division</th> -->
			        </tr>
			      </thead>
			      <tbody>
						<? $i = 1;
							foreach ($users as $d) {
						?>
							<tr>
								<td class="text-center"><?=$i?></td>
								<td><?=$d->nombre?></td>
								<td><?=$d->apellido?></td>
								<td><?=$d->email?></td>
								<td class="text-center">
									<a class="btn btn-flat btn-primary btn-sm" href="?ver=usuarios&opc=ver&id=<?=$d->id_user?>"><i class="fa fa-search"></i></a>
									<a class="btn btn-flat btn-success btn-sm" href="?ver=usuarios&opc=edit&id=<?=$d->id_user?>"><i class="fa fa-pencil"></i></a>
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

<script type="text/javascript">
	
	$("#division").select2();
	$("#nivel").select2();


</script>