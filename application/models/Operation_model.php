<?php
class Operation_model extends CI_Model{
	function __construct(){
	 parent::__construct();
	}
	public function get_count() {
        return $this->db->count_all('employees');
    }
	public function get_employees_pagination($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get('employees');
        return $query->result();
    }

	public function save($table,$data){
		$this->db->insert($table,$data);
		
	}
	public function getAllEmployeeData(){
		return $this->db->select('*')
						->from('employees')
						->get()->result();
	}
	public function getSpecific($table,$id){
	  return $this->db->select('*')
						->from($table)
						->where('id',$id)
						->get()->row();
	  
  }
   public function checkEmailData($email,$id){
  	 $data=$this->db->select('*')
						->from('employees')
						->where('id',$id)
						->where('email',$email)
						->get()->row();
	if(empty($data)){
		$checkEmailInOverAllTable=$this->db->select('*')
						->from('employees')
						->where('email',$email)
						->get()->row();
	   if(!empty($checkEmailInOverAllTable)){
	   		return 1;
	   }else{
	   		return 0;
	   }

	}else{
		return 0;
	}
	
  }
  public function updateSpecificField($table,$matchWithDBField,$matchByInputField,$data){
		 return $this->db->where($matchWithDBField,$matchByInputField)
					 ->update($table,$data);

	}
	
	public function getAllEmployeeWithName($name,$limit, $start){
			return $this->db->select('*')
						->from('employees')
						->like('employees.name',$name,'both',false)
						->limit($limit, $start)
						->get()->result();
					
	}
	
	
}
?>