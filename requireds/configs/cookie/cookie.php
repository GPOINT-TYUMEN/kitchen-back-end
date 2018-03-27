<?php

	class cookie {

		//Добавляет в куки
		static public function add($key, $value, $time = 1, $json = false, $domain = '/') {
			if ($json) {
				$value = json_encode($value);
			}

			setcookie($key, $value, (time() + 60) * $time, $domain);
		}	

		//Возращает значение из куки
		static public function get($key, $json = false) {
			$value = null;

			if (isset($_COOKIE[$key]))  {
				$value = $_COOKIE[$key];
			}

			if ($value && $json) {
				$value = json_decode($value, true);
			}
			return $value;
		}

		//Удаляет из куки
		static public function del ($key, $domain = '/') {
			setcookie($key, '', time() - 1, $domain);
		}
	}

cookie::add('hash', 'rest');