<?php

	class auth {
		static function user_hash($hash) {
			$user = model::find('users', [
				[
					'auth_hash', '=', $hash
				]
			]);

			if ($user) {
				$user = $user[0];
			}

			return $user;
		}

		static public function get_role($id_role) {
			$role = model::find('role', [
				[
					'id_role', '=', $id_role
				]
			]); 

			if ($role) {
				$role = $role[0];
			}

			return 	$role;		
		}		
	}


