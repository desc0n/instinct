<h3>Заказ с сайта</h3>
<h4>№ заказа: <?=Arr::get($params, 'order_id');?></h4>
<?foreach (Arr::get($params, 'cart_data', []) as $data) {?>
<?=sprintf('<strong>Товар:</strong>%s %d шт.<br>', $data['name'], $data['num']);?>
<?}?>
<strong>ФИО:</strong> <?=Arr::get($params, 'name');?><br>
<strong>Адрес:</strong> <?=Arr::get($params, 'address');?><br>
<strong>E-mail:</strong> <?=Arr::get($params, 'email');?><br>
<strong>Телефон:</strong> <?=Arr::get($params, 'phone');?><br>
<strong>Комментарий:</strong> <?=Arr::get($params, 'comments');?><br>