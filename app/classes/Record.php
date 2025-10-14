<?php

class Record {

	protected $id = 0;
	protected $key;
	protected $table;
	protected $query = "SELECT * FROM TABLE WHERE KEY = ID";
	protected $info = [];
	protected $fields = [];

	public function __construct($id=0) {
		if((int)$id>0) {
			$sql = str_replace(["TABLE", "KEY", "ID"], [$this->table, $this->key, (int)$id], $this->query);
			$result = sql_select_row($sql);
			if($result) {
				$this->id = (int)$id;
				$this->info = $result;
				if(isset($result['fields'])) {
					$this->fields = fromdb($result['fields'], true);
				}
			}
		}
	}

	public function id() {
		return $this->id;
	}

	public function set_id($id) {
		$this->id = (int)$id;
	}

	public function get($field) {
		if(isset($this->info[$field])) {
			return $this->info[$field];
		} elseif(isset($this->fields[$field])) {
			return $this->fields[$field];
		}
		return "";
	}

	public function set($arr) {
		if(is_array($arr)) {
			foreach($arr as $key => $val) {
				$this->info[$key] = $val;
			}
		}
	}

	public function clear() {
		$this->info = [];
	}

	public function add() {
		if(is_array($this->info)) {
			$id = query_insert($this->table, $this->info);
			if($id>0) {
				$this->id = (int)$id;
				return $id;
			}
		}
		return false;
	}

	public function update() {
		if(is_array($this->info) && $this->id>0) {
			return query_update($this->table, $this->info, $this->key." = ".$this->id);
		}
		return false;
	}

	public function delete() {
		if($this->id>0) {
			return query_update($this->table, array("deleted" => 1), $this->key." = ".$this->id);
		}
		return false;
	}

	public function remove() {
		if($this->id>0) {
			return query_delete($this->table, $this->key." = ".$this->id);
		}
		return false;
	}

}