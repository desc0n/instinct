<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller_Base
{
	public function action_index()
	{
        /** @var $contentModel Model_Content */
        $contentModel = Model::factory('Content');

        /** @var $noticeModel Model_Notice */
        $noticeModel = Model::factory('Notice');

        View::set_global('title', 'Главная');
        View::set_global('rootPage', 'main');

		$template = $contentModel->getBaseTemplate();
        
        $page = Arr::get($_GET, 'page', 1);

        $notices = $noticeModel->getNotice();
        
        $market_content = View::factory('market_content')
            ->set('notices', $notices)
            ->set('page', $page)
        ;

		$template->content = View::factory('index')
            ->set('market_content', $market_content)
            ->set('noticesCount', count($notices))
            ->set('page', $page)
        ;

		$this->response->body($template);
	}

	public function action_catalogs()
	{
        /** @var $adminModel Model_Admin */
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
        /** @var $contentModel Model_Content */
        $contentModel = Model::factory('Content');

        $slug = $this->request->param('slug');
        
        View::set_global('title', 'Главная');
        View::set_global('rootPage', $slug);

        $template = $contentModel->getBaseTemplate();
        
		$template->content = View::factory('page')
			->set('pageData', $contentModel->findPageBySlug($slug))
			->set('get', $_GET)
        ;
        
		$this->response->body($template);
	}

	public function action_cart()
	{
        /** @var $contentModel Model_Content */
        $contentModel = Model::factory('Content');

        /** @var $cartModel Model_Cart */
        $cartModel = Model::factory('Cart');

        View::set_global('title', 'Корзина');
        View::set_global('rootPage', 'cart');

        $template = $contentModel->getBaseTemplate();

		$template->content = View::factory('cart')
			->set('get', $_GET)
			->set('cart', $cartModel->getCart())
        ;

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