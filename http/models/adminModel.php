<?php

	class admin {
		//Количество пользователей
		static public function count_users() {
			$count = model::count('users', 'id_user'); 
			$count = $count[0]['COUNT(`id_user`)'];
			return $count;
		}		

		static public function user_by_nick($nickname) {
			$user = model::find('users', [
				[
					'user_nick', '=', $nickname
				]
			]);

			if ($user) {
				$user = $user[0];
			}

			return $user;
		}

		static public function update_user($updates, $params) {
			model::update('users', $updates, $params);
		}	

		static public function update_user_psw($updates, $params) {
			model::update('users', $updates, $params);
		}				
	}


