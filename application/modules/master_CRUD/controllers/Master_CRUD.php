<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @author 		Oky Octaviansyah <oky.octaviansyah@yahoo.co.id>
*/

class Master_CRUD extends CI_Controller {
	
	

	public function __construct()
	{	
		parent::__construct();
		$this->load->model('Alus_items');
	}

	public function index()
	{
		if($this->alus_auth->logged_in())
         {
         	$title_head = "master_CRUD";
         	$head['title'] = $title_head;
         	$data['title_head'] = $title_head;

         	/*DATA*/

         	/*END DATA*/

		 	$this->load->view('template/temaalus/header',$head);
		 	$this->load->view('index',$data);
		 	$this->load->view('template/temaalus/footer');
		}else
		{
			redirect('admin/Login','refresh');
		}
	}


	/*AJAX LIST*/

	public function ajax_list()
    {
        $list = $this->Alus_items->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $person) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $person->mh_buidingname;
            $row[] = $person->mh_buildingcode;
 			
        	$row[] = "<a href='javascript:' onClick='btn_modal_edit(".$person->mh_id.")' data-toggle='tooltip' data-placement='bottom' title='Edit' class='btn btn-xs btn-flat btn-primary' style='background:#00897b'><i class='fa fa-edit'></i> Edit</a>".
        			 "<a href='javascript:' onClick='btn_modal_delete(".$person->mh_id.")' data-toggle='tooltip' data-placement='bottom' title='Delete' class='btn btn-xs btn-flat btn-danger'><i class='fa fa-trash'></i> Delete</a>";
        	
            //add html for action
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->Alus_items->count_all(),
                        "recordsFiltered" => $this->Alus_items->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }

    /*MODAL*/

    function modal_add()
    {
    	$data['title'] = "Add master_CRUD";
    	$this->load->view('ajax/modal_add', $data, FALSE);
    }

    function modal_edit($id)
    {
    	$data['data'] = $this->Alus_items->getid($id);
    	$data['title'] = "Edit master_CRUD";
    	$this->load->view('ajax/modal_edit', $data, FALSE);
    }

    /*ACTION*/

    function save()
    {
    	$data = array(
					'mh_hospitalregistrationid' => 0,
					'mh_buidingname' => $this->input->post('mh_buidingname'),
					'mh_buildingcode' => $this->input->post('mh_buildingcode'),
    				 );

    	$q = $this->Alus_items->save($data);
    	if($q)
    	{
    		echo "Tersimpan";
    	}
    	else
    	{
    		echo "Tidak Tersimpan";
    	}
    }

    function edit()
    {
    	$data = array(
					'mh_hospitalregistrationid' => 0,
					'mh_buidingname' => $this->input->post('mh_buidingname'),
					'mh_buildingcode' => $this->input->post('mh_buildingcode'),
    				 );

    	$q = $this->Alus_items->edit($data);
    	if($q)
    	{
    		echo "Tersimpan";
    	}
    	else
    	{
    		echo "Tidak Tersimpan";
    	}
    }

    function delete($id)
    {
    	$q = $this->Alus_items->delete($id);
    	if($q)
    	{
    		echo "Terhapus";
    	}
    	else
    	{
    		echo "Tidak Terhapus";
    	}
    }

}

/* End of file X.php */
/* Location: ./application/modules/X/controllers/X.php */