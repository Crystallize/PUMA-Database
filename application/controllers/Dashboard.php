<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set("Europe/London");
		
class Dashboard extends CI_Controller 
{
	function __construct()
    {
    	#load library and helpers 
        parent::__construct();
        $this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		// $this->load->library('encrypt');
		$this->load->model('Common_model','CM');
		#checking user is logged in or not
		if($this->session->userdata('login_data_puma')=='')
		{
			redirect('login');
		}
    }

    # function load dashboard
	public function index()
	{
		#getting session data
		$sess=$this->session->userdata('login_data_puma');
		$user_uid_temp=$sess['user_uid'];
		$where = "`user_uid_temp`='$user_uid_temp'";	
		#get data of boolean search for logged in user
		$sql_temp_last = $this->CM->getData('tb_temp_sql',$where,'date_time','DESC');
		#check if single query posted
		if($this->input->post('getSingleRecord'))
		{
			$sql_uid_posted = $this->input->post('getSingleRecord');
			#getting query from tb_temp_sql based on sql id posted 
			$sql_query_data = $this->CM->getData('tb_temp_sql',array('sql_uid'=>$sql_uid_posted));
			$sql_query_data = $sql_query_data[0]; //get query string
			$sql_where  = $sql_query_data->sql_where; //get sql where clause
			$search_query = $sql_query_data->query; // get sql complete query
			#load data from tb_journals for sql_where
			$jorunal_data = $this->CM->getData('tb_journal',$sql_where);
			$data['search_query'] = $search_query;
			$sql_temp = $this->CM->getData('tb_temp_sql',$where);
			$data['sql_temp'] = $sql_temp;
			$data['journal_data'] = $jorunal_data; //send data into variable for sending front end view

		}
		elseif($sql_temp_last)
		{
			#if there is last query exist then get record for last searched
			$temp_where_sql = $sql_temp_last[0]->sql_where; 
			
			$data['search_query'] = $sql_temp_last[0]->query;
			$sql_temp = $this->CM->getData('tb_temp_sql',$where);
			$data['sql_temp'] = $sql_temp;
			$sql = "SELECT * FROM `tb_journal` WHERE $temp_where_sql";
			$result = $this->db->query($sql);
			$journal_data = $result->result();
			$data['journal_data'] = $journal_data;
			//$data['journal_data'] = $this->CM->getAllData('tb_journal',$temp_where_sql);
		}
		else
		{
			//when user logged in and nothing searched
			$data['search_query'] = "";
			$sql_temp = $this->CM->getData('tb_temp_sql',$where);
			$data['sql_temp'] = $sql_temp;
			$data['journal_data'] = $this->CM->getData('tb_journal');
		}	
		
		$this->load->view('journal_records',$data);
	}

	//remove searched result 
	public function clearQuery()
	{
	    $sess=$this->session->userdata('login_data_puma');
		$user_uid_temp=$sess['user_uid'];
		$where = "`user_uid_temp`='$user_uid_temp'";	
	    $this->CM->deleteData('tb_temp_sql',$where);
	    redirect('dashboard');
	}

	//link to user guide page
	public function userGuide()
	{
		$this->load->view('userguide');
	}

	// delete selected search result
	public function deleteSearchItem()
	{
		$array_query = $this->input->post('checkboxValues');
		$array_id = $this->input->post('checkboxValuesID');
		for($i=0;$i<sizeof($array_query);$i++)
		{
			$sql_uid = $array_query[$i];
			$resultRow = $this->CM->deleteData('tb_temp_sql',array('sql_uid'=>$sql_uid));
			$del_sql = "DELETE FROM `tb_temp_sql` WHERE `sql_join_query_ids` LIKE '%$sql_uid%'";
			$this->db->query($del_sql);	
		}
	}

	//deleted single search result
	public function DeleteSingleSearch()
	{
		$sql_uid = $this->input->post('sql_uid');
		$resultRow = $this->CM->deleteData('tb_temp_sql',array('sql_uid'=>$sql_uid));
		
	}

