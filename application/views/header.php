<header>
    <div class="container">
        <div class="menu-row">
            <?foreach ($menu as $menuData) {
                $slug = $menuData['slug'];
                $class = $slug === $rootPage ? 'menu-item-active' : 'menu-item';

                $slug = str_replace('main', '', $slug);
                ?>
            <a class="<?=$class;?>" href="/<?=$slug;?>"><?=$menuData['name'];?></a>
            <?}?>
        </div>
        <div class="row">
            <div class="col-lg-2 text-center">
                <div class="question">
                    <p>Вам есть 18 лет?</p>
                    <p>
                        <button class="btn btn-yes">Да</button>
                        <button class="btn btn-no">Нет</button>
                    </p>
                </div>
            </div>
            <div class="col-lg-8"></div>
            <div class="col-lg-2 text-center">
                <a class="menu-item-active" href="/input">Вход и регистрация</a>
            </div>
        </div>
    </div>
</header>