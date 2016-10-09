<h3>Заказ с сайта</h3>
<h4>№ заказа: <?=$orderId;?></h4>
<?foreach ($cartData as $data) {?>
<?=sprintf('<strong>Товар:</strong>%s %d шт.<br>', $data['name'], $data['num']);?>
<?}?>
<strong>ФИО:</strong> <?=$name;?><br>
<strong>Адрес:</strong> <?=$address;?><br>
<strong>E-mail:</strong> <?=$email;?><br>
<strong>Телефон:</strong> <?=$phone;?><br>