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
	public function __construct(){
		parent::__construct();
		$this->load->model('Operation_model','operations');
	}

	public function index() {
		$data['reset']=false;
		$config = array();
        $config["base_url"] = base_url('home') ;
        $config["total_rows"] = $this->operations->get_count();
        $config["per_page"] = 2;
        $config["uri_segment"] = 2;

        $this->pagination->initialize($config);
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$data["links"] = $this->pagination->create_links();

		if($this->input->post()){
			$this->form_validation->set_rules('search_employee_name','Employee Name','required');
			if($this->form_validation->run()==false){
				$data['reset'] = false;
				

		        $data['employees'] = $employees=$this->operations->get_employees_pagination($config["per_page"],$page);
		     	$this->load->view('home',$data);
				
	     	}else{	
				//$employees=$this->operations->getAllEmployeeWithName($this->input->post('search_employee_name'));
				$data['employees'] = $employees=$this->operations->getAllEmployeeWithName($this->input->post('search_employee_name'),$config["per_page"],$page);
				$data['employees']=$employees;
				//$data["links"] = $this->pagination->create_links();
				$data[]=false;
				$this->load->view('home',$data);
		     }
			
		}else{
	       

	        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

	        $data["links"] = $this->pagination->create_links();

	        $data['employees'] = $employees=$this->operations->get_employees_pagination($config["per_page"],$page);//$this->authors_model->get_authors($config["per_page"], $page);
	     	$this->load->view('home',$data);
     	}
     }
    
	/*public function index()
	{
		$data['reset']=false;
		if($this->input->post()){
			$this->form_validation->set_rules('search_employee_name','Employee Name','required');
			if($this->form_validation->run()==false){
				$data['reset'] = false;
				$employees=$this->operations->getAllEmployeeData();
			    $data['employees']=$employees;
				$this->load->view('home',$data);
				
	     	}else{	
				$employees=$this->operations->getAllEmployeeWithName($this->input->post('search_employee_name'));
				$data['employees']=$employees;
				$data[]=false;
				$this->load->view('home',$data);
		     }
			
		}else{
			$employees=$this->operations->getAllEmployeeData();
		    $data['employees']=$employees;
			$this->load->view('home',$data);
		}
		
	}*/
	public function add(){
		$data['reset'] = false;
		if($this->input->post()){
			
			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('address','Address','required');
			$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[employees.email]');
			$this->form_validation->set_rules('phone','Phone','required|numeric|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('dob','DOB','required');
			
			 $config['upload_path']          = './images';
             $config['allowed_types']        = 'gif|jpg|png';
             $config['max_size']             = 100000;
             $config['max_width']            = 100000;
             $config['max_height']           = 100000;
			 $config['file_name']           = uniqid().'_'.$this->input->post('image');
			 $this->load->library('upload',$config);
			 if (empty($_FILES['image']['name']))
			{
				$this->form_validation->set_rules('image', 'image', 'required');
				$data['reset'] = false;
			}

			if($this->form_validation->run()==false){
				$data['reset'] = false;
				
	     	}else{

	     		$file_name='';
                if (!$this->upload->do_upload('image')) {
                    $error = array('error' => $this->upload->display_errors());
					echo "<pre>error===";
					print_r($error);
					die;
                    //$this->load->view('home', $error);
                } else {
					$data = array('upload_data' => $this->upload->data());
					
                    $file_name = $data['upload_data']['file_name'];
					//echo "<br>===file_name==".$config['file_name'];
                    
                }

	     		$data=[
			     		'name'	=>$this->input->post('name'),
			     		'phone'	=>$this->input->post('phone'),
			     		'email'	=>$this->input->post('email'),
			     		'address'	=>$this->input->post('address'),
			     		'dob'	=>$this->input->post('dob'),
			     		'image'=>$file_name,
			     		
			     		];
			     		$this->operations->save('employees',$data);
			     		$data['reset'] = true;
		     		    $this->session->set_flashdata('success','Employee Record Added Successfully');
		     			
	     	}
		}

		$this->load->view('add',$data);
	}
	public function edit($id){
		$data['reset'] = false;
		if($this->input->post()){
			
			$this->form_validation->set_rules('name','Name','required');
			$this->form_validation->set_rules('address','Address','required');
			$this->form_validation->set_rules('email','Email','required|valid_email');
			$this->form_validation->set_rules('phone','Phone','required|numeric|regex_match[/^[0-9]{10}$/]');
			$this->form_validation->set_rules('dob','DOB','required');


			$config['upload_path']          = './images';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 100000;
            $config['max_width']            = 100000;
            $config['max_height']           = 100000;
			$config['file_name']           = uniqid().'_'.$this->input->post('image');
			$this->load->library('upload',$config);



			if($this->form_validation->run()==false){
				$data['reset'] = false;
				
	     	}else{
	     		$employee_id=$id;
	     		$emailDataExist=$this->operations->checkEmailData($this->input->post('email'),$employee_id);
	     		
	     		if($emailDataExist==1){
	     			$data['reset'] = false;
	     			$this->session->set_flashdata('error','Email Already Exist For Other User');
	     			
	     		}else{

	     			if(!$this->upload->do_upload('image')){
						$error = array('error' => $this->upload->display_errors());
						$file_name=$this->input->post('old_image');
					}else{
						$data = array('upload_data' => $this->upload->data());
						$file_name = $data['upload_data']['file_name'];
						if($this->input->post('old_image')){
							$path=FCPATH.'/images/'.$this->input->post('old_image');
							if(is_file($path)){
								unlink($path);
							}else{
								//echo "NOT_-------";
							}
							
							
						}
						
					}

		     		$data=[
				     		'name'	=>$this->input->post('name'),
				     		'phone'	=>$this->input->post('phone'),
				     		'email'	=>$this->input->post('email'),
				     		'address'	=>$this->input->post('address'),
				     		'dob'	=>$this->input->post('dob'),
				     		'image'=>$file_name
				     		
				     		];
				     	$this->operations->updateSpecificField('employees','id',$employee_id,$data);
			     	    $this->session->set_flashdata('success','Employee Record Updated Successfully');
			     		$data['reset']=true;
		     		}
		     			
	     	}
		}
		$employee=$this->operations->getSpecific('employees',$id);

		$data['employee']=$employee;
		$this->load->view('edit',$data);
	}

	public function delete($id){
		$this->db->where('id', $id);
       $this->db->delete('employees'); 
       $this->session->set_flashdata('success','Employee Record Deleted Successfully');
       redirect(base_url());
	}
}
