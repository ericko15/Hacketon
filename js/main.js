'use-sctrict';
/*
* Carga los programas dependiendo de la facultad.
*/
function load_programs_by_faculty(faculty)
{
	if(faculty != '')
	{
		loader_show(true);
		$("#pool_subjects").html('Seleccione una Facultad y un Programa.');
		$.get('C_main/load_programs_by_faculty/' + faculty, function(data, status){
				data = JSON.parse(data)
				if (data.length > 0)
				{
					loader_show(false, "");
					let options = '<option value="">Seleccione...</option>';
					data.forEach(function(item, index){
						options += '<option value="'+item.id+'">[ '+item.snies_code+' ] '+item.name+'</option>';
					});
					$("#div_programs").html(
						'<div class="form-group">' + 
							'<label>Programas:</label><br>' +
							'<select onchange="load_subjects_by_program(\'C_main/load_subjects_by_program/\'+ this.value +\'/0/12\')" class="form-control" id="programs" name="programs">' +
								options +
							'</select>' + 
						'</div>'
					);
				}
				else
				{
					loader_show(false, "No se pudo completar la petición");
					console.log(data);
				}
			}
		);
	}
	else
	{
		$("#pool_subjects").html('Seleccione una Facultad y un Programa.');
	}
}
/*
* Carga los programas dependiendo de la facultad.
*/
function load_subjects_by_program(url)
{
	if (url != '')
	{
		loader_show(true);
		$.get(url, 
			function(data, status){
				loader_show(false, "");
				$("#pool_subjects").html(data);
			}
		);
	}
	else
	{
		$("#pool_subjects").html('Seleccione una Facultad y un Programa.');
	}
}
/*
* Muestra el loader de cada petición.
*/
function loader_show(show, message = "")
{
	$("#message").val(message);
	if (show == true)
	{
		$("#loading").css("display", "");
	}
	else
	{
		$("#loading").css("display", "none");
	}
}
function loader_show_2(show, message = "")
{
	$("#message_2").text(message);
	if (show == true)
	{
		$("#loading_2").css("display", "");
	}
	else
	{
		$("#loading_2").css("display", "none");
	}
}
/*
* Anexa la materia seleccionada del pool de materias.
*/
function select_subject(code, name, credits)
{
	let selected_subjects = JSON.parse(window.localStorage.getItem('selected_subjects'));
	let exists = false;
	selected_subjects.forEach(function(item, index){
		if (item.code == code)
		{ exists = true; }
	});
	if (!exists)
	{
		selected_subjects.push({
			"code": code,
			"name": name,
			"credits": credits
		});
		window.localStorage.setItem('selected_subjects', JSON.stringify(selected_subjects));
		build_table();
	}
	else
	{
		show_message('error', 'La materia ya está seleccionada.');
	}
}
/*
* Construye la tabla de las materias seleccionadas.
*/
function build_table()
{
	let selected_subjects = JSON.parse(window.localStorage.getItem('selected_subjects'));
	let credits = 0;
	selected_subjects.forEach(function(item, index)
	{ credits += parseInt(item.credits); });

	let table = '<table class="table table-hover">';
		table += 
			'<caption>' +
				'<strong>Total Créditos: </strong>' + credits + 
				', <strong>Total Materias: </strong>' + selected_subjects.length + 
			'</caption>';
		table += 
			'<tr>' +
				'<th style="text-align: center;">MATERIA</th>' + 
				'<th style="text-align: center;">PESO</th>' + 
				'<th style="text-align: center;"></th>' + 
			'</tr>';
		selected_subjects.forEach(function(item, index)
		{
			let weight = $("#weight_" + item.code).val();
			if (weight == '' || weight == undefined)
			{ weight = 1; }

			selected_subjects[index]['weight'] = weight;

			table += '<tr>';
				table += 
					'<td style="text-align: center;">' + item.name + '</td>' + 
					'<td style="text-align: center;">' + weight + '</td>' + 
					'<td style="text-align: center;"><button onclick="quit_subject(\'' + item.code + '\')" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i></button></td>'
			table += '</tr>';
		});
	table += '</table>';
	table += '<button onclick="to_step_2()" class="btn btn-primary btn-lg btn-block">IR AL PASO 2</button>'
	$("#selected_subjects").html(table);
	window.localStorage.setItem('selected_subjects', JSON.stringify(selected_subjects));
}
/*
* Quita la materia de las seleccionadas.
*/
function quit_subject(code)
{
	let selected_subjects = JSON.parse(window.localStorage.getItem('selected_subjects'));
	selected_subjects.forEach(function(item, index){
		if (item.code == code)
		{
			selected_subjects.splice(index, 1);
		}
	});
	window.localStorage.setItem('selected_subjects', JSON.stringify(selected_subjects));
	build_table();
}
/*
* Muestra el mensaje.
*/
function show_message(type, message)
{
	$().toastmessage('showToast', {
	    text     : '<br />' + message,
	    sticky   : false,
	    stayTime : 7000,
	    position : 'top-right',
	    type     : type,
	    close    : function () {}
	});
}
/*
* Creo el array y muestra el paso 2
*/
function to_step_2()
{
	loader_show(true);
	let selected_subjects = JSON.parse(window.localStorage.getItem('selected_subjects'));
	$.post('C_main/show_view_step_2/', 
		{"subjects": JSON.stringify(selected_subjects)}, 
		function(data, status){
			$("#step-2-body").html(data);
			$("#container-main").css("display", 'none');
			$("#step-2").css("display", '');
		}
	);
}
/*
* Mostrar / Ocultar el contenedor
*/
function show_container(show)
{
	if (show == 'show')
	{
		$("#btn_show").css("display", "none");
		$("#btn_hide").css("display", "");
		$("#div_groups").css("display", "");
	}
	else
	{
		$("#btn_show").css("display", "");
		$("#btn_hide").css("display", "none");
		$("#div_groups").css("display", "none");
	}
}
/*
* Selecciona la fila para generar el horario
*/
function select_row(id)
{
	$("#row_" + id).addClass("success");
}
/*
* Paso 1: Mostrar la vista de generar horarios.
*/
function generar_horarios(page = 1)
{
	let length = $("#numero_de_grupos").val();
	window.scrollTo(0, -(9999*9999));
	loader_show_2(true, "Buscando grupos disponibles.");
	get_groups(length, page);
}
/*
* Paso 2: Se obtiene todos los grupos por profesor y materia.
*/
function get_groups(length, page)
{
	let teachers = [];
	for(let i = 1; i <= length; i++)
	{
		teachers.push({
			"code": $("#code_" + i).val(),
			"teacher_id": $("#teacher_" + i).val(),
		});
	}
	//show_container('hide');
	$.post('C_main/get_groups_by/', 
		{"teachers": JSON.stringify(teachers)}, 
		function(data, status){
			let groups = [];
			data = JSON.parse(data);
			data.forEach(function(item, index){
				groups.push(
					item.groups.split(",")
				);
			});
			let comb = permutaciones(groups);
			groups = [];
			comb.forEach(function(item_c, index_c){
				teachers.forEach(function(item_t, index_t){
					comb[index_c][index_t] = item_t.code + '_' + item_c[index_t];
				});
			});
			loader_show_2(true, "Aplicando algoritmo de permutaciones.");
			view_generate_schedules(comb, teachers, page);
		}
	);
}
/*
* Generar horarios php
*/
function view_generate_schedules(groups, teachers, page)
{
	groups = JSON.stringify(groups);
	//groups = groups.replace(/\"/g,'');
	$.post('C_main/view_generate_schedules/', 
		{
			"groups": groups,
			"teachers": JSON.stringify(teachers),
			"page": page
		}, 
		function(data, status){
			console.log(groups);
			loader_show_2(false, "");
			$("#schedules").html(data);
			window.scrollTo(0, (9999*9999))
		}
	);
}
/*
* Función que genera las permutaciones de los grupos.
*/
function permutaciones(arguments) {
    var r = [], arg = arguments, max = arg.length-1;
    function helper(arr, i) {
        for (var j=0, l=arg[i].length; j<l; j++) {
            var a = arr.slice(0); // clone arr
            a.push(arg[i][j]);
            if (i==max)
                r.push(a);
            else
                helper(a, i+1);
        }
    }
    helper([], 0);
    return r;
}
/*
* Funcion cuando el documento esté listo.
*/
(function(){
	loader_show(true);
	window.localStorage.setItem('selected_subjects', JSON.stringify([]));
})()
