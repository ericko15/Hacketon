<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* Clase que genera la paginación.
	*/
	class Pagination
	{
		function __construct()
		{}
		/*
		*
		*/
		public function generate_buttons($url, $length, $jump)
		{
			$pagination = '<nav aria-label="Page navigation"><ul class="pagination">';

			$number = 1;
			for($i = 0; $i < $length; $i += $jump)
			{
				$pagination .= '
					<li>
						<a style="cursor: pointer;" onclick="load_subjects_by_program(\''.$url.$i.'/'.($i + $jump).'\')">'.$number.'</a>
					</li>
				';
				$number += 1;
			}

  			$pagination .= '</ul></nav>';
  			return $pagination;
		}
	}