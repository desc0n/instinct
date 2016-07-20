<?
/**
 * @var $adminModel Model_Admin
 */
$adminModel = Model::factory('Admin');
?>
<div class="container">
    <div class="row afterf">
        <div class="col-md-1"></div>
        <div class="col-md-10 col-xs-10 col-sm-10">
            <h3>Оформление заказа</h3>
            <form method="post" id="order-form">
                <div class="delivery-type-form" id="deliveryTypeForm">
                    <div class="top-border"></div>
                    <h4>Контактная информация</h4>
                    <div class="quest-client-order-form">
                        <label class="pull-left">ФИО <span>*</span> :</label>
                        <input class="form-control cart-customer-field" id="name" name="name" type="text" placeholder="ФИО" value="">
                    </div>
                    <div class="quest-client-order-form">
                        <label class="pull-left">Телефон <span>*</span> :</label>
                        <input class="form-control cart-customer-field" id="phone" name="phone" type="text" placeholder="Телефон" value="">
                    </div>
                    <div class="quest-client-order-form">
                        <label class="pull-left">Адрес <span>*</span> :</label>
                        <input class="form-control cart-customer-field" id="address" name="address" type="text" placeholder="Адрес" value="">
                    </div>
                    <div class="quest-client-order-form">
                        <label class="pull-left">E-mail :</label>
                        <input class="form-control cart-customer-field" id="email" name="email" type="text" placeholder="E-mail" value="">
                    </div>
                    <div class="quest-client-order-form">
                        <label class="pull-left">Комментарии :</label>
                        <textarea class="form-control cart-customer-field" id="comments" name="comments"></textarea>
                    </div>
                    <div class="bottom-border"></div>
                </div>
                <input type="hidden" name="neworder">
            </form>
            <div class="delivery-type-form">
                <div class="top-border"></div>
                <h4>Список товаров в корзине</h4>
                <table class="table cart-table">
                    <tbody>
                    <tr><td class="item-name"></td><td class="item-price"></td><td class="item-num"></td><td class="item-price"></td><td class="item-actions"></td></tr>
                    <?
                    $allPrice = 0;
                    $cart = $adminModel->getCart(['guest_id' => Cookie::get('guest_id')]);
                    foreach($cart as $cartData) {
                        $allPrice += $cartData['price']*$cartData['num'];
                        ?>
                        <tr id="tableRow_<?=$cartData['id'];?>">
                            <td class="text-left item-name">
                                    <a href="/item/<?=$cartData['notice_id'];?>"><?=$cartData['name'];?></a>
                            </td>
                            <td class="item-price">
                                    <span><?=$cartData['price'];?></span>
                                    <input type="hidden" class="position-price" id="positionPrice_<?=$cartData['id'];?>" value="<?=$cartData['price'];?>">
                            </td>
                            <td class="item-num">
                                <input class="form-control position-num" id="positionNum_<?=$cartData['id'];?>" type="text" value="<?=$cartData['num'];?>">
                                <div class="btn-group">
                                    <button class="btn btn-default position-num-plus" value="<?=$cartData['id'];?>">+</button>
                                    <button class="btn btn-default position-num-minus" value="<?=$cartData['id'];?>">-</button>
                                </div>
                            </td>
                            <td class="item-price">
                                <span  id="positionSum_<?=$cartData['id'];?>"><?=$cartData['price']*$cartData['num'];?></span>
                            </td>
                            <td class="text-center item-actions">
                                <button class="btn btn-default remove-position" value="<?=$cartData['id'];?>">Удалить <span class="glyphicon glyphicon-remove"></span></button>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3" class="text-right item-price">
                            Общая сумма:
                        </td>
                        <td class="item-price">
                            <span id="allPrice"><?=$allPrice;?></span>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-default remove-all-positions">Удалить всё</button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
                <div class="bottom-border"></div>
            </div>
            <?if (!empty($cart)) {?>
            <button class="btn btn-default submit-order-btn">Отправить заказ</button>
            <?}?>
        </div>
    </div>
</div>
