##  Написать приложение для работы с клиентами и питомцами ветменеджера через апи

- Должен быть предустановлен админ пользователь admin@admin.com, pass: secret (через сидер)
- Должна быть отдельная табличка для сохранения настроек апи (урл и ключ)
- Должны быть настроены связи юзера с этой табличкой
- Делаем авторизацию. После нее человек попадает на домашнюю страницу.
- Через мидлвар делаем проверку (установлены ли у него настройки) если не установлены то кидаем на отдельную страницу где пользователь указывает данные.
- На хоум странице у него есть табличка клиентов ветменеджера (все запросы делать с лимитом 50), т.е мы видим 50 клиентов с ветменеджера.
- Также видим поиск по фио (который тоже находит первые 50 совпадений
- Есть кнопки (Добавить, Просмотреть, Редактировать и Удалить)
- Добавить, Редактировать и Удалить - понятно что делают (при удалении удалить и всех питомцев)
- При нажатии на просмотр мы попадаем в просмотр профиля клиента и там видим грид с питомцами клиента
- У них тоже есть свой круд
- Делаем серверную валидацию через FormRequest'ы
- Также делаем красивое отображение ошибок валидации или других ошибок
- Также во вьюшках используем @include других вьюшек
- Для работы с Api использовать [библиотеку](https://github.com/otis22/vetmanager-rest-api)

### Запуск проекта:
```
git clone https://github.com/Denis-Guselnikov/crm-vetmanager.git
```

- Создать и настроить файл .env из .env.example

- Запуск Миграции: 
```
php artisan migrate
```
- Запуск проекта:
```
./vendor/bin/sail up -d
```
- Что-бы многократно не вводить (vendor/bin/sail) можно создать (alias)Bash:
```
- alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
- sail up -d
```
