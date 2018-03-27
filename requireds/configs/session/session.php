<?php
	session_start();

	class session {

		//Добавляет в сесиию
		static public function add($key, $value, $json = false) {
			if ($json) {
				$value = json_encode($value);
			}

			$_SESSION[$key] = $value;
		}	

		//Возращает значение из сессию
		static public function get($key, $json = false) {
			$value = isset($_SESSION[$key]) ? $_SESSION[$key] : null; 

			if ($value && $json) {
				$value = json_decode($value, true);
			} 

			return  $value;
		}

		//Удаляет из сессии
		static public function del ($key) {
			unset($_SESSION[$key]);
		}

		//Вернёт токен
		static public function token() {

		}

		//Создаст токен
		static public function set_token() {

		}

	}

