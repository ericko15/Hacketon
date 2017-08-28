<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Anterior extends CI_Controller {
		
		function __construct()
		{
			parent::__construct();
			/*
			* Validar que no intenten acceder desde la url
			*
			* if(!isset($_SERVER['HTTP_REFERER']))
			* { redirect('c_menu','refresh'); }
			*/
			$this->load->model("_faculties/M_faculties");
		}
		/*
		* Mostrar la vista principal.
		*/
		public function index()
		{
			$response = $this->M_faculties->get_list_faculties();
			$data = array(
				"view_option" => "main",
				"faculties_data" => $response
			);

			/*
			* Cargar vistas
			*/
			$this->load->view('V_header');
				$this->load->view('V_main', $data);
			$this->load->view('V_footer');
		}
		/*
		* Consultar los programas por facultad.
		*/
		public function load_programs_by_faculty($faculty)
		{
			$response = $this->M_faculties->load_programs_by_faculty($faculty);
			echo json_encode($response);
		}
		/*
		* Consultar las materias por programa
		*/
		public function load_subjects_by_program($program, $offset = 1, $limit = 12)
		{
			$response = $this->M_faculties->load_subjects_by_program(
				$program, $offset, $limit
			);
			$count_subjects = $this->M_faculties->get_count_subjects_by_program($program);
			$pagination = new Pagination();
			$pagination = $pagination->generate_buttons(
				'C_main/load_subjects_by_program/'.$program.'/', $count_subjects, 12
			);
			$data = array(
				"view_option" => "pool_subjects",
				"subjects_data" => $response,
				"pagination" => $pagination
			);

			/*
			* Cargar vistas
			*/
			$this->load->view('V_main', $data);
		}
		/*
		* Mostrar la vista del paso 2.
		*/
		public function show_view_step_2()
		{
			$subjects = json_decode($this->input->post('subjects'));
			$sbjs = array();
			foreach($subjects as $item)
			{
				array_push($sbjs, "'".$item->code."'");
			}
			$groups = $this->M_faculties->get_groups(join(',', $sbjs));
			$data = array(
				"view_option" => "step_2",
				"groups" => $groups,
				"subjects" => $subjects
			);

			/*
			* Cargar vistas
			*/
			$this->load->view('V_header');
				$this->load->view('V_main', $data);
			$this->load->view('V_footer');
		}
		/*
		* Vista para generar horarios.
		*/
		public function view_generate_schedules()
		{
			$groups = json_decode($this->input->post('groups'));
			$teachers = json_decode($this->input->post('teachers'));
			$sbjs = array();
			$gps = array();
			$teachs = array();
			foreach($groups as $item_1)
			{
				foreach($item_1 as $item_2)
				{
					array_push($sbjs, "'".explode("_", $item_2)[0]."'");
					array_push($gps, "'".explode("_", $item_2)[1]."'");
				}
			}
			foreach($teachers as $item)
			{
				array_push($teachs, $item->teacher_id);
			}
			$groups_complet = $this->M_faculties->consult_groups($sbjs, $gps, $teachs);
			$page = $this->input->post('page');

			$pagination = generate_pagination($groups);

			$data = array(
				"view_option" => "schedules",
				"g_c" => $groups_complet,
				"s_t" => $teachers,
				"g" => $groups,
				"pagination" => $pagination,
				"page" => $page
			);

			/*
			* Cargar vistas
			*/
			$this->load->view('V_header');
				$this->load->view('V_main', $data);
			$this->load->view('V_footer');
		}
		/*
		* Obtiene los grupos de un arreglo y convierte a entendible.
		*/
		public function get_groups_by()
		{
			$teachers = json_decode($this->input->post('teachers'));
			$groups = array();
			foreach($teachers as $item_t)
			{ 
				array_push(
					$groups, array(
						"code" => $item_t->code,
						"name_subject" => $this->M_faculties->convert_to_name_subject($item_t->code),
						"teacher_id" => $item_t->teacher_id,
						"groups" => $this->M_faculties->get_groups_by(
							$item_t->code, $item_t->teacher_id
						)
					)
				); 
			}
			echo json_encode($groups);
		}
	}
