<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Base
{

	public function action_index()
	{
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

        /**
         * @var $noticeModel Model_Notice
         */
        $noticeModel = Model::factory('Notice');

        View::set_global('title', 'Главная');

		$template=View::factory("template");

		$template->content = View::factory("index")
		;

		$this->response->body($template);
	}

	public function action_catalogs()
	{
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

        View::set_global('title', 'Каталог');

        $template=View::factory("template");

		$template->content = View::factory("catalogs")
            ->set('catalogsData', $adminModel->getCatalogsData())
			->set('get', $_GET)
			->set('post', $_POST);

		$this->response->body($template);
	}

	public function action_page()
	{
		$template=View::factory("template");
		$id = $this->request->param('id');
		$_GET['id'] = $id;
		$template->content = View::factory("page")
			->set('pageData', Model::factory('Admin')->getPage($_GET))
			->set('get', $_GET);
		$this->response->body($template);
	}

	public function action_cart()
	{
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

        View::set_global('title', 'Корзина');

        $viewSuccess = false;

        $orderStatus = $adminModel->findOrderStatus([
            'order_id' => Arr::get($_GET, 'id'),
        ]);

        if (Arr::get($orderStatus, 'status') == 1) {
            $viewSuccess = true;
            $adminModel->setOrderStatus([
                'order_id' => Arr::get($_GET, 'id'),
                'status' => 2
            ]);
        }

        if (isset($_POST['neworder'])) {
            $order_id = $adminModel->addOrder($_POST);
            HTTP::redirect(sprintf('/cart?result=success&id=%d', $order_id));
        }

        $template = View::factory("template")
            ->set('viewSuccess', $viewSuccess);

		$template->content = View::factory("cart")
			->set('get', $_GET);
		$this->response->body($template);
	}

    public function action_reviews()
    {
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

        View::set_global('title', 'Отзывы');

        $template = View::factory("template");

        $content = View::factory('reviews')
            ->set('reviewsData', $adminModel->findReviews());

        $template
            ->set('content', $content)
            ->set('page', 'reviews');
        $this->response->body($template);
    }
}