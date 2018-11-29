Пакет отслеживает количество поисков по определнному поисковому запросу и  позволяет назначить на самые популярные кастомную ссылку 

## Установка
Выполняем
```json
    composer require shpik/search-log
```

Добавляем SearchLogProvider в массив ServiceProviders в config/app.php
```php
       Shpik\SearchLog\SearchLogProvider::class,
```

Выполняем миграцию таблиц
```json
   php artisan migrate --path=vendor/shpik/search-log/src/migrations
```

##Использование
```php
       $searchLog = SearchLog::processQuery($query);
```
processQuery() принимает поисковую строку в формате string. Сохраняет поисковый запрос, или инкремитирует уже существующий. В случае если на заданый поисковый запрос настроеный переход на кастомную урлу, то вернет модель SearchLog у которой в ->url ьудет лежать урла для перехода, если нет то вернет null.  

```php
       $searchLog = SearchLog::getSearchLog($query);
```
getSearchLog() принимает поисковую строку в формате string. НЕ сохраняет поисковый запрос И НЕ инкремитирует уже существующий. Используеться что бы найти кастомную урлу для данного поискового запроса. Если она есть возвращает модель SearchLog, нет - null

