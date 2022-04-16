<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Rooms extends Admin_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_rooms');
    } 
    /*
     * Listing of ip_rooms
     */
    function index()
    {
        $data['ip_rooms'] = $this->mdl_rooms->get_all_ip_rooms();
        $this->layout->buffer('content', 'rooms/index',$data);
        $this->layout->render();
    }
    /*
     * Adding a new ip_room
     */
    function add(){   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'active' => $this->input->post('active'),
                'show_on_system' => $this->input->post('show_on_system'),
				'name' => $this->input->post('name'),
            );
            
            $ip_room_id = $this->mdl_rooms->add_ip_room($params);
            redirect('rooms/index');
        }
        else{            
            $this->layout->buffer('content', 'rooms/add');
            $this->layout->render();
        }
    }  
    /*
     * Editing a ip_room
     */
    function edit($id)
    {   
        // check if the ip_room exists before trying to edit it
        $data['ip_room'] = $this->mdl_rooms->get_ip_room($id);
        
        if(isset($data['ip_room']['id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'active' => $this->input->post('active'),
                    'show_on_system' => $this->input->post('show_on_system'),
					'name' => $this->input->post('name'),
                );

                $this->mdl_rooms->update_ip_room($id,$params);            
                redirect('rooms/index');
            }
            else
            {
                $this->layout->buffer('content', 'rooms/edit',$data);
                $this->layout->render();
            }
        }
        else
            show_error('The room you are trying to edit does not exist.');
    } 
    /*
     * Deleting ip_room
     */
    function remove($id){
        $ip_room = $this->mdl_rooms->get_ip_room($id);
        // check if the ip_room exists before trying to delete it
        if(isset($ip_room['id']))
        {
            $this->mdl_rooms->delete_ip_room($id);
            redirect('rooms/index');
        }
        else
            show_error('The room you are trying to delete does not exist.');
    }
    
}