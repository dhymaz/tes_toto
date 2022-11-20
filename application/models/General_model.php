<?php defined('BASEPATH') OR exit('No direct script access allowed');
class General_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
	
	function execQuery($qstr)
	{
		$query = $this->db->query($qstr);
		return $query;
	}
	
	function execQueryWithConnection($conn='default',$qstr)
	{
		$database = $this->load->database($conn,true);
		$query = $database->query($qstr);
		$database->close();
		return $query;
	}
	
	function insertData($table,$data)
	{
		try{
			$query = $this->db->insert($table,$data);
			if(!$query){
				throw new Exception();
			}
			return true;
		}catch(Exception $e) {
			return false;
		}
	}
	
	function insertDataWithConnection($conn='default',$table,$data)
	{
		try{
			$database = $this->load->database($conn,true);
			$query = $database->insert($table,$data);
			$database->close();
			if(!$query){
				throw new Exception();
			}
			return true;
		}catch(Exception $e) {
			return false;
		}
	}
	
	function updateData($table,$data,$where)
	{
		try{
			$query = $this->db->update($table,$data,$where);
			if(!$query){
				throw new Exception();
			}
			return true;
		}catch(Exception $e) {
			return false;
		}
	}
	
	function updateDataWithConnection($conn='default',$table,$data,$where)
	{
		try{
			$database = $this->load->database($conn,true);
			$query = $database->update($table,$data,$where);
			$database->close();
			if(!$query){
				throw new Exception();
			}
			return true;
		}catch(Exception $e) {
			return false;
		}
	}
	
	function deleteData($table,$data)
	{
		try{
			$query = $this->db->delete($table,$data);
			if(!$query){
				throw new Exception();
			}
			return true;
		}catch(Exception $e) {
			return false;
		}
	}
	
	function deleteDataWithConnection($conn='default',$table,$data)
	{
		try{
			$database = $this->load->database($conn,true);
			$query = $database->delete($table,$data);
			$database->close();
			if(!$query){
				throw new Exception();
			}
			return true;
		}catch(Exception $e) {
			return false;
		}
	}
	
	function mysqlGetData($count=false,$table='',$mainQuery='',$param='',$order='',$start='',$limits='')
	{
		try {
			$mainQuery = trim($mainQuery);
			$order = trim($order);
			$start = trim($start);
			$limits= trim($limits);
			$where = '';
			if($param!=''){
				if(is_array($param)){
					foreach($param as $value){
						if(trim($where)!=''){
							$where .= isset($value['operator'])?" {$value['operator']} ":'';
						}
						$field = isset($value['field'])?$value['field']:'';
						$fieldOperator = isset($value['field_operator'])?' '.$value['field_operator'].' ':'';
						if(isset($value['value'])){
							if(is_array($value['value'])){
								$arrTemp = array();
								foreach($value['value'] as $idx=>$item){
									if($value['escape_type']==1){
										$arrTemp[$idx] = $this->db->escape($item);
									}else{
										$arrTemp[$idx] = $this->db->escape_str($item);
									}
								}
								$fieldValue = "(".implode(",",$arrTemp).")";
							}else{
								if($value['escape_type']==1){
									$fieldValue = $this->db->escape($value['value']);
								}else{
									$fieldValue = $this->db->escape_str($value['value']);
								}
							}
						}else{
							$fieldValue = '';
						}
						$prefix = isset($value['prefix'])?$value['prefix']:'';
						$sufix = isset($value['sufix'])?$value['sufix']:'';
						$where .= $field.$fieldOperator.$prefix.$fieldValue.$sufix;
					}
				}else{
					$where = trim($param);
				}
			}
			$where = trim($where);
			$where = ($where!='')?" WHERE ".$where:"";
			if($count){
				if($mainQuery!=''){
					$qstr	= $mainQuery;
				}else{
					$qstr	= "SELECT count(*) as jumlah_row FROM {$table}";
				}
				$qstr	= $qstr.$where;
				$query 	= $this->db->query($qstr);
				if(!$query){
					throw new Exception();
				}
				if($query->num_rows()>0){
					return $query->row()->jumlah_row;
				}else{
					return 0;
				}
			}else{
				$clauseLimit = '';
				if($start!=='' && $limits!==''){
					$clauseLimit = " LIMIT {$start},{$limits}";
				}
				$order = $order!=''?" ORDER BY ".$order:'';
				if($mainQuery!=''){
					$qstr	= $mainQuery;
				}else{
					$qstr	= "SELECT * FROM {$table}";
				}
				$qstr	= $qstr.$where.$order.$clauseLimit;
				$query 	= $this->db->query($qstr);
				if(!$query){
					throw new Exception();
				}
				return $query->result();
			}
		}catch(Exception $e){
			return $count?0:array();
		}
	}
	
	function mysqlGetDataWithConnection($count=false,$conn='default',$table='',$mainQuery='',$param='',$order='',$start='',$limits='')
	{
		try {
			$database = $this->load->database($conn,true);
			$mainQuery = trim($mainQuery);
			$order = trim($order);
			$start = trim($start);
			$limits= trim($limits);
			$where = '';
			if($param!=''){
				if(is_array($param)){
					foreach($param as $value){
						if(trim($where)!=''){
							$where .= isset($value['operator'])?" {$value['operator']} ":'';
						}
						$field = isset($value['field'])?$value['field']:'';
						$fieldOperator = isset($value['field_operator'])?' '.$value['field_operator'].' ':'';
						if(isset($value['value'])){
							if(is_array($value['value'])){
								$arrTemp = array();
								foreach($value['value'] as $item){
									if($value['escape_type']==1){
										$arrTemp[] = $database->escape($item);
									}else{
										$arrTemp[] = $database->escape_str($item);
									}
								}
								$fieldValue = "(".implode(',',$arrTemp).")";
							}else{
								if($value['escape_type']==1){
									$fieldValue = $database->escape($value['value']);
								}else{
									$fieldValue = $database->escape_str($value['value']);
								}
							}
						}else{
							$fieldValue = '';
						}
						$prefix = isset($value['prefix'])?$value['prefix']:'';
						$sufix = isset($value['sufix'])?$value['sufix']:'';
						$where .= $field.$fieldOperator.$prefix.$fieldValue.$sufix;
					}
				}else{
					$where = trim($param);
				}
			}
			$where = trim($where);
			$where = ($where!='')?" WHERE ".$where:"";
			if($count){
				if($mainQuery!=''){
					$qstr	= $mainQuery;
				}else{
					$qstr	= "SELECT count(*) as jumlah_row FROM {$table}";
				}
				$qstr	= $qstr.$where;
				$query 	= $database->query($qstr);
				if(!$query){
					$database->close();
					throw new Exception();
				}
				if($query->num_rows()>0){
					$return = $query->row()->jumlah_row;
					$database->close();
					return $return;
				}else{
					return 0;
				}
			}else{
				$clauseLimit = '';
				if($start!=='' && $limits!==''){
					$clauseLimit = " LIMIT {$start},{$limits}";
				}
				$order = $order!=''?" ORDER BY ".$order:'';
				if($mainQuery!=''){
					$qstr	= $mainQuery;
				}else{
					$qstr	= "SELECT * FROM {$table}";
				}
				$qstr	= $qstr.$where.$order.$clauseLimit;
				$query 	= $database->query($qstr);
				if(!$query){
					$database->close();
					throw new Exception();
				}
				$return = $query->result();
				$database->close();
				return $return;
			}
		}catch(Exception $e){
			return $count?0:array();
		}
	}
	
	function truncateTable($table)
	{
		try {
			$query 	= $this->db->truncate($table);
			if(!$query){
				throw new Exception();
			}
			return true;
		}catch(Exception $e){
			return false;
		}
	}
	
	function utilTable($table)
	{
		try {
			$this->load->dbutil();
			$query 	= $this->dbutil->repair_table($table);
			if(!$query){
				throw new Exception();
			}
			$query2 	= $this->dbutil->optimize_table($table);
			if(!$query2){
				throw new Exception();
			}
			return true;
		}catch(Exception $e){
			return false;
		}
	}

	function insertUpdate($table, $data, $wheres)
	{
		try {
			$this->db->where($wheres);
			$check = $this->db->get($table);

			if ($check->num_rows() > 0) {
				$query = $this->db->update($table, $data, $wheres);
			} else {
				$query = $this->db->insert($table, $data);
			}

			if (!$query) {
				throw new Exception();
			}
			return true;
		} catch (Exception $e) {
			return false;
		}
	}
	
	/* =================== General Model VERSION 2 =========================== */
	function insert_data_table($table, $data){
		return $this->db->insert($table, $data);
	}

	function insert_data_table_batch($table, $datas){
		$this->db->insert_batch($table, $datas);
		return $this->db->affected_rows();
	}
	
	function insert_debug_off($table, $data){
		$this->db->db_debug = false;
		$insert = $this->db->insert($table, $data);
	    if ($insert > 0) $return = TRUE;
	    else $return = FALSE;
		return $return;
	}

	function insert_batch_debug_off($table, $datas){
		$this->db->db_debug = false;
		$insert = $this->db->insert_batch($table, $datas);
	    if ($insert > 0) $return = TRUE;
	    else $return = FALSE;
		return $return;
	}	
	
	function get_data_unique($field='', $table, $arr_where){
		if($field <> '')
			$this->db->select($field);

		$this->db->where($arr_where);
		$result = $this->db->get($table);
		
		if($result->num_rows() < 1){
			return 0;
		}  else {
			return $result->row();
		}
	}

	function get_data_table($table, $arr_where){
		$this->db->where($arr_where);
		$result = $this->db->get($table);

		if($result->num_rows() < 1){
			return 0;
		}  else {
			return $result->row();
		}
	}
	
	function update_data_table($table_name, $data_upd, $wheres){
		$this->db->where($wheres);
		$this->db->update($table_name, $data_upd);
		$result = $this->db->affected_rows();
		return $result;
	}
	
	function checking_data_table($table, $arr_where){
		$this->db->where($arr_where);
		$result = $this->db->get($table);
	
		if($result->num_rows() < 1){
			return 1;
		}  else {
			return 0;
		}
	}
	
	function get_data_table_no_paging($tables, $wheres="", $isOrder = 0, $order_by = ""){
		if ($wheres != '') {
			$this->db->where($wheres);
		}
		
		if($isOrder){
			$this->db->order_by($order_by); 
		}
		
		$return = $this->db->get($tables);
		
		return $return;
	}

	function get_distinct_data($table, $select, $where=""){
		$this->db->distinct();
		$this->db->select($select);
		$this->db->where($where); 
		$query = $this->db->get($table);
		return $query;
	}
	
	function get_count_table($tables, $wheres=""){
		if ($wheres != '') {
			$this->db->where($wheres);
		}
		
		$this->db->from($tables);
		$return = $this->db->count_all_results();
		return $return;
	}
	
	function get_data_table_with_paging($tables, $wheres, $limit, $rowpos, $isOrder = 0, $order_by = ""){
		$this->db->where($wheres);
		if($isOrder){
			$this->db->order_by($order_by); 
		}
		$this->db->limit($limit,$rowpos);
		$return = $this->db->get($tables);
		return $return;
	}
	
	function delete_data_table($tables, $wheres){
		$this->db->where($wheres);
		$return = $this->db->delete($tables);
		return $return;
	}

	function delete_insert_batch_data_table($tables, $datas, $wheres){
		$this->db->where($wheres);
		$this->db->delete($tables);
		
		$this->db->insert_batch($tables, $datas);
		return $this->db->affected_rows();

	}

	function drop_indexs($tables, $keys)
	{
		$query_str = "ALTER TABLE {$tables} ";
		foreach ($keys as $key => $key_name) {
			$query_str .= "DROP INDEX {$key_name}, ";
		}
		$query_str = rtrim($query_str, ', ');
		return $this->db->query($query_str);
	}

	function reindexing($tables, $indexs)
	{
		$query_str = "ALTER TABLE {$tables} ";
		foreach ($indexs as $key => $columns) {
			$query_str .= "ADD INDEX {$key} ({$columns}), ";
		}
		$query_str = rtrim($query_str, ', ');
		return $this->db->query($query_str);
	}
	
	function get_data_table_like($tables, $kolom="", $likes="", $method="both", $isOrder = 0, $order_by = ""){
		if ($likes != '') {
			$this->db->like($kolom, $likes, $method);
		}
		
		if($isOrder){
			$this->db->order_by($order_by); 
		}
		
		$return = $this->db->get($tables);
		
		return $return;
	}
	/* =================== end of general model versi 2 =========================== */
	public function get_user_id_in_entitas($table, $entitas_id){
		$this->db->where('entitas_id', $entitas_id);
		$this->db->select('user_id');
		$query = $this->db->get($table);
		return $query;
	}

	public function get_user_in_session($table, $ArrUserID){
		$this->db->where_in('user_id', $ArrUserID);
		$this->db->select('session_id');
		$query = $this->db->get($table);
		return $query;
	}

	public function kick_user_in_company($entitas_id){
		$GetUserID = $this->get_user_id_in_entitas('user', $entitas_id);
		
		if(count($GetUserID->result()) > 0){
			$ArrUserID = array();
			$ArrSessionID = array();
			
			foreach ($GetUserID->result() as $key => $value) {
				array_push($ArrUserID, $value->user_id);
			}
			$GetUserSession = $this->get_user_in_session('activities_log', $ArrUserID);
			foreach ($GetUserSession->result() as $session) {
				array_push($ArrSessionID, $session->session_id);
			}
			if($ArrSessionID){
				$this->db->where_in('session_id', $ArrSessionID);
				$this->db->delete('activities_log');
				
				$this->db->where_in('id', $ArrSessionID);
				$this->db->delete('ci_sessions');
			}
		}

		return true;
	}
}