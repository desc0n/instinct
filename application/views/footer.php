<footer>
    <h2 class="text-center"><strong>НЕДАВНО ПРОСМОТРЕННЫЙ ТОВАР</strong></h2>
    <div class="last-see-items">
        <div class="last-see-items-row">
            <?=View::factory('item_thumb');?>
            <?=View::factory('item_thumb');?>
            <?=View::factory('item_thumb');?>
            <?=View::factory('item_thumb');?>
        </div>
    </div>
    <div class="footer-warning">
        <h4>
            <img src="/public/i/footer-logo.png" class="pull-left">
            Правила сайта
        </h4>
        <p>
            <img src="/public/i/age18.png" class="pull-left">
            Наш магазин выполняет заказы, поступившие  только  от  лиц
            старше 18 лет. Если  Вы еще не достигли указанного возраста,
            пожалуйста, покиньте этот сайт.
        </p>
        <p>
            Сайт     является    информационным    ресурсом   и    не    содержит
            порнографических     или     других       материалов,      запрещенных
            законодательством    к    показу     или     продаже    на     территории
            Российской федерации.
        </p>
    </div>
</footer>