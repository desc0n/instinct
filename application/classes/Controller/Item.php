<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Item extends Controller_Base
{
	public function action_show()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');

        /** @var $noticeModel Model_Notice */
        $noticeModel = Model::factory('Notice');

		$id = $this->request->param('id');

		$params = $this->request->query();
		$params['id'] = $id;


		$notice = $noticeModel->getNotice($params);
		$noticeModel->setNoticeView($id);

		$itemData = (!empty($notice) ? $notice[0] : []);

		View::set_global('title', Arr::get($itemData, 'name'));

		$template = $contentModel->getBaseTemplate();

		$template->content=View::factory('item')
			->set('itemData', $itemData)
			->set('id', $id)
		;

		$this->response->body($template);
	}

	public function action_sale()
	{
		/** @var $contentModel Model_Content */
		$contentModel = Model::factory('Content');
		
		$template=View::factory('emplate');
		$id = $this->request->param('id');
		$_GET['id'] = $id;
		$notice = Model::factory('Notice')->getNoticeSale($_GET);
		$itemData = (!empty($notice) ? $notice[0] : []);
		$params['category_id'] = 5;
		
		$template->content = View::factory('item_sale')
			->set('categoryArr', $contentModel->getCategory($params))
			->set('itemData', $itemData)
			->set('params', $params)
			->set('id', $id)
		;
		
		$this->response->body($template);
	}

}