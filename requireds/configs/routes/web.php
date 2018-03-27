<?php

	class Route {
		static public $routes = [
			'GET' => [],
			'POST' => [],
			'ALL'  => []
		];

		//Будет хранить роут который пришёл
		static public $route, $method, $group = '';

		//Только методом GET
		/*
			route type string
			params type array || string  Перадача callback(контроллера)
		*/
		static public function get($route = null, $callback = null) {

			$response = self::check_routes_data($route, $callback, 'GET');

			return $response;
		}

		//Только методом POST
		static public function post($route = null, $callback = null) {
			$response = self::check_routes_data($route, $callback, 'POST');

			return $response;
		}

		//Можно отправлять любым методом
		static public function all ($route = null, $callback = null) {
			$response = self::check_routes_data($route, $callback, 'ALL');

			return $response;
		}

		static public function group($route, $callback) {
			$response = false;
			if (self::check_params($route)  &&  is_callable($callback)) {
				self::$group .= $route;
				$callback();
				self::$group = '';
				$response = true;
			}

			return $response;				
		}

		static private function check_routes_data($route, $callback, $method) {
			//Проверка входных данных
			$response = false;
			//Провряем роут и callback (callback может передавать название контроллера и метод или функцию)

			if (self::check_params($route)  &&  (is_callable($callback) || is_string($callback))) {

				$filter = explode('/', $route);

				$params  = []; // Тут будут хранится названий переменных определённые в роутинге
				$route = '';

				foreach ($filter as $key => $value) {
					//Проверяем, является ли это переменной
					if (preg_match("/^{\w+\}$/", $value)) {
						//Верезаем значения из фигурных скобках
						$params[$key] = str_replace(['{', '}'], '', $value);
					} else {
						$route .= $value . '/';
					}
				}

				$route = rtrim($route, '/');

				//METHOD - метод запроса GET или POST
				//GROUP группирует роут(отдельный метод вызывает как Route::group('route/'))
				$dataRoute = [
					'callback' => $callback // Запишем кэллбэк
				];

				//Если роутингом заложены параметры 
				if ($params) {
					$dataRoute['params'] = $params; //Хранит названия переменных определённые в route
				}

				self::$routes[$method][self::$group . $route] = $dataRoute;

				$response = true;
			}

			return $response;
		}

		//Проверка параметров 
		static private function check_params($params = null) {
			$result = false;

			if ($params &&  (is_string($params) || is_array($params))) {
				$result = true;
			}

			return $result;
		}

		//Проверка маршрута
		static private function check_route($route = null) {
			$result = false;

			if ($route && is_string($params)) {
				$result = true;
			}

			return $result;
		}		

		static public function start_controller($callback, $params = null) {
			$callback = explode('@', $callback); //Разбираем строку на контроллер и метод


			//Проверим пришёл ли контроллер и его метод	
			if (count($callback) === 2) {
				
				$controller = 'http/controllers/' . $callback[0] . 'Controller.php';  

				//Проверяем есть ли данный контроллер	
				if (file_exists($controller)) {
					require $controller;

					$method = $callback[1];
					
					$classController = self::get_controller($callback[0]) .'Controller';
					//Вызываем наш контроллер
					$c = new $classController();

					if (method_exists($c, $method)) {
						//Вызовим наш метод
						$c -> $method($params);						
					}				
				}
			} else {
				echo 'Не правильно определены параметры вызова контроллера';
			}
		}

		//Вернём контроллер
		static public function get_controller($controller) {
			$controller = explode('/', $controller);
			if (count($controller) > 1) {

				//Удаляем не нужные элементы 
				$controllerFilter = [];
				foreach ($controller as $key => $value) {
					if ($value !== '') {
						$controllerFilter[] = $value;
					}
				}

				//Возвращаем название класса контроллера
				$controller = $controllerFilter;
			}

			return $controller[count($controller) - 1];;
		}

		//Забирает роут который пришёл
		static public function get_route() {
			$route = urldecode($_SERVER['REQUEST_URI']);
			//Заберём только до знака вопроса(GET)
			$route = explode('?', $route)[0];

			self::$route = $route;		
		}

		//Разбирает route на переменные и возвращает роут
		static public function render_route($route, $method) {
			$regCount = count($route);

			$result = '';
			$url = ''; //Сдесь будем хранить наш роут который найдём

			//Перебираем массив в обратном порядке 
			for ($index = $regCount; $index > 0; $index--) {
				$result = '';
				//Собираем строку по частям из массива, дабы проверить является ли какая подстрока переменной
			 	for($index2 = 0; $index2 < $index; $index2++ ) {
			 		$result .= $route[$index2] . '/';	
			 	}
			 

			 	//Если роут не по умолчанию
			 	if ($result !== '/') {
			 		$result = rtrim($result, '/');
			 	}


			 	//Находим наш роут в массиве
			 	//$result хранит в себе route который мы пытаемся найти
			 	if (isset(self::$routes[$method][$result])) {
			 		$url = $result;
			 		$result = self::$routes[$method][$result];
					break;
			 	} else {
			 		$result = false;
			 	}
			}

			//Если роутинг найден
			$vars = [];
			if (is_array($result) && isset($result['params'])) {
				//Забираем название параметров и параметры
				foreach ($result['params'] as $key => $value) {
					if (isset($route[$key]) && $route[$key]) {
						$vars[$value] = $route[$key];	//Забираем значение данного параметра
					} 
				}
			}

			if ($result) {
				//Запишем корректный роутиг
				$route = [
					'route' => $url,
				];

				//Если переменные есть
				if ($vars) {
					$route['params'] = $vars;
				}
			} 

			return $route;
		}

		//Вернём метод
		static private function method() {
			self::$method = $_SERVER['REQUEST_METHOD'];
		}

		static function exist_route($route, $method) {
			$route = explode('/', $route);

			return self::render_route($route, $method);
		}

		static public function start() {
			self::get_route(); // Запишем роут
			self::method(); // Запишем метод


			$route = null;
		
			if (self::$method === 'POST') {
				$route = self::exist_route(self::$route, self::$method);
			}

			if (self::$method === 'GET') {
				$route = self::exist_route(self::$route, self::$method);
			}

			//ЕСЛИ НИ GET и не POST, то ИЩЕМ в all
			if (!$route) {
				$route = self::exist_route(self::$route, self::$method);	
			}

			if ($route) {
				$callback = self::$routes[self::$method][$route['route']]['callback'];
		
				//Если там лежит строк для class
				if(is_string($callback)) {
	
					static::start_controller($callback, isset($route['params']) ? $route['params'] : null);
				}

				if (is_callable($callback)) {
					$callback();
				}
			}

			//Если роутинг не найдён 
			if (!$route) {
				echo '404';
			}

		}	
	}

	//Подключаем роуты
	require 'http/routes.php';

	//> CONFIGS
	 Route::start();
	//> CONGIFS	


