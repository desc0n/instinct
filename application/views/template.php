<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Основной инстинкт. <?=(isset($title) ? $title : '');?></title>
    <link rel="icon" href="/public/i/fav.png" sizes="38x38" type="image/png">
    <!-- Bootstrap -->
    <link href="/public/css/bootstrap.css?v=2" rel="stylesheet">
    <link href="/public/css/custom.css?v=5" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/jquery.rollbar.css">
    <link href='https://fonts.googleapis.com/css?family=Roboto&subset=latin,cyrillic' rel='stylesheet' type='text/css'>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/public/js/jquery.mousewheel.js"></script>
    <script type="text/javascript" src="/public/js/jquery.rollbar.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/public/js/bootstrap.js"></script>
    <script src="/public/js/scripts.js?v=4"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.page').rollbar({zIndex:80});
        });
    </script>
    <script type="text/javascript">
        $(function(){
            var base = 'body';
            $('a[href^="#"]').each(function(){
                var name = $(this).attr('href').substr(1);
                var anchor = document.getElementById(name) || document.getElementsByName(name);
                if(anchor = (anchor.item)?anchor.item(0):anchor){
                    var offset = $(base+' > .rollbar-content').height() - $(anchor).offset().top;
                    $(this).click(function(){
                        $(base).trigger('rollbar',-offset);
                    });
                }
            });
        });
    </script>
</head>
<body>
<?=View::factory('header')
    ->set('menu', $menu)
    ->set('rootPage', $rootPage)
;?>
<?
/** @var $contentModel Model_Content */
$contentModel = Model::factory('Content');
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-xs hidden-sm">
            <div class="catalog-list" id="accordion">
                <h3 class="text-center">Каталог</h3>
                <?foreach ($categories as $category) {?>
                <div>
                    <div>
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$category['id'];?>"><?=$category['name'];?></a>
                    </div>
                    <div id="collapse<?=$category['id'];?>" class="panel-collapse collapse">
                        <div>
                            <div class="category-child">
                                <a href="/category/list/<?=$category['id'];?>">Вся категория</a>
                            </div>
                            <?foreach ($contentModel->getCategory($category['id']) as $categoryChild){?>
                                <div class="category-child">
                                    <a href="/category/list/<?=$categoryChild['id'];?>"><?=$categoryChild['name'];?></a>
                                </div>
                            <?}?>
                        </div>
                    </div>
                </div>
                <?}?>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 hidden-xs hidden-sm">
            <div class="market">
                <div class="market-head-content">
                    <button class="btn btn-danger offer-phone">
                        <img src="/public/i/phone.png">
                        <div class="offer-phone-text">
                            <p>2-91-77-15</p>
                            <p>заказать звонок</p>
                        </div>
                    </button>
                    <a class="btn btn-default cart-display" href="/cart">
                        <img src="/public/i/red_cart.png">
                        <div class="cart-display-text">
                            <p>КОРЗИНА</p>
                            <p>Товар <span id="cart-num">0</span></p>
                        </div>
                    </a>
                </div>
                <?=$content;?>
                <?=View::factory('footer')
                    ->set('lastSeeItems', $lastSeeItems)
                ;?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 hidden-md hidden-lg">
            <?=$content;?>
        </div>
        <div class="col-lg-1 col-md-1 hidden-xs hidden-sm">
            <div class="cards">
                <div class="cards-title">ФОРМА ОПЛАТЫ</div>
                <div class="cards-list">
                    <img src="/public/i/visa.png">
                    <img src="/public/i/master_card.png">
                    <img src="/public/i/golden_crown.png">
                    <img src="/public/i/maestro.png">
                </div>
            </div>
            <div class="accounts">
                <a href="#"><img src="/public/i/facebook.png"></a>
                <a href="#"><img src="/public/i/ok.png"></a>
                <a href="#"><img src="/public/i/instagram.png"></a>
                <a href="#"><img src="/public/i/vk.png"></a>
                <a href="#"><img src="/public/i/mail.png"></a>
                <a href="#"><img src="/public/i/google.png"></a>
                <a href="#"><img src="/public/i/yandex.png"></a>
                <a href="#"><img src="/public/i/f_account.png"></a>
                <a href="#"><img src="/public/i/ebay.png"></a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="loginModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Войти</h4>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab1" data-toggle="tab">Вход</a></li>
                    <li><a href="#tab2" data-toggle="tab">Регистрация</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12">
                                <form class="form" method="post" action="/">
                                    <div style="margin-bottom: 25px" class="form-group">
                                        <input name="username" class="form-control" placeholder="Ваш логин" required="">
                                    </div>
                                    <div style="margin-bottom: 25px" class="form-group">
                                        <input name="password" type="password" class="form-control" placeholder="Ваш пароль" required="">
                                    </div>
                                    <button class="btn btn-lg btn-danger btn-block" type="submit" name="login">Вход</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12 col-xs-12 form" id="regForm">
                                <div style="margin-bottom: 25px" class="form-group">
                                    <input id="username" class="form-control" placeholder="Логин" required="">
                                </div>
                                <div style="margin-bottom: 25px" class="form-group">
                                    <input id="email" class="form-control" placeholder="E-mail" required="">
                                </div>
                                <div style="margin-bottom: 25px" class="form-group">
                                    <input id="password" type="password" class="form-control" placeholder="Пароль" required="">
                                </div>
                                <div style="margin-bottom: 25px" class="form-group">
                                    <input id="rePassword" type="password" class="form-control" placeholder="Подтвердить пароль" required="">
                                </div>
                                <button class="btn btn-lg btn-danger btn-block" id="regBtn">Зарегистрироваться</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</body>
</html>