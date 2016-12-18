<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Панель управления</title>
	<!-- Bootstrap -->
	<link href="/public/css/bootstrap.css" rel="stylesheet">
	<link href="/public/css/admin.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="/public/js/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="/public/js/bootstrap.js"></script>
	<script src="/public/js/admin.js"></script>
	<script src="/public/js/bootstrap3-typeahead.min.js"></script>
	<script src="/public/js/ckeditor/ckeditor.js"></script>
</head>
<body>
<nav class="navbar navbar-default" role="navigation">
	<div class="container">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right hidden-sm hidden-xs">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> <?=(Auth::instance()->logged_in() ? Auth::instance()->get_user()->username : 'Вход');?> <span class="glyphicon glyphicon-chevron-down"></span></a>
						<ul class="dropdown-menu" role="menu">
							<?if(!Auth::instance()->logged_in()){?>
								<form class="form-inline form-login" role="form" method="post">
									<div class="input-group">
										<input type="text" class="form-control" placeholder="Логин" name="username">
									</div>
									<div class="input-group">
										<input type="password" class="form-control" placeholder="Пароль" name="password">
									</div>
									<button type="submit" class="btn btn-default" name="login">Войти</button>
								</form>
							<?} else{?>
								<?if(Auth::instance()->logged_in('admin')){?>
								<li role="presentation" class="divider"></li>
								<li role="presentation"><a role="menuitem" tabindex="-1" href="/admin/control_panel"><span class="glyphicon glyphicon-folder-open"></span> Админка</a></li>
								<li role="presentation" class="divider"></li>
								<?}?>
								<form class="form-inline form-login" role="form" method="post">
									<button type="submit" class="btn btn-default" name="logout"><span class="glyphicon glyphicon-log-out"></span> Выход</button>
								</form>
							<?}?>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right hidden-lg hidden-md">
					<li role="presentation" class="divider"></li>
					<li role="presentation">
						<?if(!Auth::instance()->logged_in()){?>
							<form class="form-inline form-login" role="form" method="post">
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Логин" name="username">
								</div>
								<div class="form-group">
									<input type="password" class="form-control" placeholder="Пароль" name="password">
								</div>
								<button type="submit" class="btn btn-default" name="login">Войти</button>
							</form>
						<?} else{?>
							<?if(Auth::instance()->logged_in('admin')){?>
							<a role="menuitem" tabindex="-1" href="/admin/control_panel"><span class="glyphicon glyphicon-folder-open"></span> Админка</a></li>
							<?}?>
							<form class="form-inline form-login" role="form" method="post">
								<button type="submit" class="btn btn-default" name="logout"><span class="glyphicon glyphicon-log-out"></span> Выход</button>
							</form>
						<?}?>
					<li role="presentation" class="divider"></li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</div>
</nav>
<div class="header-container">
	<div class="container">
		<div class="row">
		</div>
	</div>
</div>
<div class="post-nav ">
</div>
<div class="container mainContainer">
	<div class="container-fluid">
		<div class="row">
			<?if(Auth::instance()->logged_in('admin')){?>
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 sidebar admin-menu">
<!--					<div class="row">-->
<!--						<a class="btn btn-default admin-main-page-link" href="/admin/control_panel/add_category">-->
<!--							Редактировать категории-->
<!--						</a>-->
<!--					</div>-->
					<div class="row">
						<a class="btn btn-primary admin-main-page-link" href="/admin/control_panel/add_notice">
							Редактировать товары
						</a>
					</div>
					<div class="row">
						<a class="btn btn-success admin-main-page-link" href="/admin/control_panel/redact_page">
							Редактировать страницы
						</a>
					</div>
<!--					<div class="row">-->
<!--						<a class="btn btn-danger admin-main-page-link" href="/admin/control_panel/reviews_moderation">-->
<!--							Модерация отзывов-->
<!--						</a>-->
<!--					</div>-->
<!--					<div class="row">-->
<!--						<a class="btn btn-warning admin-main-page-link" href="/admin/control_panel/redact_main_page">-->
<!--							Редактирование главной страницы-->
<!--						</a>-->
<!--					</div>-->
				</div>
			<?}?>
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 main">
				<?=$admin_content;?>
			</div>
		</div>
	</div>
</div>

<div class="footer">
	<div class="container">
		<p class="text-muted"></p>
	</div>
</div>
</body>
</html>