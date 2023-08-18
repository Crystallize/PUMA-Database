<?php
ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');
class QueryTest extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Common_model', 'CM', TRUE);
		$sess = $this->session->userdata('admin_type');
	}
	public function index()
	{
		$data['title'] = 'home';
		$this->load->view('forms-layouts',$data);
	}
	
	// Function to break nested brackets and create individual queries
	public function processBrackets($query, $tablename) {
	    $matches = array();
	    preg_match('/\(([^()]*)\)/', $query, $matches); // Find the first set of brackets

	    if (count($matches) > 0) {
	        $subQuery = $matches[1]; // Extract the content inside the brackets
	        $subQuery = $this->processBrackets($subQuery, $tablename); // Recursively process the subquery inside the brackets

	        // Replace the subquery inside the brackets with a placeholder
	        $query = str_replace('(' . $subQuery . ')', '#placeholder#', $query);

	        // Process the subquery outside the brackets
	        $query = $this->processQuery($query, $tablename);

	        // Replace the placeholder with the processed subquery inside the brackets
	        $query = str_replace('#placeholder#', $subQuery, $query);
	    } else {
	        // Process the query without brackets
	        $query = $this->processQuery($query, $tablename);
	    }

	    return $query;
	}

	public function processQuery($query, $tablename) {
	    // Here, you can perform any necessary processing on the individual queries
	    // For example, you can execute the query, store the results, etc.

	    // Replace 'table_name' placeholder with the actual table name
	    $query = str_replace('table_name', $tablename, $query);

	    // Output the processed query
	    echo $query . "<br>";

	    return $query;
	}

	public function demo()
	{
		// Example usage
		// echo $query = '(([col1] match keyword1 NOT ([col2] match keyword2 NOT [col3] match keyword3) AND (([col1] match keyword4 or [col1] match keyword5) AND ([col4]>keyword6))';
		// echo '<br>';
		// $tablename = 'tb_journal';
		$all_numbers1 = array();
		$all_numbers2 = array();
		// $processedQuery = $this->processBrackets($query, $tablename);
		$sql1 = "SELECT * FROM `tb_journal` WHERE  ((`pubmed_start_year`>2000 AND `pubmed_start_year`!=2005) OR (`journal` like '%paediatric%' or `journal` like '%pediatric%') )";
		//$query = $this->db->query($sql1);
		$result1 = $this->db->query($sql1);
		$journal_data1 = $result1->result();
		 foreach ($journal_data1 as $word) {
				      $all_numbers1[] = $word->id;
				   }


		$sql2 = "SELECT * FROM `tb_journal` WHERE (((`counts`>10 or `counts`<2) and ((`language`='english' or `language`='spanish') or (`mesh` like '%diabetes%' or `mesh` like '%cancer%' or `mesh` like '%dementia%'))) )";
		$result2 = $this->db->query($sql2);
		$journal_data2 = $result2->result();
		foreach ($journal_data2 as $word) {
				      $all_numbers2[] = $word->id;
				   }

		$sql3 = "SELECT * FROM `tb_journal` WHERE (((`counts`>10 or `counts`<2) and ((`language`='english' or `language`='spanish') or (`mesh` like '%diabetes%' or `mesh` like '%cancer%' or `mesh` like '%dementia%'))) AND NOT ((`pubmed_start_year`>2000 AND `pubmed_start_year`!=2005) OR (`journal` like '%paediatric%' or `journal` like '%pediatric%') ))  ORDER BY `tb_journal`.`id` ASC";
		//$query = $this->db->query($sql1);
		$result3 = $this->db->query($sql3);
		$journal_data3 = $result3->result();
		 foreach ($journal_data3 as $word) {
				      $all_numbers3[] = $word->id;
				   }

				   echo '<pre>';
				   print_r($all_numbers1);
				   print_r($all_numbers2);
				   print_r($all_numbers3);
	}

	public function testQuery()
	{
		$sample1 = "[Language]MATCH English";// equal query
		$sample2 = "[Language]Contains English"; // like query
		$sample3 = "[Language] English"; // like query not working
		$sample4 = "[counts]>10";
		$sample5 = "[counts]=10";
		$sample6 = "[Language]Match English AND [MESH]MATCH Diabetes";
		$sample7 = "[archive_coverage_start_year]=NULL"; 
		#earlier example

		#latest examples
		$sample8 = "([language]MATCH English OR [language]MATCH spanish)"; //1 worked
		$sample9 = "[MeSH]CONTAINS Diabetes OR [MeSH]CONTAINS Cancer OR [MeSH]CONTAINS dementia";//2 worked
		$sample10 = "[counts]>10 OR [counts]<2";//3 worked
		//sample11 = sample8 or sample 9 //4 = 1 or 2 worked
		$sample11 = "([language]MATCH English OR [language]MATCH spanish) OR ([MeSH]CONTAINS Diabetes OR [MeSH]CONTAINS Cancer OR [MeSH]CONTAINS dementia)";//4 (([col1]MATCH keyword1 OR [col1]MATCH keyword2) OR ([col2]CONTAINS keyword3 OR [col2]CONTAINS keyword4 OR [col2]CONTAINS keyword5))
		//sample12 = sample10 and sample 11 // 5 = 3 and 4 worked
		$sample12 = "([counts]>10 OR [counts]<2) and (".$sample11.")"; //5 worked
		$sample12query = "(`counts`>10 or `counts`<2) and ((`language`='english' or `language`='spanish') or (`mesh` like  '%diabetes%' or `mesh` like  '%cancer%' or `mesh` like  '%dementia%'))";
		$sample13 = "[Pubmed Start Year]>2000 NOT [Pubmed Start Year]=2005"; //6 worked
		$sample13query = "`pubmed_start_year`>2000  AND `pubmed_start_year`!=2005"; 
		$sample14 = "[Journal]CONTAINS paediatric OR [Journal]CONTAINS pediatric"; //7 worked
		$sample14Query = "`journal` like  '%paediatric%' or `journal` like  '%pediatric%'";
		$sample15 = "(".$sample12query.") NOT ((".$sample13query.") OR (".$sample14Query.") )"; 
		$sample15 = "(".$sample15.")";
		//sample15 =   //  #5 NOT (#6 OR #7) 
		//echo $sample15.'<br>';
		$sample16 = "([MeSH]CONTAINS Diabetes OR [MeSH]CONTAINS Cancer OR [MeSH]CONTAINS dementia) OR ([language]MATCH English OR [language]MATCH spanish)";//2 or 1
		$sample17 = "[Mesh]match diabetes NOT ([language]match English NOT [language]match spanish)";
		#sample17 = "(([col1] match keyword1 NOT ([col2] match keyword2 NOT [col3] match keyword3) AND (([col1] match keyword4 or [col1] match keyword5) AND ([col4]>keyword6))"
		$sample = strtolower($sample13);
		echo $sample;
		echo '<br><pre>';
		//die;
		//$text = '[in pubmed]no';
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
			//}
			if(str_contains($sample,'and') )
			{
				$between_op = ' and ';
			}
			if(str_contains($sample,'or') )
			{
				$between_op = ' or ';
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
			$search_query = "";
			$sql_join_query_ids=implode(",",$array_query);
			for($i=0;$i<sizeof($array_query);$i++)
			{
				$sql_uid = $array_query[$i];
				$resultRow = $this->CM->getRowData('tb_temp_sql',array('sql_uid'=>$sql_uid));
				if($combined_where)
				{
					$combined_where = $combined_where.$between_op.'('.$resultRow->sql_where.')';
					$search_query = $search_query.$between_op.' #'.$array_id[$i];
				}
				else
				{
					$combined_where = '('.$resultRow->sql_where.')';
					$search_query = '#'.$array_id[$i];
				}	
			}
			// print_r($combined_where);
			// print_r($search_query);
			$sample = $combined_where;
		}
		else
		{	
			// if(strpos($sample,'not') )
			// {
			// 	// Find all occurrences of "not"
			// 	$pos = strpos($sample, "not");

			// 	// Remove space after "not"
			// 	while ($pos !== false) {
			// 	    if (isset($sample[$pos+3]) && $sample[$pos+3] === " ") {
			// 	        $sample = substr_replace($sample, "_", $pos+3, 1);
			// 	    }
			// 	    $pos = strpos($sample, "not", $pos+1);
			// 	}

			// 	$bits = explode(' ', $sample);
			// 	$newquery = array();
			// 	foreach($bits as $bit)
			// 	{
			// 		if(!strpos($bit,"contains") && !strpos($bit,"[") && !strpos($bit,"]")) 
			//     	{
			//     		if($bit=='not')
			//     		{
			//     			$newquery[] = $bit;	
			//     		}
			//     		else
			//     		{
			//     			$newquery[] = "!='".trim($bit)."'";
			//     		}	
			//     	}
			//     	else
			//     	{
			//     		if(str_starts_with($bit,"not"))
			//     		{
			//     			$string = $bit;

			// 				// Find the position of the underscore character
			// 				$pos = strpos($string, "_");

			// 				// Extract the substring starting from the underscore character
			// 				if ($pos !== false) {
			// 				    $substring = substr($string, $pos);
			// 				}

			// 				$newquery[] = str_replace('=', "!=", $substring);
			//     			//$newquery[] = "and ".trim($bit)."'";
			//     		}
			//     		else
			//     		{
			//     			$newquery[] = $bit;
			//     		}
			//     	}
			// 	}
			
			// 	$newquery = implode(' ', $newquery);
			// 	$newquery = str_replace('[', "`", $newquery);
			// 	$newquery = str_replace(']not', "`", $newquery);
			// 	$newquery = str_replace('] not', "`", $newquery);
			// 	$newquery = str_replace('_`', " AND `", $newquery);
			// }
			
			if(!empty($newquery))
			{
				$sample = $newquery;
				$newquery = '';
			}
			if(strpos($sample,'match'))
			{
				$bits = explode(' ', $sample);
				foreach($bits as $bit)
				{
					if(!strpos($bit,"match") && !strpos($bit,"[") && !strpos($bit,"]") ) 
			    	{
			    		if($bit=='and'||$bit=='or')
			    		{
			    			$newquery[] = trim($bit);	
			    		}
			    		else
			    		{
			    			$newquery[] = "'".trim($bit)."'";
			    		}
			    	}
			    	else
			    	{
			    		$newquery[] = trim($bit);
			    	}
				}
				$newquery = implode(' ', $newquery);
				$newquery = str_replace('[', "`", $newquery);
				$newquery = str_replace(']match', "`=", $newquery);
				$newquery = str_replace('] match', "`=", $newquery);
				//new code
				$newquery = str_replace(")'", "')", $newquery);
			}
			$newquery = str_replace("= '", "='", $newquery);
			
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
					$bit = str_replace(")')", "'))", $bit);
					if(!strpos($bit,"contains") && !strpos($bit,"[") && !strpos($bit,"]")) 
			    	{
			    		if($bit=='and'||$bit=='or' || $bit =='('||$bit ==')'||$bit =='=' )
			    		{
			    			$newquery[] = $bit;	
			    		}
			    		else
			    		{
			    			if(str_starts_with($bit,"(`") || str_ends_with($bit,"`)") ||(str_contains($bit,"='") ))
			    			{
			    				$newquery[] = $bit;
			    			}
							else
							{
								$bit = str_replace("'", "", $bit);
								$newquery[] = "'%".trim($bit)."%'";
							}
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
				$bracket_count = substr_count($newquery,')');
				//echo $bracket_count;
				for($a=0;$a<$bracket_count;$a++)
				{
					$newquery = str_replace(")%'", "%')", $newquery);
				}
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
				echo 'test';
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
			    			echo $bit;
			    			$bit_arr = explode(']', $bit);

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
				// $newquery = str_replace('[', "`", $newquery);
				// $newquery = str_replace(']', "` like ", $newquery);
				// $newquery = str_replace('] ', "`  like ", $newquery);
				//echo $newquery;
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
		echo $sample;
	}
	public function testQuery_bk()
	{
		$sample1 = "[Language]MATCH English";// equal query
		$sample2 = "[Language]Contains English"; // like query
		$sample3 = "[Language] English"; // like query
		$sample4 = "[counts]>10";
		$sample5 = "[counts]=10";
		$sample6 = "[Language]Match English AND [MESH]MATCH Diabetes";
		$sample7 = "[archive_coverage_start_year]=NULL"; 
		#earlier example

		#latest examples
		$sample8 = "([language]MATCH English OR [language]MATCH spanish)"; //1 worked
		$sample9 = "[MeSH]CONTAINS Diabetes OR [MeSH]CONTAINS Cancer OR [MeSH]CONTAINS dementia";//2 worked
		$sample10 = "[counts]>10 OR [counts]<2";//3
		//sample11 = sample8 or sample 9 //4 = 1 or 2
		$sample11 = "([language]MATCH English OR [language]MATCH spanish) OR ([MeSH]CONTAINS Diabetes OR [MeSH]CONTAINS Cancer OR [MeSH]CONTAINS dementia)";//4
		//sample12 = sample10 and sample 11 // 5 = 3 and 4
		$sample12 = "([counts]>10 OR [counts]<2) and (".$sample11.")"; //5
		$sample13 = "[Pubmed Start Year]>2000 NOT [Pubmed Start Year]=2005"; //6
		$sample14 = "[Journal]CONTAINS paediatric OR [Journal]CONTAINS pediatric"; //7
		$sample15 = "(".$sample12.") NOT ((".$sample13.") OR (".$sample14.") )";
		//sample15 = sample13
		$sample16 = "([MeSH]CONTAINS Diabetes OR [MeSH]CONTAINS Cancer OR [MeSH]CONTAINS dementia) OR ([language]MATCH English OR [language]MATCH spanish)";//2 or 1
		$sample = $sample12;
		echo $sample = strtolower($sample);
		
    	$newquery = array();
		
		if(strpos($sample,'match'))
		{
			$bits = explode(' ', $sample);
			// echo '<pre>';
			// print_r($bits);
			foreach($bits as $bit)
			{
				if(!strpos($bit,"match") && !strpos($bit,"[") && !strpos($bit,"]") ) 
		    	{
		    		if($bit=='and'||$bit=='or')
		    		{
		    			$newquery[] = trim($bit);	
		    		}
		    		else
		    		{
		    			$newquery[] = "'".trim($bit)."'";
		    		}
		    	}
		    	else
		    	{
		    		$newquery[] = trim($bit);
		    	}
			}
			$newquery = implode(' ', $newquery);
			$newquery = str_replace('[', "`", $newquery);
			$newquery = str_replace(']match', "`=", $newquery);
			$newquery = str_replace('] match', "`=", $newquery);
			//new code
			$newquery = str_replace(")'", "')", $newquery);
		}
		$newquery = str_replace("= '", "='", $newquery);
		echo '<br>';
		echo $newquery;
		echo '<br>';
		if(!empty($newquery))
		{
			$sample = $newquery;
			$newquery = '';
		}
		if(strpos($sample,'contains') )
		{
			$bits = explode(' ', $sample);
			echo '<pre>';
			print_r($bits);
			$newquery = array();
			foreach($bits as $bit)
			{
				if(!strpos($bit,"contains") && !strpos($bit,"[") && !strpos($bit,"]")) 
		    	{
		    		if($bit=='and'||$bit=='or' || $bit =='('||$bit ==')'||$bit =='=' )
		    		{
		    			$newquery[] = $bit;	
		    		}
		    		else
		    		{
		    			if(str_starts_with($bit,"(`") || str_ends_with($bit,"`)") ||(str_contains($bit,"='") ))
		    			{
		    				$newquery[] = $bit;
		    			}
						else
						{
							$bit = str_replace("'", "", $bit);
							$newquery[] = "'%".trim($bit)."%'";
						}
		    			
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
			$newquery = str_replace(")%'", "%')", $newquery);
		}
		echo '<br>';
		echo $newquery;
		echo '<br>';
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
		if(!strpos($sample,'Contains') && !strpos($sample,'MATCH') && strpos($sample,'>') && strpos($sample,'<') && strpos($sample,'=') )
		{
			$bits = explode(' ', $sample);
			$newquery = array();
			foreach($bits as $bit)
			{
				if(!strpos($bit,"[") && !strpos($bit,"]")) 
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
			$newquery = str_replace(']', "` like ", $newquery);
			$newquery = str_replace('] ', "`  like ", $newquery);
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
		echo '<br>'.$sample;
		die;
	}
	public function startsWith($string, $startString)
	{
	    $len = strlen($startString);
	    return (substr($string, 0, $len) === $startString);
	}
	public function adminAuth()
	{
		//echo $this->encryption->encrypt('1234');

		if ($this->input->post())
		{
			$this->form_validation->set_rules('admin_email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('admin_password', 'Password', 'required');
			if ($this->form_validation->run() == TRUE)
				{
					
				$post = $this->input->post();
				$clean = $this->security->xss_clean($post);
				$check = $this->CM->userAuthentication($clean);
				if ($check != 'success')
				{
					$this->session->set_flashdata('msg', array(
						'message' => "$check",
						'class' => 'alert alert-warning'
					));
					redirect('signIn');
				}
				else
				{
					if ($this->session->userdata('admin_type') == 'master')
					{
						echo '1';
						die;
						redirect('dashboard');
					}
					elseif ($this->session->userdata('admin_type') == 'admin')
					{
						echo '2';
						die;
						redirect('admin/dashboard');
					}
				}
			}
		    else
			{
				$this->load->view('sign-in');
			}
		}
		else
		{
			$this->load->view('sign-in');
		}				
	}


	
}