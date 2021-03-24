<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2018 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Products
 */
class Reservations extends Admin_Controller
{
    /**
     * Products constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model("mdl_reservations");
        $this->load->model("rooms/mdl_rooms");
    }

    /**
     * @param int $page
     */
    public function index(){
        $this->load->view("reservations/index");
    }

    public function backend_reservations(){
        $this->load->model("mdl_reservations");
        foreach($this->mdl_reservations->getAll() as $res){
            $res->start=$res->start."T14:00:00";
            $res->end=$res->end."T12:00:00";

            $res->bgcolor="green";
            $result[]=$res;
        }
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function new(){

        $start = date_create($this->input->get("start"));
        $end = date_create($this->input->get("end"));

        $reservation=array(
        "start"=>$start,
        "end"=>$end,
        "room_id"=>$this->input->get("room_id"),
        "rooms"=>$this->mdl_rooms->getAllRooms()
        );
        $this->layout->load_view("reservations/new",$reservation);
    }

    public function edit(){
        $id=$this->input->get("id");
        $reservations=$this->mdl_reservations->getById($id);
        $reservations=$reservations[0];
        $start = new DateTime($reservations->start);
        $end= new DateTime($reservations->end);

        $reservations->start=$start;
        $reservations->end=$end;


        $data=array(
            "reservations"=>$reservations,
            "rooms"=> $this->mdl_rooms->getAllRooms()
        );
        $this->layout->load_view("reservations/edit",$data);
    }

    public function newPost($id=null){

        $this->load->model("mdl_reservations");
        $name=$this->input->post("name");
        $start = date("Y-m-d", strtotime($this->input->post("start")));
        $end = date("Y-m-d", strtotime($this->input->post("end")));

        $reservation=array(
            "title"=>$name,
            "start"=>$start."T14:00:00",
            "end"=>$end."T12:00:00",
            "room_id"=>$this->input->post("room_id"),
        );

        if(empty($name)){
            echo "name is empty";
        }else{

            $this->mdl_reservations->add($reservation,$id);
            echo "add successfully.";
        }
    }

    public function delete($id){
        $this->mdl_reservations->delete($id);
    }
}
