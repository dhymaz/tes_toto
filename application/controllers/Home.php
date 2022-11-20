<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data =[];
		$data['barang'] = $this->general_model->get_data_table_no_paging('barang');
		$this->load->view('headers');
		$this->load->view('home',$data);
		$this->load->view('footer');

	}


	public function add()
	{
		$item_name = $this->input->post('item_name');
		$qty = $this->input->post('qty');
		$location = $this->input->post('location');
		$color = $this->input->post('color');

		$action = $this->general_model->insertData('barang',array('item_name'=>$item_name,'qty'=>$qty,'location'=>$location,'color'=>$color));

		if($action){
			$this->session->set_flashdata('messege','record ditambahkan!');
			redirect(base_url('Home'));
		}else{
			$this->session->set_flashdata('messege','record gagal ditambahkan!');
			redirect(base_url('Home'));
		}
		
	}

	public function edit($id)
	{
		$item_name = $this->input->post('item_name');
		$qty = $this->input->post('qty');
		$location = $this->input->post('location');
		$color = $this->input->post('color');

		$action = $this->general_model->updateData('barang',array('item_name'=>$item_name,'qty'=>$qty,'location'=>$location,'color'=>$color),array('id'=>$id));

		if($action){
			$this->session->set_flashdata('messege','record diubah!');
			redirect(base_url('Home'));
		}else{
			$this->session->set_flashdata('messege','record gagal diubah!');
			redirect(base_url('Home'));
		}
		
	}

	public function delete($id)
	{
		$action = $this->general_model->deleteData('barang',array('id'=>$id));

		if($action){
			$this->session->set_flashdata('messege','record dihapus!');
			redirect(base_url('Home'));
		}else{
			$this->session->set_flashdata('messege','record gagal dihapus!');
			redirect(base_url('Home'));
		}
		
	}
}
