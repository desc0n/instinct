<header class="row">
    <div class="container hidden-xs hidden-sm">
        <div class="menu-row">
            <?foreach ($menu as $menuData) {
                $slug = $menuData['slug'];
                $class = $slug === $rootPage ? 'menu-item-active' : 'menu-item';
                
                $slug = '/page/' . $slug;
                $slug = str_replace('page/main', '', $slug);
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
                <a href="/"><img class="header-img" src="/public/i/header_img.png"></a>
                <h1 class="header-phone">Тел. 2-97-77-15</h1>
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
    <div class="xs-container hidden-lg hidden-md row navbar-default">
        <div class="xs-header-menu col-xs-12">
            <div class="contacts-btn col-xs-2 dropdown">
                <button type="button" class="navbar-toggle dropdown-toggle" data-toggle="dropdown" id="dropdownMenu">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
                    <?foreach ($menu as $menuData) {
                        $slug = $menuData['slug'];
                        $slug = '/page/' . $slug;
                        $slug = str_replace('page/main', '', $slug);
                        ?>
                        <li role="presentation"><a  role="menuitem" tabindex="-1" href="<?=$slug;?>"><?=$menuData['name'];?></a></li>
                    <?}?>
                </ul>
            </div>
            <div class="contacts-btn col-xs-2">
                <img src="/public/i/phone.png">
            </div>
            <div class="contacts-btn col-xs-2">
                <div class="white-round-btn">Доставка</div>
            </div>
            <div class="contacts-btn col-xs-2">
                <div class="white-round-btn">Акция!</div>
            </div>
            <div class="contacts-btn red-cart col-xs-3">
                <div class="white-round-btn pull-right">
                    <a href="/cart">
                    Корзина
                    <img src="/public/i/red_cart.png">
                    </a>
                </div>
            </div>
        </div>
        <div class="xs-header-middle col-xs-12 row">
            <div class="col-xs-7">
                <a href="/"><img class="header-img" src="/public/i/header_img.png"></a>
            </div>
            <div class="col-xs-5">
                <button class="btn btn-default btn-dark">Владивосток</button>
                <div class="dropdown">
                    <button class="btn btn-default btn-dark dropdown-toggle" data-toggle="dropdown" id="dropdownMenu2">
                        Каталог &nbsp;&nbsp;&nbsp; <span class="glyphicon glyphicon-chevron-down"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu2">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="/public/i/for_her.png"></a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="/public/i/for_him.png"></a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="/public/i/for_two.png"></a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="/public/i/gifts.png"></a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="/public/i/novelty.png"></a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="/public/i/linen.png"></a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><img src="/public/i/aphrodisiacs.png"></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="xs-header-search col-xs-12 row">
            <div class="col-xs-5">
                <button class="btn btn-default btn-dark">Личный кабинет</button>
            </div>
            <div class="col-xs-7">
                <div class="input-group">
                    <input type="text" class="form-control">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-light" type="button"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>