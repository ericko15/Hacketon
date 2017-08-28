<?php
	if ($view_option == 'main')
	{
?>
	<div id="container-main">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<span class="navbar-brand">
						<strong>UNICESAR</strong> / <span>Selección de Materias</span>
					</span>
				</div>
				<div class="navbar-text navbar-right" style="margin-right: 2%;">
					<div id="message" style="display: none;"></div>
					<div class="loading" id="loading" style="display: none;">
						<img src="<?= base_url(); ?>images/loader.gif">
					</div>
				</div>
			</div>
		</nav>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-2"></div>
				<div class="col-md-8">
					<span class="panel-title">Parámteros de Búsqueda</span>
					<div class="panel panel-primary">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Facultad:</label>
										<select class="form-control" onchange="load_programs_by_faculty(this.value)">
											<option value="">Selecccione...</option>
											<?php
												foreach ($faculties_data as $item) {
													echo '
														<option value="'.$item['id'].'">'.$item['name'].'</option>
													';
												}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<div id="div_programs">
											<label>Programas:</label><br>
											<select class="form-control" id="programs" name="programs">
												<option>Seleccione...</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<hr>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-8">
					<span class="panel-title">Pool de Materias</span>
					<div class="panel panel-primary">
						<div class="panel-body" id="pool">
							<div id="pool_subjects">
								Seleccione una Facultad y un Programa.
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<span class="panel-title">Materias Elegidas</span>
					<div class="panel panel-primary">
						<div class="panel-body" id="selected">
							<div id="selected_subjects">
								<table class="table">
									<caption>
										<strong>Total Créditos: </strong>0, 
										<strong>Total Materias: </strong>0
									</caption>
									<tr>
										<th style="text-align: center;">MATERIA</th>
										<th style="text-align: center;">PESO</th>
										<th style="text-align: center;"></th>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="step-2" style="display: none;">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<span class="navbar-brand">
						<strong>UNICESAR</strong> / 
						<a href="http://localhost/Planeador/">Selección de Materias</a> / 
						<span>Generar Horario</span>
					</span>
				</div>
				<div class="navbar-text navbar-right" style="margin-right: 2%;">
					<div id="message_2"></div>
					<div class="loading" id="loading_2" style="display: none;">
						<img src="<?= base_url(); ?>images/loader.gif">
					</div>
				</div>
			</div>
		</nav>
		<div id="step-2-body"></div>
		<div id="schedules"></div>
	</div>
<?php
	}
	elseif ($view_option == 'pool_subjects')
	{
		?><div class="row"><?php
		if (count($subjects_data) > 0)
		{
			foreach ($subjects_data as $item)
			{
				echo '
					<div class="col-md-3">
						<div class="main">
							<div style="cursor: pointer;" class="name-subject" onclick="select_subject(\''.$item['code'].'\', \''.$item['name'].'\', \''.$item['credits'].'\')">
								[ '.$item['code'].' ] <br>
								<span title="Elegir" style="text-decoration: underline;cursor: pointer;">'.$item['name'].'</span>
							</div>
							<div>
								<div class="quota-state">
									<input id="weight_'.$item['code'].'" title="Peso: Es la prioridad que se le dá a la materia, [ 1 - 3 ]" style="
										width: 50px;
										text-align: center;
									" placeholder="1" size="1" maxlength="1">
								</div>
								<div class="credits" title="Créditos">'.$item['credits'].'</div>
							</div>
						</div>
					</div>
				';
			}
			echo '
				<center>'.$pagination.'</center>
			';
		}
		else
		{ echo '<span style="margin-left: 2%;">No hay materias registradas.</span>'; }
		?></div><?php
	}
	elseif ($view_option == 'step_2')
	{
		?>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-2"></div>
					<div class="col-md-8">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<button style="display: none;" id="btn_show" onclick="show_container('show')" class="btn btn-info">
									<i class="glyphicon glyphicon-chevron-down"></i>
								</button>
								<button id="btn_hide" onclick="show_container('hide')" class="btn btn-info">
									<i class="glyphicon glyphicon-chevron-up"></i>
								</button>
								<label style="margin-left: 3%;">Filtro de profesores</label>
							</div>
							<div id="div_groups" class="panel-body">
								<div class="table-responsive">
									<table class="table table-hover">
										<tr>
											<th>COD. MATERIA</th>
											<th>MATERIA</th>
											<th>PROFESOR</th>
										</tr>
										<?php
											if (count($groups) > 0)
											{
												$_id = 0;
												foreach($subjects as $item)
												{
													$_id += 1;
													//Profesores
													$teachers = get_teachers_from_array($groups, $item->code);
													$select_teachers = '<div class="form-group"><select id="teacher_'.$_id.'" class="form-control">';
														foreach($teachers as $item_t)
														{
															$select_teachers .= '<option value="'.$item_t['id'].'">'.$item_t['name'].'</option>';
														}
													$select_teachers .= '</select></div>';
													echo '
														<tr>
															<td><input type="hidden" id="code_'.$_id.'" value="'.$item->code.'">'.$item->code.'</td>
															<td>'.$item->name.'</td>
															<td>'.$select_teachers.'</td>
														</tr>
													';
												}
											}
											else
											{
												echo '<tr><td colspan="3">No hay grupos asignados para ninguna de las materias escogidas.</td></tr>';
											}
										?>
									</table>
									<?php if(count($groups) > 0){ ?>
										<center><button onclick="generar_horarios()" class="btn btn-primary">GENERAR HORARIOS</button></center>
									<?php } ?>
								</div>
							</div>
							<input type="hidden" id="numero_de_grupos" value="<?= $_id; ?>">
						</div>
					</div>
				</div>
			</div>
		<?php
	}
	elseif ($view_option == 'schedules')
	{
		$_g = array();
		foreach($g[$page - 1] as $item)
		{
			array_push($_g, array(
				"code" => explode("_", $item)[0],
				"g" => explode("_", $item)[1]
			));
		}
		?>	
			<div class="container-fluid">
				<div class="panel panel-primary">
					<div class="panel-body">
						<table id="schedules_table" class="table table-bordered table-hover">
							<caption>
								<strong>Página: </strong><?= $page; ?>
							</caption>
							<tr>
								<th></th>
								<th><center>LUNES</center></th>
								<th><center>MARTES</center></th>
								<th><center>MIERCOLES</center></th>
								<th><center>JUEVES</center></th>
								<th><center>VIERNES</center></th>
								<th><center>SABADO</center></th>
								<th><center>DOMINGO</center></th>
							</tr>
							<?php
								$con = 0;
								foreach($s_t as $item_st)
								{
									$g_selected = $g[$page - 1];
									$sjt = explode("_", $g_selected[$con])[0];
									$grp = explode("_", $g_selected[$con])[1];
									echo '
										<tr>
											<td style="width: 25%;">
												<center>
													[ '.$sjt.' ]<br>
													'.get_name_from_array($g_c, $item_st->code).'
												</center>
											</td>
										';
										for($day = 1; $day <= 7; $day++)
										{
											$exists = false;
											foreach($g_c as $item_gc)
											{
												if ($item_gc['code'] == $sjt)
												{
													if ($item_gc['day'] == $day)
													{
														foreach($_g as $item_g)
														{
															if ($item_g['code'] == $sjt && $item_g['g'] == $item_gc['name'])
															{
																$exists = true;
																echo '
																	<td>
																		<center>
																			'.$item_gc['name_teacher'].'<br>
																			GRUPO: '.$item_gc['name'].'<br>
																			'.$item_gc['start_time'].' - '.$item_gc['final_hour'].'
																		</center>
																	</td>'
																;
															}
														}
													}
												}
											}
											if (!$exists)
												echo '<td></td>';
										}
									echo '</tr>';
									$con += 1;
								}
							?>
						</table>
						<center><?= $pagination ?></center>
					</div>
				</div>
			</div>
		<?php
	}
?>