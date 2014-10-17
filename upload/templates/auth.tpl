<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Авторизация</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/templates/css/style.css">
	</head>

	<body>
		<div class="container">

			<div class="content">
				<div class="col col-mb-12 col-3"></div>
				<div class="col col-mb-12 col-6">
					<div class="main-error alert mt0 hide ta-center"></div>
				</div>
				<div class="col col-mb-12 col-3"></div>

				<div class="col col-mb-12 col-4">&nbsp;</div>
				<div class="col col-mb-12 col-4 ta-center">
					<form class="ajax" method="post" action="/system/ajax/auth.php">
						<input type="hidden" name="act" value="login">

						<h2>Авторизация</h2>
						<div class="mb0">
							<p class="m0">
								<input name="username" type="text" class="input" placeholder="Логин" autofocus>
							</p>
							<p class="m0">
								<input name="password" type="password" class="input" placeholder="Пароль">
							</p>
						</div>
						<p>
							<input class="checkbox" name="remember-me" type="checkbox" value="remember-me" checked id="checkMe"><label for="checkMe"><span></span> Запомнить</label>
							&nbsp;&nbsp;<button class="btn btn-large" type="submit">Войти</button>
						</p>

					</form>
				</div>
				<div class="col col-mb-12 col-4">&nbsp;</div>
			</div>


		</div> <!-- .container -->

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="/templates/js/ajaxform.js"></script>
	</body>
</html>