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
				<div class="col col-mb-12 col-3">&nbsp;</div>
				<div class="col col-mb-12 col-6 ta-center">
						<p class="alert">
						{if $project.text}
							{$project.text}
						{else}
							Такого проекта не существует, или он удалён.
						{/if}
						</p>
				</div>
				<div class="col col-mb-12 col-3">&nbsp;</div>
			</div>
		</div> <!-- .container -->
	</body>
</html>