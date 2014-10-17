<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Добавление нового проекта</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="/templates/admin/css/selectize.css">
		<link rel="stylesheet" href="/templates/css/style.css">
	</head>

<body>

<div class="container">
	<div class="content">
		<div class="col col-mb-12">
			<h1 class="d-ib mb0">Добавление нового проекта</h1> <a href="/admin/index.php" class="btn ml10 mb15">Назад</a>
			<hr>
		</div>
	</div>
	<div class="content">
		<div class="col col-mb-12">

			<form class="addProject" action="/admin/save.php" method="post">
				<input type="hidden" name="addproject" value="y">
				<div class="clearfix">

					<div class="col-mb-12 col-12 center-block addStatus ta-center">

					</div>
					<div class="col col-mb-12 col-5 col-dt-4 form-label">
						Имя проекта (латиница):
					</div>
					<div class="col col-mb-12 col-7 col-dt-8 form-control">
						<input class="input" type="text" name="project[name]" placeholder="Имя (латиница)" required>
					</div>
				</div>
				<div class="content">
					<div class="col col-mb-12 col-5 col-dt-4 form-label">
						Заголовок проекта (title браузера)
					</div>
					<div class="col col-mb-12 col-7 col-dt-8 form-control">
						<input class="input" type="text" name="project[title]" placeholder="Заголовок проекта" required>
					</div>
				</div>
				<div class="content">
					<div class="col col-mb-12 col-5 col-dt-4 form-label">
						Пароль проекта (для защиты от лишних глаз)
						<b>Внимание!</b> Не забывайте пароль - его нельзя сменить через веб-интерфейс, а в БД он хранится в зашифрованном виде.
					</div>
					<div class="col col-mb-12 col-7 col-dt-8 form-control">
						<input class="input" type="text" name="project[pass]" placeholder="Пароль проекта">
					</div>
				</div>
				<div class="content">
					<div class="col col-mb-12 col-5 col-dt-4 form-label">
						&nbsp;
					</div>
					<div class="col col-mb-12 col-7 col-dt-8 form-control">
						<p>
							<input class="btn" type="submit" value="Создать проект">
						</p>
					</div>
				</div>

			</form>
		</div>
	</div>

</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="/templates/admin/js/jquery.form.min.js"></script>
<script src="/templates/admin/js/main.js"></script>

</body>
</html>
