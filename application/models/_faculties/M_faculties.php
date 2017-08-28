<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class M_faculties extends CI_Model{
        function __constructor()
        {
            parent::__construct();
        }
        /*
        * Obtener Listado de Facultades.
        */
        public function get_list_faculties()
        {
            $query = $this->db->get('faculties');
            if ($query->num_rows() > 0)
            {
                $index = 0;
                foreach ($query->result() as $row)
                {
                    $data[$index]['id'] = $row->id;
                    $data[$index]['name'] = $row->name;
                    $index += 1;
                }
                return $data;
            }
            else
            {
                return null;
            }
        }
        /*
        * Obtener Listado de Programas filtrado por una facultad.
        */
        public function load_programs_by_faculty($faculty)
        {
            $query = $this->db->get_where('programs', array('faculty_code' => $faculty));
            if ($query->num_rows() > 0)
            {
                $index = 0;
                foreach($query->result() as $row)
                {
                    $data[$index]['id'] = $row->id;
                    $data[$index]['faculty_code'] = $row->faculty_code;
                    $data[$index]['snies_code'] = $row->snies_code;
                    $data[$index]['name'] = $row->name;
                    $index += 1;
                }
                return $data;
            }
            else
            { return null; }
        }
        /*
        * Consultar las materias por programa.
        */
        public function load_subjects_by_program($program, $offset, $limit)
        {
            $sql = "
                SELECT DISTINCT
                    sp.id, sp.program_id, sp.subject_id, 
                    s.name, s.credits, s.code,  
                    '' AS quote 
                FROM 
                    subjects_programs sp 
                INNER JOIN 
                    subjects s ON s.id = sp.subject_id 
                WHERE 
                    sp.program_id = 
            ".$program." LIMIT ".$limit." OFFSET ".$offset;
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0)
            {
                $index = 0;
                foreach($query->result() as $row)
                {
                    $data[$index]['id'] = $row->id;
                    $data[$index]['code'] = $row->code;
                    $data[$index]['program_id'] = $row->program_id;
                    $data[$index]['subject_id'] = $row->subject_id;
                    $data[$index]['name'] = $row->name;
                    $data[$index]['credits'] = $row->credits;
                    $data[$index]['quote'] = $row->quote;
                    $index += 1;
                }
                return $data;
            }
            else
            { return null; }
        }
        /*
        * Consultar la cantidad de registros en total de las masterias por programa.
        */
        public function get_count_subjects_by_program($program)
        {
            $sql = "
                SELECT DISTINCT
                    sp.id, sp.program_id, sp.subject_id, 
                    s.name, s.credits, 
                    '' AS quote 
                FROM 
                    subjects_programs sp 
                INNER JOIN 
                    subjects s ON s.id = sp.subject_id 
                WHERE 
                    sp.program_id = 
            ".$program;
            $query = $this->db->query($sql);
            return $query->num_rows();
        }
        /*
        * Consulta los grupos de las materias seleccionadas.
        */
        public function get_groups($subjects)
        {
            $sql = "
                SELECT 
                    s.code, s.name AS name_subject, 
                    g.id, g.name, g.teacher_id, 
                    t.name AS name_teacher 
                FROM subjects s 
                INNER JOIN groups g 
                    ON g.subject_id = s.id 
                INNER JOIN teachers t 
                    ON t.id = g.teacher_id 
                WHERE s.code IN (".$subjects.") 
            ";
            $result = $this->db->query($sql);
            if ($result->num_rows() > 0)
            {
                $i = 0;
                foreach($result->result() as $item)
                {
                    $data[$i]['code'] = $item->code;
                    $data[$i]['name_subject'] = $item->name_subject;
                    $data[$i]['id'] = $item->id;
                    $data[$i]['name'] = $item->name;
                    $data[$i]['teacher_id'] = $item->teacher_id;
                    $data[$i]['name_teacher'] = $item->name_teacher;
                    $i += 1;
                }
                return $data;
            }
            return null;
        }
        /*
        * Consulta los grupos de una materia.
        */
        public function get_groups_by($code, $teacher_id)
        {
            $sql = "
                SELECT DISTINCT 
                    g.name 
                FROM 
                    groups g  
                WHERE 
                    g.subject_id = (
                        SELECT s.id 
                        FROM subjects s 
                        WHERE s.code = '".$code."'
                    ) AND g.teacher_id = ".$teacher_id
            ;
            $result = $this->db->query($sql);
            if($result->num_rows() > 0)
            {
                $groups = array();
                foreach($result->result() as $item)
                    array_push($groups, $item->name);

                return join(",", $groups);
            }
            return null;
        }
        /*
        * Convierte el codigo de la materia en un nombre.
        */
        public function convert_to_name_subject($code)
        {
            $sql = "SELECT name FROM subjects WHERE code = '".$code."'";
            $result = $this->db->query($sql);
            if($result->num_rows() > 0)
            {
                foreach($result->result() as $item)
                    return $item->name;
            }
            return '';
        }
        /*
        * Convierte los grupos generados por el algoritmo a objectos entendibles,
        */
        public function consult_groups($sbjs, $gps, $teachs)
        {
            $sql = "
                SELECT 
                    g.id, g.name, g.max_capacity, g.current_quota, g.subject_id, g.teacher_id, 
                    dg.id, dg.start_time, dg.final_hour, dg.day, 
                    t.name AS name_teacher, 
                    s.name AS name_subject, s.credits, s.code 
                FROM 
                    groups g 
                INNER JOIN 
                    detail_group dg ON dg.group_id = g.id 
                INNER JOIN 
                    teachers t ON t.id = g.teacher_id 
                INNER JOIN 
                    subjects s ON s.id = g.subject_id 
                WHERE 
                    g.subject_id IN (
                        SELECT s1.id FROM subjects s1 WHERE s1.code IN (".join(",", array_unique($sbjs)).")
                    ) AND 
                    g.name IN (".join(",", array_unique($gps)).") AND 
                    g.teacher_id IN (".join(",", array_unique($teachs)).")
            ";
            //echo $sql."---------------------------<br>";
            $result = $this->db->query($sql);
            if ($result->num_rows() > 0)
            {
                $data = array();
                foreach($result->result() as $item)
                {
                    array_push($data, array(
                        'id' => $item->id,
                        'name' => $item->name,
                        'start_time' => $item->start_time,
                        'final_hour' => $item->final_hour,
                        'day' => $item->day,
                        'max_capacity' => $item->max_capacity,
                        'current_quota' => $item->current_quota,
                        'subject_id' => $item->subject_id,
                        'name_subject' => $item->name_subject,
                        'code' => $item->code,
                        'credits' => $item->credits,
                        'teacher_id' => $item->teacher_id,
                        'name_teacher' => $item->name_teacher
                    ));
                }
                return $data;
            }
            return null;
        }
    }