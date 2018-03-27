<?php
	
	require 'requireds/packages/overall.php'; // Для работый с сессиями
	require 'requireds/configs/session/session.php'; // Для работый с сессиями
	require 'requireds/configs/cookie/cookie.php'; // Для работый с куками
	require 'requireds/configs/smarty/libs/Smarty.class.php'; // Шаблонизатор

	//> Шаблонизатор
	$smarty               = new Smarty();
	$smarty->template_dir = 'app';
	$smarty->compile_dir  = 'requireds/configs/smarty/views/';
	$smarty->config_dir   = 'requireds/configs/smarty/configs/';
	$smarty->cache_dir    = 'requireds/configs/smarty/cache/';

	$smarty->assign('admin', '/app/admin/');
	$smarty->assign('site', '/app/site/views/');
	//< Шаблонизатор
	require 'http/models/model.php'; //Для работы с бд
	require 'http/controllers/controller.php'; //Для работы с контроллерами
	require 'requireds/configs/routes/web.php'; //Роутинг


