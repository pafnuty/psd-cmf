# ПСД CMF - ростая система для показа макетов дизайна непосредственно в браузере.

## Возможности
- **Удобный показ дизайна заказчику.** Все скриншоты показываются на полный экран и создаётся впечатление, что просматриваешь готовый сайт, а не каринку. При клике на любое место страницы происходит переход к следующему макету, если больше макетов нет - переходит к первому.
- Доступ к проекту по пин-коду.
- Удобное добавление проектов и изображений в проект.
- Высокая скорость работы.

## Установка
1. Залить содержимое папки **upload** в корень сайта.
2. Выставить права на запись (777) для папок **cache** и **upload**.
3. Внести данные для подключения к БД в файл **/system/db_config.php**.
4. Выполнить запрос в БД:
```sql
CREATE TABLE IF NOT EXISTS `images` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `element_id` int(6) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(11) NOT NULL DEFAULT '1',
  `sort_index` int(5) NOT NULL DEFAULT '500',
  UNIQUE KEY `id` (`id`),
  KEY `element_id` (`element_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `user_group` tinyint(2) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

```

5. Создать нового пользователя через форму на странице **/register.php**.
6. Для запрета регистрации новых пользователей рааскомментировать указанную строку в файле **/register.php**. Если этого не сделать - кто угодно сможет регистрироваться и управлять проектами.
7. Зайти в админку **/admin/index.php** и начинать работать с проектами.
