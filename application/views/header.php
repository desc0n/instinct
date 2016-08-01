<header>
    <div class="container">
        <div class="menu-row">
            <?foreach ($menu as $menuData) {
                $slug = '/page/' . $menuData['slug'];
                $class = $slug === $rootPage ? 'menu-item-active' : 'menu-item';

                $slug = str_replace('/page/main', '', $slug);
                ?>
            <a class="<?=$class;?>" href="<?=$slug;?>"><?=$menuData['name'];?></a>
            <?}?>
        </div>
        <div class="row">
            <div class="col-lg-3 text-center">
                <div class="question">
                    <p>Вам есть 18 лет?</p>
                    <p>
                        <button class="btn btn-yes">Да</button>
                        <button class="btn btn-no">Нет</button>
                    </p>
                </div>
                <div class="news-articles">
                    <h2>Новости</h2>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img class="header-img" src="/public/i/header_img.png">
                <h1 class="header-phone">Тел. 0-00-00-00</h1>
                <div class="header-search">
                    <div class="input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                    <button class="btn btn-warning">АКЦИЯ!</button>
                </div>
            </div>
            <div class="col-lg-3 text-center">
                <div class="btn-input" href="/input">Вход и регистрация</div>
                <div class="news-articles">
                    <h2>Статьи</h2>
                </div>
            </div>
        </div>
        <div class="row category-btns">
            <a href="#"><img src="/public/i/for_her.png"></a>
            <a href="#"><img src="/public/i/for_him.png"></a>
            <a href="#"><img src="/public/i/for_two.png"></a>
            <a href="#"><img src="/public/i/gifts.png"></a>
            <a href="#"><img src="/public/i/novelty.png"></a>
            <a href="#"><img src="/public/i/linen.png"></a>
            <a href="#"><img src="/public/i/aphrodisiacs.png"></a>
        </div>
    </div>
</header>