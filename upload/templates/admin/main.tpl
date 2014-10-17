<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Управление проектами</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="/templates/css/style.css">
	</head>

	<body class="ov-s">

		<div class="container">
			<div class="content">
				<div class="col col-mb-12">
					<h1 class="d-ib mb0">Список проектов</h1> <a href="?do=add" class="btn ml10 mb15">Добавить новый</a>
					<hr>
				</div>
			</div> <!-- .content -->
		</div> <!-- .container -->

		<div class="container">
			<div class="content">
				<div class="col col-12">
					<ul class="project-list">
						{foreach $projects['projects'] as  $key => $el }
							<li>
								<div class="content">
									<div class="col col-mb-12 col-8">
										<h4 class="m0 d-ib"><span title="ID проекта" class="text-muted mr10">{$el.id}</span> {$el.title}</h4>
										<div class="d-ib ml20 pl-hide">Отображаемые макеты</div>
									</div>
									<div class="col col-mb-12 col-4 ta-right">
										<a href="?do=edit&name={$el.name}" class="btn btn-small btn-edit">редактировать</a>
										<a href="?do=edit&name={$el.name}" class="btn btn-small btn-red btn-delete">удалить</a>
									</div>
								</div>
								<div class="project-images">
									{foreach $el.images as $key => $img }
										<a href="/{$el.name}/{$key}.html" target="_blank"><img src="/upload/{$el.name}/thumbnail/{$img.name}" alt="{$img.name}"></a>
									{/foreach}
								</div>
							</li>
						{/foreach}
						{$pagination}
					</ul>
				</div> <!-- .col col-12 -->
			</div> <!-- .content -->
		</div> <!-- .container -->


		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="/templates/admin/js/main.js"></script>

	</body>
</html>
