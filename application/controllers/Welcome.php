<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
		$this->load->view('headers');
		$this->load->view('login');
		$this->load->view('footer');
	}

	function login(){
		$username = $this->input->post('username');
		$password = md5($this->input->post('password'));

		$user = $this->general_model->get_data_table('users',array('username'=>$username,'password'=>$password));
		if($user){
			$this->session->set_userdata([
				"username"=>$user->username,
				"id"=>$user->id
			]);
			redirect(base_url('Home'));
		}else{
			$this->session->set_flashdata('messege','record tidak ditemukan!');
			redirect(base_url(''));
		}
	}

	function registrasi_form(){
		$this->load->view('headers');
		$this->load->view('registrasi');
		$this->load->view('footer');
	}

	function registrasi(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$password1 = $this->input->post('password1');
		
		if($password==$password1){
			$pass = md5($password);
			$user = $this->general_model->insertData('users',array('username'=>$username,'password'=>$pass));
			if($user){
				$this->session->set_flashdata('messege','success diinput!');
				redirect(base_url('Welcome/registrasi_form'));
			}else{
				$this->session->set_flashdata('messege','gagal diinput!');
				redirect(base_url('Welcome/registrasi_form'));
			}
		}else{
			$this->session->set_flashdata('messege','Password tidak cocok!');
			redirect(base_url('Welcome/registrasi_form'));
		}
	}

	function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}
}
