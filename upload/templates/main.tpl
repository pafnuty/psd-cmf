
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>{$project[0].title}</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			background: #ccc url('data:image/GIF;base64,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') no-repeat 50% 50px;
		}
		.layout {
			background-position: 50% 0;
			background-repeat: no-repeat;
			display: block;
			text-align: left;
			text-indent: -9999px;
		}
		.layout img {
			opacity: 0;
			width: 1px;
			height: 1px;
			margin-left: -10px;
		}
	</style>
</head>
<body>
	{set $count = count($project)}
	{set $page = ($.get['page']) ? $.get['page'] : 0}
	{if ($page + 1) ==  $count}
		{set $link}
			/{$project[0].name}/
		{/set}
	{else}
		{set $link}
			/{$project[0].name}/{$page + 1}.html
		{/set}
	{/if}

	<a
		href="{$link|trim}"
		id="layout"
		class="layout"
		data-sort-index="{$project[$page].sort_index}"
		style="background-image: url('/upload/{$project[$page].name}/{$project[$page].src}');"
	><img src="/upload/{$project[$page].name}/{$project[$page].src}" alt=""></a>
	<script>
		var layout = document.getElementById('layout'),
			img = new Image();
		img.src = '/upload/{$project[$page].name}/{$project[$page].src}';
		img.onload = function () {
			layout.style.height = this.height + '.px';
		};
	</script>
</body>
</html>