	// search query with AND boolean search for multiple checkbox
	public function AndSearchItem()
	{
		$array_query = $this->input->post('checkboxValues');
		$array_id = $this->input->post('checkboxValuesID');
		$combined_where = "";
		$search_query = "";
		$sql_join_query_ids=implode(",",$array_query);

		#exploding all the ids and search into database actual query and merge them into single query
		for($i=0;$i<sizeof($array_query);$i++)
		{
			$sql_uid = $array_query[$i];
			$resultRow = $this->CM->getRowData('tb_temp_sql',array('sql_uid'=>$sql_uid));
			if($combined_where)
			{
				$combined_where = $combined_where.' AND ('.$resultRow->sql_where.')';
				$search_query = $search_query.' AND #'.$array_id[$i];
			}
			else
			{
				$combined_where = '('.$resultRow->sql_where.')';
				$search_query = '#'.$array_id[$i];
			}	
		}
		#get records from journal table for that merged query
		$sql = "SELECT * FROM `tb_journal` WHERE $combined_where";
		$query = $this->db->query($sql);
		$result = $this->db->query($sql);
		$journal_data = $result->result();
		$count = count($journal_data);
		$sess=$this->session->userdata('login_data_puma');
		$user_name = $sess['user_fname'].' '.$sess['user_lname'];
		$sql_uid = uniqid();
		$sql_datetime = date('Y-m-d H:i:s');
		
		$sql_temp_data = array(
			'sql_uid' =>$sql_uid,
			'user_uid_temp'=>$sess['user_uid'],
			'query'=>$search_query,
			'sql_where'=>$combined_where,
			'sql_query'=>$sql,
			'sql_join_query_ids'=>$sql_join_query_ids,
			'date_time'=>$sql_datetime,
			'total_result'=>$count
		);
		#entry new query into temporary sql table
		$this->CM->insertData('tb_temp_sql',$sql_temp_data);
			
			$sql_log_data = array(
				'unique_id'=>uniqid(),
				'query_id' =>$sql_uid,
				'user_id'=>$sess['user_uid'],
				'user_name'=>$user_name,
				'query'=>$combined_where,
				'sql_query'=>$sql,
				'datetime_created'=>$sql_datetime,
				'total_result'=>$count
			);
			#entry into activity log table
			$this->CM->insertData('tb_activity_log_query',$sql_log_data);
	}

	// search query with OR boolean search for multiple checkbox
	public function OrSearchItem()
	{
		$array_query = $this->input->post('checkboxValues');
		$array_id = $this->input->post('checkboxValuesID');
		
		$combined_where = "";
		$search_query = "";
		$sql_join_query_ids=implode(",",$array_query);
		for($i=0;$i<sizeof($array_query);$i++)
		{
			$sql_uid = $array_query[$i];
			$resultRow = $this->CM->getRowData('tb_temp_sql',array('sql_uid'=>$sql_uid));
			if($combined_where)
			{
				$combined_where = $combined_where.' OR ('.$resultRow->sql_where.')';
				$search_query = $search_query.' OR #'.$array_id[$i];
			}
			else
			{
				$combined_where = '('.$resultRow->sql_where.')';
				$search_query = '#'.$array_id[$i];
			}	
		}
		$sql = "SELECT * FROM `tb_journal` WHERE $combined_where";
		
		$query = $this->db->query($sql);
		$result = $this->db->query($sql);
		$journal_data = $result->result();
		$count = count($journal_data);
		$sess=$this->session->userdata('login_data_puma');
		$user_name = $sess['user_fname'].' '.$sess['user_lname'];
		$sql_uid = uniqid();
		$sql_datetime = date('Y-m-d H:i:s');
		
		$sql_temp_data = array(
			'sql_uid' =>$sql_uid,
			'user_uid_temp'=>$sess['user_uid'],
			'query'=>$search_query,
			'sql_where'=>$combined_where,
			'sql_query'=>$sql,
			'sql_join_query_ids'=>$sql_join_query_ids,
			'date_time'=>$sql_datetime,
			'total_result'=>$count
		);
		$this->CM->insertData('tb_temp_sql',$sql_temp_data);
			
			$sql_log_data = array(
				'unique_id'=>uniqid(),
				'query_id' =>$sql_uid,
				'user_id'=>$sess['user_uid'],
				'user_name'=>$user_name,
				'query'=>$combined_where,
				'sql_query'=>$sql,
				'datetime_created'=>$sql_datetime,
				'total_result'=>$count
			);
			$this->CM->insertData('tb_activity_log_query',$sql_log_data);
		
	}

