<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Todo extends CI_Controller
{    
    public function index()
    {
        $this->load->view('get_data');
    }
    public function get_data()
    {
        $this->load->view('get_data');
    }    
    public function get_tasks()
    {
        $this->load->helper('url');
        $res      = $this->db->get('todo')->result();
        // $res = $this->db->get_where('todo',array('status'=>1));	
        // $res = $this->db->where('todo',array('status'=>1));
        $data_arr = array();
        $i        = 0;
        foreach ($res as $r) {
            $data_arr[$i]['id']          = $r->id;
            $data_arr[$i]['todo']        = $r->todo;
            $data_arr[$i]['description'] = $r->description;
            $data_arr[$i]['date']        = $r->date;
            $data_arr[$i]['status']      = $r->status;
            $i++;
        }
        echo json_encode($data_arr);
    }
    public function set_status()
    {
        $this->load->helper('url');
        $status = $this->input->input_stream('status');
        $id     = $this->input->input_stream('id');
        $data   = array(
            'status' => $status == 'true' ? 1 : 0
        );
        $res    = $this->db->update('todo', $data, array(
            'id' => $id
        ));
        echo $status == 'true' ? 1 : 0;
    }
    
    public function add_task()
    {
        $this->load->helper('url');
        $this->load->helper('date');
        $type        = $this->input->input_stream('type');
        $data        = $this->input->input_stream('data');
        $todo        = $data['todo'];
        $description = $data['description'];
        $date        = date('Y-m-d', strtotime($data['date']));
        if ($type == 'add') {
            $dataa = array(
                'status' => 0,
                'todo' => $todo,
                'description' => $description,
                'date' => $date
            );
            $res   = $this->db->insert('todo', $dataa);
            if ($res == 1) {
                echo $this->db->insert_id();
            } else {
                echo $res;
            }
        } else if ($type == 'edit') {
            $id    = $data['id'];
            $dataa = array(
                'todo' => $todo,
                'description' => $description,
                'date' => $date
            );
            $res   = $this->db->update('todo', $dataa, array(
                'id' => $id
            ));
            echo $res == 'true' ? 1 : 0;
        } else if ($type == 'delete') {
            $id  = $this->input->input_stream('id');
            $res = $this->db->delete('todo', array(
                'id' => $id
            ));
            echo $res == 'true' ? 1 : 0;
        }
    }
}