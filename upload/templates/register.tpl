<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Регистрация</title>
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
						<form class=" ajax" method="post" action="/system/ajax/auth.php">
							<input type="hidden" name="act" value="register">

							<h2>Регистрация</h2>
							<p class="mb0">
								<input name="username" type="text" class="input" placeholder="Логин" autofocus>
							</p>
							<p>
								<input name="password1" type="password" class="input" placeholder="Пароль">
							</p>
							<p>
								<input name="password2" type="password" class="input" placeholder="Подтверждение пароля">
							</p>
							<p>
								<button class="btn" type="submit">Регистрация</button>
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