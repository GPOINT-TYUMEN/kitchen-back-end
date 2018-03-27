<?php 

	define('DB_HOST', 'localhost');
	define('DB_LOGIN', 'root');
	define('DB_PASSWORD', '');
	define('DB_BD', 'gpoint');
	
	class model {
		static public $host  = 'localhost',
					  $login = 'root', 
					  $psw   = '',
					  $bd    =  'gpoint';

		static public function db($query, $dbResult = true) {
			$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_BD); 		


			if ($mysqli -> connect_errno) {
				die('Ошибка соединения: ' . $mysq -> connect_errno);
			} 	

			
			$mysqli -> set_charset("utf8"); //Устанавливаем кодировку

			if ($dbResult) {
				$result = $mysqli -> query($query);

				$modelResult = [];
				while ($resultQuery = $result -> fetch_assoc()) {
					$modelResult[] = $resultQuery;	
				};
				$result -> close();
				return $modelResult;	
			} else {
				$mysqli -> query($query);	
				$mysqli -> close();			
			}
		}

		//Поиск в базе данных
		static public function find($table, $params = null) {
			$query = "SELECT * FROM " . $table;

			if ($params) {
				$query .= " WHERE ";

				foreach ($params as $key => $value) {
					$query .= "`" . $params[$key][0] . "`" . $params[$key][1] ; 

					if (is_string($params[$key][2])) {
						$query .= "'" . $params[$key][2] . "'";
					} else {
						$query .= $params[$key][2];
					}

					//Есть ли дополнительное условие
					if (isset($params[$key + 1])) {
						$query .= " AND ";
					}
				}
			} 

			return self::db($query);

		}

		static public function count($table, $column, $params = null) {
			$query = "SELECT COUNT(`" . $column  . "`) FROM " . $table;

			if ($params) {
				$query .= " WHERE ";

				foreach ($params as $key => $value) {
					$query .= "`" . $params[$key][0] . "`" . $params[$key][1] ; 

					if (is_string($params[$key][2])) {
						$query .= "'" . $params[$key][2] . "'";
					} else {
						$query .= $params[$key][2];
					}

					//Есть ли дополнительное условие
					if (isset($params[$key + 1])) {
						$query .= " AND ";
					}
				}
			} 

			return self::db($query);			
		}


		static public function update($table, $updates, $params) {
			$query = 'UPDATE ' . $table . ' SET ';

			//То что будем обновлять
			$nametables = '';
			$values     = '';

			foreach ($updates as $key => $value) {
				$nametables .= "`" . $key . "`=";

				if (is_string($value)) {
					$nametables .= "'" . $value . "',";
				} else {
					$nametables .= $value . ",";
				}
			}	

			$query .= rtrim($nametables, ',');

			//То что будем обновлять
			if ($params) {
				$query .= " WHERE ";

				foreach ($params as $key => $value) {
					$query .= "`" . $params[$key][0] . "`" . $params[$key][1] ; 

					if (is_string($params[$key][2])) {
						$query .= "'" . $params[$key][2] . "'";
					} else {
						$query .= $params[$key][2];
					}

					//Есть ли дополнительное условие
					if (isset($params[$key + 1])) {
						$query .= " AND ";
					}
				}
			} 
			
			self::db($query, false);
		} 

		static public function add($table, $params) {
			$query = 'INSERT INTO ' . $table;

			$nametables = '';
			$values     = '';

			foreach ($params as $key => $value) {
				$nametables .= "`" . $key . "`,";

				if (is_string($value)) {
					$values .= "'" . $value . "',";
				} else {
					$values .= $value . ",";
				}
			}			


			$query .= "(" . rtrim($nametables, ',') . ") " .  " values(" . rtrim($values, ',') . ")";

			var_dump($query);
			self::db($query, false);
		}

		//Удаление из базы данных
		static public function del($table, $params = null) {
			$query = 'DELETE FROM ' . $table;

			if ($params) {
					$query .= ' WHERE ';

				foreach ($params as $key => $value) {
					$query .= $params[$key][0] . $params[$key][1] . $params[$key][2]; 

					//Есть ли дополнительное условие
					if (isset($params[$key + 1])) {
						$query .= ' AND ';
					} 
				}			
			}

		 	self::db($query, false);
		}	

	}
