<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/*
	* Obtiene el objeto dentro del array por el filtro de id.
	*/
	function to_object_group_by_id($array, $id)
	{
		foreach($array as $item)
		{
			if ($item['id'] == $id)
				return $item;
		}
		return null;
	}
	/*
	* Obtiene los profesores que dan esa materia.
	*/
	function get_teachers_from_array($array, $code)
	{
		$teachers = array();
		foreach($array as $item)
		{
			if ($item['code'] == $code)
			{
				$exists = false;
				foreach($teachers as $item_t)
				{
					if ($item_t['id'] == $item['teacher_id'])
						$exists = true;
				}
				if (!$exists)
					array_push($teachers, array(
						"id" => $item['teacher_id'],
						"name" => $item['name_teacher']
					));
			}
		}
		return $teachers;
	}
	/*
	* Obtiene los grupos que da ese profesor.
	*/
	function get_groups_from_array($array, $code, $teacher)
	{
		$groups = array();
		foreach($array as $item)
		{
			if ($item['code'] == $code && $item['teacher_id'] == $teacher)
			{
				$exists = false;
				foreach($groups as $item_g)
				{
					if ($item_g['name'] == $item['name'])
						$exists = true;
				}
				if (!$exists)
					array_push($groups, array(
						"id" => $item['id'],
						"name" => $item['name']
					));
			}
		}
		return $groups;
	}
	/*
	* Obtiene el nombre de la materia del listado.
	*/
	function get_name_from_array($array, $code)
	{
		foreach($array as $item)
		{
			if ($item['code'] == $code)
				return $item['name_subject'];
		}
		return '';
	}
	/*
	* Genera la paginación de los reportes
	*/
	function generate_pagination($array)
	{
		$pagination = '<nav aria-label="Page navigation"><ul class="pagination">';
		$i = 0;
		foreach($array as $item)
		{
			$i += 1;
			$pagination .= '<li><a style="cursor: pointer;" onclick="generar_horarios(\''.$i.'\')">'.$i.'</a></li>';
		}
		$pagination .= '</ul></nav>';
		return $pagination;
	}