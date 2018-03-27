<?php 
	
	//Класс для различных подключений файлов
	class incl  {

		//Подключение модели
		static function model($model = null) {
			if ($model) {
				if (is_string($model)) {
					require 'http/models/'.$model.'Model.php';
				} 

				//Подключаем моде
				if (is_array($model)) {
					foreach ($model as $key => $value) {
						require 'http/models/'.$value.'Model.php';
					}
				}
			}
		}


		//Подключение контроллера
		static function controller($controller = null) {
			if ($controller) {
				if (is_string($controller)) {
					require 'http/controllers/'.$controller.'Controller.php';
				} 

				//Подключаем моде
				if (is_array($controller)) {
					foreach ($controller as $key => $value) {
						require 'http/controllers/'.$value.'Controller.php';
					}
				}
			}
		}	

		static public function package($file) {
			require 'requireds/packages/' . $file . '/package.php';
		}
	}
