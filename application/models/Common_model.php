
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

	// Function for select data
	// public function getDataField($field = false, $table, $where='', $order_by = false, $order = false, $join_array = false, $limit = false, $join_type = false )
	// {
	// 	$this->db->select($field);

	// 	$this->db->from($table);

	// 	if(!empty($where))
	// 	{
	// 		$this->db->where($where);
	// 	}
		
	// 	if(!empty($order_by))
	// 	{
	// 		$this->db->order_by($order_by, $order); 	
	// 	}



	// 	if(!empty($join_array))
	// 	{
	// 		foreach ($join_array as $key => $value) {

	// 			if(!empty($join_type))
	// 				$this->db->join($key, $value, 'left');
	// 			else
	// 				$this->db->join($key, $value); 	
	// 		}
			
	// 	}

	// 	if(!empty($limit))
	// 	{
	// 		$this->db->limit($limit); 	
	// 	}

	// 	$result = $this->db->get();
		

	// 	//print_r($this->db->last_query()); exit;
	// 	return $result->result();
	// 	//return $result;
	// }

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
	
	public function userAuthentication($post)
	{
		$query=$this->db->where('admin_email',$post['admin_email'])->get('hl_admin');
		$result=$query->row();
		if(empty($result))
			{
			return 'Email address not registered';
			}
		//elseif($this->encrypt->decode($result->admin_password)!=$post['admin_password'])
		elseif(trim($this->encryption->decrypt($result->admin_password))!=$post['admin_password'])	
		 	{
		 		return 'Invalid password';
		 	}elseif($result->admin_status!=1)
		 		{
		 			return 'Your account is not active';
		 		}else
		 			{
		 				$this->updateLoginTime('hl_admin',array('admin_uid'=>$result->admin_uid),array('last_login'=>date('Y-m-d h:i:s A'),'last_ip'=>$this->input->ip_address()));
		 				if($result->admin_type)
		 				{
		 					foreach($result as $key=>$value)
		 					{
		 						$this->session->set_userdata($key,$value);	
		 					}	
		 				}
		 				return 'success';
		 			}
	}
	public function updateLoginTime($table,$where,$data)
	{
			$this->db->where($where);
			$this->db->update($table,$data);
			return;
	}
	public function getUserInfoByEmail($table,$email)
	{
       $q = $this->db->get_where('hl_admin', array('admin_email' => $email));  
       if($q->num_rows()==1)
        {
            $row = $q->row();
            return $row;
        }else
        {
            return false;
        }
    }
    public function updateToken($admin_uid)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $mdate=date('Y-m-d');
        $verifiedData = array('admin_verification_code'=>$token,'admin_password'=>' ','datetime_modified'=>$mdate);
        $this->db->where(array('admin_uid'=>$admin_uid));
        $this->db->update('hl_admin',$verifiedData);
        return $token . $admin_uid;
    }  
    public function updatePassword($post){   
    	$this->db->where('admin_uid', $post['user_id']);
    	$pwd=$this->encrypt->encode($post['password']);
        $this->db->update('hl_admin', array('admin_password' =>$pwd,'admin_verification_code'=>' ')); 
        $success = $this->db->affected_rows(); 
        if(!$success){
            return false;
              }        
       		return true;
    } 
    public function verficationCode($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       $q = $this->db->get_where('hl_admin', array('admin_verification_code' => $tkn,'admin_uid'=>$uid));
        if($this->db->affected_rows() > 0){
            $row = $q->row();             
            $admin_info = $this->getUserInfo($row->admin_uid);
            return $admin_info;
        }else{
            return false;
        }
    }
    public function getUserInfo($id)
    {
        $q = $this->db->get_where('hl_admin', array('admin_uid' => $id));  
        if($this->db->affected_rows() >0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }	
   
}

