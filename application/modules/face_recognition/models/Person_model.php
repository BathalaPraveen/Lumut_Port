<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Person_model extends CI_Model
{
    protected $table = FACE_PERSON;

    public function __construct()
    {
        parent::__construct();
    }

    public function create_person($data)
    {
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function get_by_subject($subject)
    {
        return $this->db
            ->where('face_subject', $subject)
            ->where('status', 1)
            ->get($this->table)
            ->row();
    }

    public function get_by_person_code($person_code)
    {
        return $this->db
            ->where('person_code', $person_code)
            ->get($this->table)
            ->row();
    }

    public function subject_exists($subject)
    {
        return $this->db
            ->where('face_subject', $subject)
            ->count_all_results($this->table) > 0;
    }
}