	//get phpinfo for checking version of php
	public function phpinfo()
	{
		echo phpinfo();
	}

	public function startsWith ($string, $startString)
	{
	    $len = strlen($startString);
	    return (substr($string, 0, $len) === $startString);
	}
	
	// search data for input from dashboard
	public function searchItemResult()
	{
		if($this->input->post('search_query'))
		{
			$search_query = $this->input->post('search_query');	
			$sample = $search_query;
			$sample = strtolower($sample); #convert search string to lowercase be
			$text = $sample;
			$text_inside_backet = preg_match('#\[(.*?)\]#', $text, $match);
			if(!empty($match))
			{
				$text_inside_backet = $match[1];
				$text_inside_backet_replaced = str_replace(' ', "_", $text_inside_backet);
				$new_full_text = str_replace($text_inside_backet, $text_inside_backet_replaced, $text);
			}
			else
			{
				$new_full_text = $sample;
			}
				
			
			$new_full_text =  str_replace('not', " and not ", $new_full_text);
			$sample = $new_full_text;

	    	$newquery = array();
			$all_numbers = array();
			if(str_contains($sample,'#') )
			{
				$regex = '~(#\w+)~';
				if (preg_match_all($regex, $sample, $matches, PREG_PATTERN_ORDER)) {
				   foreach ($matches[1] as $word) {
				      $word_hash =  $word;
				      $word_without_hash = explode('#', $word_hash);
				      $all_numbers[] = $word_without_hash[1];
				   }
				}
				if(str_contains($sample,'and') )
				{
					$between_op = ' and ';
					$between_op_search = ' and ';
				}
				if(str_contains($sample,'or') )
				{
					$between_op = ' or ';
					$between_op_search = ' or ';
				}
				if(str_contains($sample,'not') )
				{
					$between_op = ' and not ';
					$between_op_search =  ' not ';
				}
				$sess=$this->session->userdata('login_data_puma');
				$user_uid_temp=$sess['user_uid'];
				$where = "`user_uid_temp`='$user_uid_temp'";
				$all_query = $this->CM->getData('tb_temp_sql',$where);
			    $i=1;
			    foreach ($all_query as $key) {
			    	if(in_array($i, $all_numbers))
			    	{
			    		$array_query[] = $key->sql_uid;
			    		$array_id[] = $i;
			    	}
			    	$i++;
			    }
			    $combined_where = "";
				//$search_query = "";
				$sql_join_query_ids=implode(",",$array_query);
				for($i=0;$i<sizeof($array_query);$i++)
				{
					$sql_uid = $array_query[$i];
					$resultRow = $this->CM->getRowData('tb_temp_sql',array('sql_uid'=>$sql_uid));
					if($combined_where)
					{
						$combined_where = $combined_where.$between_op.'('.$resultRow->sql_where.')';
						//$search_query = $search_query.$between_op_search.' #'.$array_id[$i];
					}
					else
					{
						$combined_where = '('.$resultRow->sql_where.')';
						//$search_query = '#'.$array_id[$i];
					}	
				}
				$sample = $combined_where;
			}
			else
			{	
				if(strpos($sample,'match'))
				{
					$bits = explode(' ', $sample);
					foreach($bits as $bit)
					{
						if(!strpos($bit,"match") && !strpos($bit,"[") && !strpos($bit,"]") ) 
				    	{
				    		if($bit=='and'||$bit=='or')
				    		{
				    			$newquery[] = $bit;	
				    		}
				    		else
				    		{
				    			$newquery[] = "'".trim($bit)."'";
				    		}
				    	}
				    	else
				    	{
				    		$newquery[] = $bit;
				    	}
					}
					$newquery = implode(' ', $newquery);
					$newquery = str_replace('[', "`", $newquery);
					$newquery = str_replace(']match', "` =", $newquery);
					$newquery = str_replace('] match', "` =", $newquery);
				}
				if(!empty($newquery))
				{
					$sample = $newquery;
					$newquery = '';
				}
				if(strpos($sample,'contains') )
				{
					$bits = explode(' ', $sample);
					$newquery = array();
					foreach($bits as $bit)
					{
						if(!strpos($bit,"contains") && !strpos($bit,"[") && !strpos($bit,"]")) 
				    	{
				    		if($bit=='and'||$bit=='or')
				    		{
				    			$newquery[] = $bit;	
				    		}
				    		else
				    		{
				    			$newquery[] = "'%".trim($bit)."%'";
				    		}	
				    	}
				    	else
				    	{
				    		$newquery[] = $bit;
				    	}
					}
					$newquery = implode(' ', $newquery);
					$newquery = str_replace('[', "`", $newquery);
					$newquery = str_replace(']contains', "` like ", $newquery);
					$newquery = str_replace('] contains', "`  like ", $newquery);
				}
				if(!empty($newquery))
				{
					$sample = $newquery;
					$newquery = '';
				}
				if(strpos($sample,'>') || strpos($sample,'<') || strpos($sample,'=') )
				{
					$newquery = str_replace('[', "`", $sample);
					$newquery = str_replace(']', "`", $newquery);
				}
				if(!empty($newquery))
				{
					$sample = $newquery;
					$newquery = '';
				}
				if(strpos($sample,'[') || strpos($sample,']'))
				{ 
					echo $sample;
					$bits = explode(' ', $sample);
					$newquery = array();
					foreach($bits as $bit)
					{
						if(strpos($bit,"[") || strpos($bit,"]")) 
				    	{
				    		if($bit=='and'||$bit=='or')
				    		{
				    			$newquery[] = $bit;	
				    		}
				    		else
				    		{
				    			$bit_arr = explode(']', $bit);
				    			echo '<pre>';
				    			print_r($bit_arr);
				    			$newquery[] = str_replace('[', "`", $bit_arr[0])."` LIKE '%".trim($bit_arr[1])."%'";
				    		}	
				    	}
				    	else
				    	{
				    		$newquery[] = $bit;
				    	}
					}
					$newquery = implode(' ', $newquery);
				}
				if(!empty($newquery))
				{
					$sample = $newquery;
					$newquery = '';
				}
				if(strpos($sample,'null'))
				{
					$sample = str_replace('=null', " IS NULL ", $sample);
				}
			}	
			$sql = "SELECT * FROM `tb_journal` WHERE $sample";
			$query = $this->db->query($sql);
			$result = $this->db->query($sql);
			$journal_data = $result->result();
			$count = count($journal_data);
			$sess=$this->session->userdata('login_data_puma');
			$user_name = $sess['user_fname'].' '.$sess['user_lname'];
			$sql_uid = uniqid();
			$sql_datetime = date('Y-m-d H:i:s');
			$sql_temp_data = array(
				'sql_uid' =>$sql_uid,
				'user_uid_temp'=>$sess['user_uid'],
				'query'=>$search_query,
				'sql_where'=>$sample,
				'sql_query'=>$sql,
				'date_time'=>$sql_datetime,
				'total_result'=>$count
			);
			$this->CM->insertData('tb_temp_sql',$sql_temp_data);


			$sql_log_data = array(
				'unique_id'=>uniqid(),
				'query_id' =>$sql_uid,
				'user_id'=>$sess['user_uid'],
				'user_name'=>$user_name,
				'query'=>$search_query,
				'sql_query'=>$sql,
				'datetime_created'=>$sql_datetime,
				'total_result'=>$count
			);
			$this->CM->insertData('tb_activity_log_query',$sql_log_data);
			$data['search_query'] = $search_query;
			$data['journal_data'] = $journal_data;
		}
		else
		{
			echo 'NO FILTER';
		}
		
	}
	public function journalRecords()
	{
		$data['journal_data'] = $this->CM->getData('tb_journal');		
		$this->load->view('journal_records',$data);
	}

	public function import()
	{
		$data['users'] = $this->CM->getData('tb_users');		
		$this->load->view('import',$data);				
	}	
	
    public function update_password($userid)
    {
    	if($this->input->post('newpassword'))
    	{
    		$user_password = $this->input->post('newpassword');
    		$inserArray = array(
			 	'user_password'=>$user_password,
			 	'user_encrypted'=>md5($user_password)
		 	);
		 	$where_array = array('user_uid'=>$userid);
		 	$this->CM->updateData('tb_users',$inserArray,$where_array);
		 }
    	$this->load->view('users_profile');
    }

    public function queryLog()
    {
    	$query_activity_log = $this->CM->getData('tb_activity_log_query','','datetime_created','DESC');
    	$data['query_activity_log'] = $query_activity_log;
    	$this->load->view('query_log',$data);
    }
    
}
