<?php

	incl::model('auth'); //Модель для работы с авторизацией

	class authController extends controller {

		//Проверим авторизован ли администратор
		static public function check_admin () {
			$result  = null;

			if ($user = self::check_auth()) {
				if ($user['role']['status_role'] > 0) {
					$result = $user;
				}
			}

			return $result;
		}


		//Проверка авторизациия пользователя
		static public function check_auth() {
			$result = null;

			//Авторизован ли пользователшь
			if ($userHash = cookie::get('user_hash')) {

				//Ищем hash авторизации
				if ($user = auth::user_hash($userHash)) {
					
					//Вернём роль пользователя
					$user['role'] = auth::get_role($user['id_role']);

					$result = $user;
				} 

			} 

			return $result;
		}

	}


