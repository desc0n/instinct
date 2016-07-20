<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Base extends Controller
{
    public function before()
    {
        parent::before();

        /**
         * @var $adminModel Model_Admin
         */
        $adminModel = Model::factory('Admin');

        $guestId = Cookie::get('guest_id', null);

        if ($guestId === null) {
            $guestId = $adminModel->setGuestId();
        }

        View::set_global('guest_id', $guestId);
    }
}