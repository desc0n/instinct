<header>
    <div class="container">
        <div class="row">
            <?foreach ($menu as $menuData) {
                $slug = $menuData['slug'];
                $class = $slug === $rootPage ? 'menu-item-active' : 'menu-item';

                $slug = str_replace('main', '', $slug);
                ?>
            <a class="<?=$class;?>" href="/<?=$slug;?>"><?=$menuData['name'];?></a>
            <?}?>
        </div>
    </div>
</header>