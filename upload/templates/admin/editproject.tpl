<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>{$project[0].title} - Редактирование</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="/templates/admin/css/selectize.css">
		<link rel="stylesheet" href="/templates/css/style.css">
	</head>

<body>

<div class="container">
	<div class="content">
		<div class="col col-mb-12">
			<h1 class="d-ib mb0">{$project[0].title} - Редактирование</h1> <a href="/admin/index.php" class="btn ml10 mb15">Назад</a>
			<hr>
		</div>
	</div>
	<div class="content">
		<div class="col col-mb-12">
			<div class="content mb30">
				<div class="col col-mb-12 col-6">
					<form id="fileupload" action="/admin/upload.php" method="post" enctype="multipart/form-data">
						<input type="hidden" name="project" value="{$project[0].name}">
						<span class="btn btn-success fileinput-button">
							<i class="glyphicon glyphicon-plus"></i>
							<span>Выбрать файлы...</span>

							<input type="file" name="files[]" multiple>
						</span>
						<button class="btn btn-green">Загрузить</button>
					</form>
				</div>
				<div class="col col-mb-12 col-6">
					<div class="progress">
						<div class="bar"></div >
						<div class="percent">0%</div >
					</div>
				</div>
			</div>
			<form class="ajaxform" action="/admin/save.php" method="post">
				<input type="hidden" name="project[name]" value="{$project[0].name}">
				<input type="hidden" name="add_new" value="y">
				<div id="status"></div>
			</form>

			<form class="mt30 ajaxform" action="/admin/save.php" method="post">
				<input type="hidden" name="project[name]" value="{$project[0].name}">
				<input type="hidden" name="edit" value="y">
				<ul class="project-list">
					{foreach $project as  $key => $el }
						{if $el.id}
							<li class="clearfix">
								<div class="col col-mb-6 col-2">
									<img src="/upload/{$el.name}/thumbnail/{$el.src}" alt="{$el.title}" width="100">
									<input type="hidden" name="image[{$el.id}][name]" value="{$el.src}">
								</div>
								<div class="col col-mb-6 col-8">
									Сортировка: <input class="input input-small" type="text" name="image[{$el.id}][sort_index]" value="{$el.sort_index}">
									<select name="image[{$el.id}][type]" class="styler styler-small">
										<option value="1" {if $el.type == 1}selected{/if}>Публиковать</option>
										<option value="2" {if $el.type == 2}selected{/if}>Не публиковать</option>
									</select>
									<div class="del-item">
										<input class="checkbox" type="checkbox" name="delete[{$el.id}]" value="{$el.id}" id="del_{$el.id}"><label for="del_{$el.id}"><span></span> Удалить</label>
									</div>
								</div>
							</li>
						{else}
							<li class="clearfix">
								<p class="alert mt0">Мактов пока нет</p>
							</li>
							{break}
						{/if}
					{foreachelse}
						<li class="clearfix">
							<p class="alert mt0">Мактов пока нет</p>
						</li>
					{/foreach}
				</ul>
				<hr>
				<input class="btn" type="submit" name="submit" value="Сохранить зменения">
			</form>
		</div>
	</div>

</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<script src="/templates/admin/js/jquery.selectize.min.js"></script>
<script src="/templates/admin/js/jquery.form.min.js"></script>
<script src="/templates/admin/js/main.js"></script>

</body>
</html>
