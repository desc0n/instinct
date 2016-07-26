<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Category extends Controller_Base
{

	public function action_list()
	{
        /** @var $noticeModel Model_Notice */
        $noticeModel = Model::factory('Notice');

		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');
		
        $template=View::factory('template');
		
		$template->content = View::factory('category')
            ->set('categoryArr', $contentModel->getCategory(Arr::get($_GET, 'cid'), Arr::get($_GET, 'id')))
            ->set('subCategoryArr', $contentModel->getCategory(Arr::get($_GET, 'id')))
			->set('notices', $noticeModel->getNotice(['category_id' => Arr::get($_GET, 'id')]))
			->set('get', $_GET)
			->set('post', $_POST)
		;
		
		$this->response->body($template);
	}

	public function action_sale()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');
		
		$template=View::factory("template");
		$_GET['category_id'] = 5;
		$params = [];
		$params = array_merge($params, $_GET);
		$params = array_merge($params, $_POST);
		
		$template->content = View::factory('category_sale')
			->set('categoryArr', $contentModel->getCategory($params))
			->set('noticeData', Model::factory('Notice')->getNoticeSale($params))
			->set('get', $_GET)
			->set('post', $_POST)
		;
		
		$this->response->body($template);
	}

}