<?php

/**
 * Class Model_Cart
 */
class Model_Cart extends Kohana_Model
{
    private $guestId;

    public function __construct()
    {
        /** @var $adminModel Model_Admin */
        $adminModel = Model::factory('Admin');

        $this->guestId = $adminModel->getGuestId();
    }

    /**
     * @param int $noticeId
     *
     * @return bool
     */
    public function addToGuestCart($noticeId)
    {
        $cartData = $this->getGuestCartByNotice($noticeId);
        $cartId = Arr::get($cartData, 'id');

        if (empty($cartId)) {
            $res = DB::insert('cart', ['guest_id', 'notice_id', 'date'])
                ->values([$this->guestId, $noticeId, DB::expr('NOW()')])
                ->execute()
            ;

            $cartId = $res[0];
        } else {
            DB::update('cart')
                ->set(['num' => DB::expr('(num + 1)')])
                ->where('id', '=', $cartData['id'])
                ->execute()
            ;
        }

        return $cartId;
    }

    /**
     * @param int $noticeId
     *
     * @return bool
     */
    public function addToCart($noticeId)
    {
        return $this->addToGuestCart($noticeId);
    }

    /**
     * @param int $id
     * @param int $value
     *
     * @return int
     */
    public function setCartNum($id, $value)
    {
        DB::update('cart')
            ->set(['num' => $value])
            ->where('id', '=', $id)
            ->execute()
        ;

        return $this->getGuestCartNum();
    }

    /**
     * @param $positionId
     * @return bool
     */
    public function removeCartPosition($positionId)
    {
        DB::update('cart')
            ->set(['show' => 0])
             ->where('id', '=', $positionId)
            ->execute()
        ;

        return true;
    }

    public function removeAllGuestCartPositions()
    {
        DB::update('cart')
            ->set(['show' => 0])
            ->where('guest_id', '=', $this->guestId)
            ->execute()
        ;

        return true;
    }

    public function removeAllCartPositions()
    {
        return $this->removeAllGuestCartPositions();
    }

    /**
     * @return array
     */
    public function getCart()
    {
        return $this->getGuestCart();
    }

    /**
     * @return array
     */
    public function getGuestCart()
    {
        return DB::select('c.*', 'n.*', 'c.id', ['n.id', 'notice_id'])
            ->from(['cart', 'c'])
            ->join(['notice', 'n'])
            ->on('n.id', '=', 'c.notice_id')
            ->where('c.show', '=', 1)
            ->and_where('c.guest_id', '=', $this->guestId)
            ->execute()
            ->as_array()
        ;
    }

    /**
     * @param int $noticeId
     *
     * @return bool|array
     */
    public function getGuestCartByNotice($noticeId)
    {
        return DB::select('c.*', 'n.*', 'c.id', ['n.id', 'notice_id'])
            ->from(['cart', 'c'])
            ->join(['notice', 'n'])
            ->on('n.id', '=', 'c.notice_id')
            ->where('c.show', '=', 1)
            ->and_where('c.guest_id', '=', $this->guestId)
            ->and_where('c.notice_id', '=', $noticeId)
            ->execute()
            ->current()
        ;
    }

    /**
     * @return int
     */
    public function getGuestCartNum()
    {
        $res = DB::select([DB::expr('SUM(c.num)'), 'num'])
            ->from(['cart', 'c'])
            ->where('c.show', '=', 1)
            ->and_where('c.guest_id', '=', $this->guestId)
            ->execute()
            ->current()
        ;

        return Arr::get($res, 'num', 0);
    }

    /**
     * @return int
     */
    public function getCartNum()
    {
        return (int)$this->getGuestCartNum();
    }

    public function sendOrder($name, $phone, $address, $email)
    {
        /** @var $adminModel Model_Admin */
        $adminModel = Model::factory('Admin');

        $adminModel->addOrder($name, $phone, $address, $email);

        return $this->removeAllCartPositions();
    }
}