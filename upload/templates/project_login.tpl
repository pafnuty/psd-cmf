<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>{$project.title} - Авторизация</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/templates/css/style.css">
	</head>

	<body>
		<div class="container">

			<div class="content">
				<div class="col col-mb-12 col-3"></div>
				<div class="col col-mb-12 col-6 ta-center">
					<h4 class="mb0">Введите пароль доступа к проекту: <br> <span class="text-red">"{$project.title}"</span></h4>
				</div>
				<div class="col col-mb-12 col-3"></div>

				<div class="col col-mb-12 col-4">&nbsp;</div>
				<div class="col col-mb-12 col-4 ta-center">
					{if $project.id}
						<form class="ajax" method="post" action="/project_login.php">
							<input type="hidden" name="project" value="{$project.name}">
							<input type="hidden" name="backUrl" value="/{$project.backUrl}">

							<p class="mb0">
								<input name="password" type="password" class="input" placeholder="Пароль">
							</p>
							<p>
								<button class="btn btn-large" type="submit">Войти</button>
							</p>

						</form>

					{else}
						<p class="alert">
							Такого проекта нет или он удалён.
						</p>
					{/if}
				</div>
				<div class="col col-mb-12 col-4">&nbsp;</div>
			</div>


		</div> <!-- .container -->
	</body>
</html>