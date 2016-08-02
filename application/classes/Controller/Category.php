<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Category extends Controller_Base
{

	public function action_list()
	{
        /** @var $noticeModel Model_Notice */
        $noticeModel = Model::factory('Notice');

		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

		$template = $contentModel->getBaseTemplate();

		$categoryId = $this->request->param('id');

		$categoryData = $contentModel->getCategory(null, $categoryId);

		View::set_global('title', sprintf('Категория товара "%s"', Arr::get($categoryData, 'name')));
		View::set_global('rootPage', 'main');

		$page = Arr::get($_GET, 'page', 1);

		$notices = $noticeModel->getNotice(['category_id' => $categoryId]);

		$market_content = View::factory('market_content')
			->set('notices', $notices)
			->set('page', $page)
		;

		$template->content = View::factory('category')
			->set('market_content', $market_content)
			->set('noticesCount', count($notices))
			->set('categoryId', $categoryId)
			->set('page', $page)
		;
		
		$this->response->body($template);
	}
}