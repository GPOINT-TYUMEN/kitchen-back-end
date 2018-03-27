<?php
	
	incl::controller('auth'); //Контроллер для работы с авторизацией
	incl::model('admin'); //Контроллер для работы с авторизацией

	class indexController extends controller {

		// Главная страница	
		 public function index() {

		 	//Проверим авторизиван ли пользователь
			if ($user =  authController::check_admin()) {
				$this -> template('admin/views/index', [
						'title' => 'Админ панель',
						'page'  => 'Добро пожаловать в админ панель',
						'user'  => $user,
						'countUsers' =>  admin::count_users() //Общее количество зарегистрированных пользователей
				]);
			}

		}	
		

		// Настройки
		 public function profile() {
		 	//Проверим авторизиван ли пользователь
			if ($user =  authController::check_admin()) {
				$this -> template('admin/views/profile', [
						'title' => 'Админ панель',
						'page'  => 'Добро пожаловать в админ панель',
						'user'  => $user,
						'countUsers' =>  admin::count_users() //Общее количество зарегистрированных пользователей
				]);
			}
		}	

		//> AJAX
		public function edit() {
			$data = [
				'success' => 0
			];
		 	//Проверим авторизиван ли пользователь
			if ($admin =  authController::check_admin()) {
				$nickname = isset($_POST['nickname']) ?  trim($_POST['nickname']) : null;
				$password = isset($_POST['password']) ?  trim($_POST['password']) : null;

				if ($nickname) {
					$data = $this -> update_user_nick($admin, $nickname, $data);
				}

				if ($password) {
					$data = $this -> update_user_psw($admin, $password, $data);
				}
			}	

			echo json_encode($data);
		}

		private function update_user_nick($admin, $nickname, $data) {
			if (!$user = admin::user_by_nick($nickname)) {
				admin::update_user([
					'user_nick' => $nickname
				],
				[
					[
						'id_user', '=', $admin['id_user']
					]
				]
				); 

				$data['success'] = 1;
			} else {
				$data['message'] = 'Данный никнейм занят';
			}

			return $data;
		}

		private function update_user_psw($admin, $password, $data) {
			admin::update_user_psw([
				'password' => md5($password)
			],
			[
				[
					'id_user', '=', $admin['id_user']
				]
			]
			); 
			return $data;
		}		
		//< AJAX	
	}


