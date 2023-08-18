
<?php
if (!defined('BASEPATH'))exit('No direct script access allowed');

class Common_model extends CI_Model 
	{

	public function __construct()
    {
        parent::__construct();
	}

	public function getJournalData($filter_option,$filter_value)
	{
		$this->db->select('*');
		$this->db->where($filter_option,$filter_value);
		$this->db->or_like($filter_option, $filter_value, 'both');
		
		$query = $this->db->get('tb_journal');
		return $query->result();
	}

	public function getAllData($table,$where='',$order_by='',$group_by='',$lower_limit='',$higher_limit='')
	{
		if($where)
		{
			$this->db->where($where);	
		}
		if($order_by)
		{
			foreach($order_by as $key=>$value)	
			{
				$this->db->order_by($key,$value);		
			}
		}
		if($group_by)
		{
			foreach($group_by as $key=>$value)	
			{
				$this->db->group_by($key,$value);		
			}
		}		
		if($lower_limit!='' && $higher_limit!='')
		{
			$this->db->limit($lower_limit,$higher_limit);
		}
		$query = $this->db->get($table);
		return $query->result();
	}
	public function insertData($tbl_name = false, $data_array = false)
	{
		$ins_data = $this->db->insert($tbl_name, $data_array);
		if($ins_data){
			return $last_id = $this->db->insert_id();
		}
		else{
			return false;
		}
	}

	public function updateData($table,$data,$where_array)
	{ 
	    $this->db->where($where_array);
		if($this->db->update($table,$data)){
			return true;
		}
		else{
			return false;
		}
	}

	public function getData($table,$where='', $order_by = false, $order = false, $join_array = false, $limit = false)
	{
		$this->db->from($table);

		if(!empty($where))
		{
			$this->db->where($where);
		}
		
		if(!empty($order_by))
		{
			$this->db->order_by($order_by, $order); 	
		}



		if(!empty($join_array))
		{
			foreach ($join_array as $key => $value) {

				$this->db->join($key, $value); 	
			}
			
		}

		if(!empty($limit))
		{
			$this->db->limit($limit); 	
		}

		$result = $this->db->get();
				
		return $result->result();
		
	}

	

	public function getRowData($tbl_name = false, $where = false, $join_array = false)
	{
		$this->db->select('*');
		$this->db->from($tbl_name);
		
		if(isset($where) && !empty($where))
		{
			$this->db->where($where);	
		}
		
		if(!empty($join_array))
		{
			foreach($join_array as $key=>$value){
				$this->db->join($key,$value);
			}	
		}
		
		$query = $this->db->get();
		
		$data_array = $query->row();
		//print_r($this->db->last_query()); exit;
		if($data_array)
		{
			return $data_array;
		}
		else{
			return false;
		}
	}
	public function deleteData($table,$where)
	{ 
		$this->db->where($where);
		if($this->db->delete($table))
		{
			return true;
		}
		else{
			return false;
		}
	}
	
	public function sqlcount($table = false,$where = false)
	{
		$this->db->select('*');	
		$this->db->from($table); 
		if(isset($where) && !empty($where))
		{
			$this->db->where($where);	
		}
		//$this->db->limit($limit, $start);       
		$query = $this->db->get();
		//print_r($this->db->last_query()); exit;
		return $query->num_rows(); 
	}
	
	
	
   
}

