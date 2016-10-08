<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller
{
	public function action_add_to_cart()
	{
        /** @var $cartModel Model_Cart */
        $cartModel = Model::factory('Cart');

        $cartModel->addToCart($this->request->post('noticeId'));
		$this->response->body('ok');
	}

    public function action_plus_cart_num()
	{
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

		$this->response->body($adminModel->plusCartNum($_POST));
	}

    public function action_minus_cart_num()
	{
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

		$this->response->body($adminModel->minusCartNum($_POST));
	}

    public function action_remove_from_cart()
	{
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

		$this->response->body($adminModel->removeFromCart($_POST));
	}

    public function action_remove_all_cart()
	{
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

		$this->response->body($adminModel->removeAllCart($_POST));
	}

    public function action_get_cart_num()
	{
        /** @var $cartModel Model_Cart */
        $cartModel = Model::factory('Cart');

		$this->response->body($cartModel->getCartNum());
	}

    public function action_add_review()
	{
        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

		$this->response->body($adminModel->addReview($_POST));
	}

}
