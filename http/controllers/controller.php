<?php


	class controller  {
		static public $smarty;

		//Отображаем шаблон
		public function template($template, $data = null) {
			self::$smarty -> display($template . '.html', $data);
		}

		//Возвращаем шаблон 
		public function html() {

		}
	}

	//Определяем шаблонизатор внутри контроллера
	controller::$smarty = $smarty;

	$c = new controller;

	//$c -> template('site/views/index');
