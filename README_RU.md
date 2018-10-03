# Denwer 5 (со вкусом Docker)
Лет десять назад Дмитрий Котеров создал отличный проект под названием [Denwer 3](http://denwer.ru).
Денвер содержал в себе все необходимое, для локальной разработки на PHP (Apache, PHP, Mysql, sendmail, etc) и в свое время был очень популярн и востребован.
Со временем он, как и большинство проектов, был заброшен (последняя актуальная версия на сайте - PHP 5.3.13), а подходы в организации разработки на PHP с тех пор сильно устарели.
Данный проект - попытка создать комплекс, содержащий все необходимое, но используя современные инструменты, сохранив при этом удобство использования и простоту установки.

Denwer 5 содержит в себе готовые для работы компоненты:
- nginx (к черту Apache)
- php-fpm 7.2 (apcu, mbstring, mysqli, opcache, pdo_mysql, memcached, redis)
- composer
- MySQL 5.6
- adminer (PMA слишком жирный и неповоротливый)
- redis 4.0
- memcache 4.6.3
- чего то не хватает? Шлите pull-request


## Как использовать?

### Для начала установите Docker (это просто!)

Для Windows 7,8,10 Home  
[Docker Toolbox for Windows](https://docs.docker.com/toolbox/toolbox_install_windows/) 
```text
В процессе установки Docker Toolbox for Windows выберите к установке все опциональные компоненты (Full Installation):
+ Docker Compose
+ VirtualBox
+ Kitematic
+ Git for Windows


Создайте ярлыки на рабочем столе!
```

Для Windows 10 Professional, Enterprise  
[Docker for Windows](https://docs.docker.com/docker-for-windows/install/#start-docker-for-windows) 
```text
Внимательно прочитайте инструкцию. 
Вам будет необходимо включить поддержку Hyper-V, после чего запуск виртуалок в VB, например, станет невозможен до отключения Hyper-V.  
```

macOS нажимают сюда  
[Docker Toolbox for macOS](https://docs.docker.com/toolbox/toolbox_install_mac/)   




### Клонируйте этот репозиторий

**!!! ВАЖНАЯ ИНФОРМАЦИЯ для пользователей WINDOWS  !!!**  
```text
Из-за ограничений доступа Docker Toolbox for Windows к файловой системе хост-машины, работа возможна только из домашней директории текущего пользователя!
Например, можно склонировать репозиторий в [C:/Users/$USER/Denwer], где $USER - имя вашего пользователя в Windows.
```

Для упрощения дальнейших объяснений мы будем устанавливать Denwer в папку `Denwer`, 
а имя нашего пользователя  в Windows будет `User`.  
Полный путь инсталяции: `C:/Users/User/Denwer`

P.S. Существует способ обойти данное ограничение и установить Denwer в произвольную директорию, этим мы займемся немного позже (см. Перенос Denwer на диск D).



### Описание внутренней структуры
- `./build`  
Здесь находятся Dockerfiles кастомных контейнеров, которые собираются "под себя".

- `./config`  
Здесь лежат конфиги компонентов, которые пробрасываются внутрь контейнра (например nginx.conf).   
После изменений в конфигах нужно перезапустить Denwer!

- `./data`  
Постоянное хранилище для stateful-контейнеров (БД).
Можно смело удалять все файлы (кроме файла .gitkeep) внутри папок `mysql` или `redis`, это обнулит БД и заставит
Denwer инициализировать ее пустой заново (сначала выключаем Denwer, потом чистим, потом включаем).

- `./env`  
Файлы окружениия, которые пробрасываются внутрь контейнеров.

- `./projects`  
Здесь лежат ваши проекты на PHP. (см. Как запустить PHP код в Denwer?)

- `./docker-compose.yml`  
Описание всех контейнеров комплекса для Docker Compose



### Как запустить PHP код в Denwer?
Todo

### Запуск Denwer
- Запустите "Docker Quickstart Terminal" с рабочего стола.  
**Первый запуск может быть долгим, т.к. создается виртуалка в VirtualBox**

- Перейдите в папку со склонированным репозиторием 
```bash
# абсолютный путь имеет схожий с *nix формат /drive/dir1/dir2/....
cd /c/Users/User/Denwer
# или
cd ~/Denwer
```

- Запустим Denwer
```bash
# запустим Denwer!
docker-compose up -d
```

### Проверка состояния Denwer
- Запустите "Docker Quickstart Terminal" с рабочего стола. 
- Перейдите в папку со склонированным репозиторием
```bash
cd /c/Users/User/Denwer
```
- Проверим состояние контейнеров
```bash
docker-compose ps
```

- Видим что все контейнеры находятся в рабочем состоянии (State = Up).
```text
      Name                    Command               State           Ports
----------------------------------------------------------------------------------
denwer_adminer     entrypoint.sh docker-php-e ...   Up      0.0.0.0:8080->8080/tcp
denwer_memcached   docker-entrypoint.sh memcached   Up      11211/tcp
denwer_mysql       docker-entrypoint.sh --inn ...   Up      3306/tcp, 33060/tcp
denwer_nginx       nginx -g daemon off;             Up      0.0.0.0:80->80/tcp
denwer_php         docker-php-entrypoint php-fpm    Up      9000/tcp
denwer_redis       docker-entrypoint.sh redis ...   Up      6379/tcp
```

### Остановка Denwer

- Запустите "Docker Quickstart Terminal" с рабочего стола. 
- Перейдите в папку со склонированным репозиторием
```bash
cd /c/Users/User/Denwer
```

- Остановим Denwer
```bash
docker-compose down
```

- Проверим состояние контейнеров
```bash
docker-compose ps
```

- Ни одного запущеного контейнера =)
```text
Name   Command   State   Ports
------------------------------
```

### Перенос Denwer на диск D
todo





### Проблемы и их решения
todo






