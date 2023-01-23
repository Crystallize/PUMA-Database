<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	

	function __construct()
    {
        parent::__construct();
        $this->load->database();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
		// $this->load->library('encrypt');
		$this->load->model('Common_model','CM');
		if($this->session->userdata('login_data')=='')
		{
			redirect('login');
		}
    }

	public function index()
	{
		$complete_journal_data = $this->CM->getData('tb_journal');
		//$data['journal_data_complete'] = $journal_data;
		$data['filter_option'] = "";
		$data['filter_value'] = "";
		if($this->input->post('query_box'))
		{
			$filter_option = $this->input->post('filter_option');			
			$filter_value = $this->input->post('filter_value');
			
			$data['filter_option'] = $filter_option;
			$data['filter_value'] = $filter_value;
			echo $query_box = $this->input->post('query_box');
			echo '<br>';
		
			function countLetters($matches) 
			{
				$match1 = str_replace(')', "%')", $matches[0]);
			  	return $match1;
			}
			$pattern = '/\(?.<?\)/i';

			if(strpos($query_box,'AND') || strpos($query_box,'OR') )
			{
				//echo 'AND';
				$query_box = preg_replace_callback('/\b([^]]+)\b/', function ($word) {
				      return strtolower($word[1]);
				 }, $query_box);
				$query_box = str_replace('[', ' `', $query_box);
				$query_box = str_replace("]", "` like '%", $query_box);
				
				$where = preg_replace_callback($pattern, 'countLetters', $query_box);
				echo $sql = "SELECT * FROM `tb_journal` WHERE ".$where;
				die;
				$result = $this->db->query($sql);
				$journal_data = $result->result();
			}
			elseif(strpos($query_box,'NOT'))
			{
				//echo 'NOT';
				$query_box = preg_replace_callback('/\b([^]]+)\b/', function ($word) {
				      return strtolower($word[1]);
				 }, $query_box);
				$query_box = str_replace('not', ' not & ', $query_box);
				$not_array = explode('not', $query_box);
				for($i=0;$i<sizeof($not_array);$i++)
				{
					$text = $not_array[$i];
					echo '<br>';
					$where_not = "";
					if(strpos($text, '&') !== false){
					    $text = str_replace('[', ' `', $text);
						$text = str_replace("]", "` NOT like '%", $text);						
						$where_not = preg_replace_callback($pattern, 'countLetters', $text);
					}
					else
					{
						$text = str_replace('[', ' `', $text);
						$text = str_replace("]", "` like '%", $text);						
						$where_not = preg_replace_callback($pattern, 'countLetters', $text);
					}
					$not_array_new[] = $where_not;					
				}
				$not_array_new = implode(" ",$not_array_new);
				
				$where = str_replace('&', ' AND ', $not_array_new);
				echo $sql = "SELECT * FROM `tb_journal` WHERE ".$where;die;
				$result = $this->db->query($sql);
				$journal_data = $result->result();
			}
			else
			{
				//echo 'EMPTY FILTER';
				$filter_option = strtolower($filter_option);
				$filter_option = str_replace(array( ' ', '/' ), '_', $filter_option);
				echo $sql = "SELECT * FROM `tb_journal` WHERE `$filter_option` LIKE '%$filter_value%' ";die;
				$query = $this->db->query($sql);
				$result = $this->db->query($sql);
				$journal_data = $result->result();
			}
			//$journal_data = $this->CM->getJournalData($filter_option,$filter_value);
			$filtered_count = $journal_data;
			$data['filtered_count'] = count($filtered_count);
			$data['journal_data_count'] = count($complete_journal_data);
			$data['journal_data'] = $filtered_count;
		}
		else
		{
			//echo 'NO FILTER';
			$filtered_count = array();
			$data['filtered_count'] = count($filtered_count);
			$data['journal_data_count'] = count($complete_journal_data);
			$data['journal_data'] = $complete_journal_data;
		}
			
		$this->load->view('journal_records',$data);
	}

	
	// public function dashboard()
	// {
	// 	$journal_data = $this->CM->getData('tb_journal');
	// 	$data['journal_data_complete'] = $journal_data;
	// 	$data['filter_option'] = "";
	// 	$data['filter_value'] = "";
	// 	if($this->input->post('filter_option'))
	// 	{
	// 		$filter_option = $this->input->post('filter_option');			
	// 		$filter_value = $this->input->post('filter_value');
			
	// 		$data['filter_option'] = $filter_option;
	// 		$data['filter_value'] = $filter_value;
			
	// 		$journal_data = $this->CM->getJournalData($filter_option,$filter_value);
	// 		$filtered_count = $journal_data;
	// 		//die;
	// 	}
	// 	else
	// 	{
	// 		$filtered_count = array();
	// 	}
	// 	$data['filtered_count'] = $filtered_count;
	// 	$data['journal_data'] = $journal_data;	
	// 	$this->load->view('journal_records',$data);
	// }

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
	public function importFile(){
  
      	if ($this->input->post('submit')) 
      	{
              
           	$config['upload_path'] = 'assets/uploads/'; 
	         $config['allowed_types'] = 'csv'; 
	         $config['max_size'] = '1000'; // max_size in kb 
	         $config['file_name'] = $_FILES['uploadFile']['name'];

	         // Load upload library 
	         $this->load->library('upload',$config); 
	 
	         // File upload
	         $column = array('');
	         echo 'test2222';  
	        if($this->upload->do_upload('uploadFile'))
	        { 
	        	echo 'test';  
	            // Get data about the file
	            $uploadData = $this->upload->data(); 
	            // print_r($uploadData);
	            $filename = $uploadData['file_name'];

	            // Reading file
	            $file = fopen("assets/uploads/".$filename,"r");
	            $i = 0;
	            $numberOfFields = 43; // Total number of fields
	           echo 'test1';die;
	            while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) 
	            {
	            	$main_array = array();
	               $num = count($filedata );
	               if($i>0)
	               {
	               		$main_array['unique_id'] = $filedata[0];
	               		$main_array['topic'] = $filedata[1];
	               		$main_array['in_pubmed'] = $filedata[2];
	               		$main_array['nlm_id'] = $filedata[3];
	               		$main_array['journal'] = $filedata[4];
	               		$main_array['counts'] = $filedata[5];
	               		$main_array['start_year'] = $filedata[6];
	               		$main_array['end_year'] = $filedata[7];
	               		$main_array['pubmed_journal_status'] = $filedata[29];
	               		$main_array['pubmed_start_year'] = $filedata[30];
	               		$main_array['pubmed_end_year'] = $filedata[31];
	               		$main_array['medline_journal_status'] = $filedata[32];
	               		$main_array['medline_start_year'] = $filedata[33];
	               		$main_array['medline_end_year'] = $filedata[34];
	               		$main_array['url_cnki'] = $filedata[8];
	               		$main_array['url_caod'] = $filedata[9];
	               		$main_array['caod_coverage_start_year'] = $filedata[10];
	               		$main_array['caod_coverage_end_year'] = $filedata[11];
	               		$main_array['url'] = $filedata[12];
	               		$main_array['archive_coverage_start_year'] = $filedata[27];
	               		$main_array['archive_coverage_end_year'] = $filedata[28];
	               		$main_array['content'] = $filedata[13];
	               		$main_array['login'] = $filedata[14];

	               		$main_array['free_pay'] = $filedata[15];
	               		$main_array['language'] = $filedata[16];
	               		$main_array['notes'] = $filedata[17];
	               		$main_array['print_issn_nlm'] = $filedata[18];
	               		$main_array['electronic_issn_nlm'] = $filedata[19];
	               		$main_array['linking_issn_nlm'] = $filedata[20];
	               		$main_array['mesh'] = $filedata[21];
	               		$main_array['indexed_nlm'] = $filedata[22];
	               		$main_array['indexed_embase'] = $filedata[23];
	               		$main_array['indexed_embase_nlm'] = $filedata[24];
	               		$main_array['not_indexed_nlm_and_embase'] = $filedata[25];
	               		$main_array['indexed_nlm_not_in_embase'] = $filedata[26];
	               		$main_array['pmc_journal_status'] = $filedata[35];
	               		$main_array['pmc_start_year'] = $filedata[36];
	               		$main_array['pmc_end_year'] = $filedata[37];
	               		$main_array['pmc_free_access'] = $filedata[38];
	               		$main_array['pmc_journal_URL'] = $filedata[39];
	               		$this->CM->insertData('tb_journal',$main_array);
		                $importData_arr[$i] = $main_array;
		            }
		            // $importData_arr[] = $main_array;
	               $i++;
	            }
	            echo '<pre>';
	            print_r($importData_arr);
	              
	        }
	        die;  
    	}
        $this->load->view('import');
    }

    public function autoSearch()
    {
    	$searchVal = $this->input->post('searchVal');
    	//$sql = "SELECT * FROM `tb_journal` WHERE topic + language + in_pubmed  LIKE '%".$searchVal."%';";
    	$sql = "SELECT * FROM `tb_journal` WHERE 
    									`topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR `topic` LIKE '%".$searchVal."%' 
    									OR ";
    	echo $sql;
    	

    }
    
}
