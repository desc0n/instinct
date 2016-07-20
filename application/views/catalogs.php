<div class="container">
    <div class="row">
        <div class="col-sm-10 col-xs-10 col-sm-10">
            <div class="header item-title"><h3>Скачать каталоги</h3></div>
            <?foreach($catalogsData as $id => $name){?>
                <h3><a href="/public/catalogs/<?=$name;?>" target="_blank"><?=$name;?></a></h3>
            <?}?>
        </div>
    </div>
</div>