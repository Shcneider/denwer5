# Denwer 5 (Docker-flavored)
About ten years ago Dmitry Koterov created the excellent project under the name [Denwer](http://denwer.ru).  

Denwer contained all necessary for local development for PHP (Apache, PHP + mods, Mysql, sendmail, etc) 
and in due time it was very popular and demanded.
Over time it, as well as the majority of projects, was abandoned (the latest actual version on the website - PHP 5.3.13), 
and the approaches offered them in the organization of development for PHP strongly became outdated since then. 

This project is an attempt to recreate a complex containing everything you need to develop in PHP, but using modern tools,
while maintaining ease of use and ease of installation (hmm ..).

Denwer 5 contains ready-to-work components:
- nginx (fuck Apache)
- php-fpm 7.2 (apcu, curl, mbstring, mysqli, opcache, pdo_mysql, memcached, redis, zip, xdebug)
- composer
- git
- MySQL 5.6
- adminer (PhpMyAdmin sucks)
- redis 4.0
- memcache 4.6.3
- something is missing? use pull-request! 



## Quick links
- [How to use?](#how-to-use) 
    - [Docker installation](#1-install-docker)
    - [Clone the repository](#2-clone-the-repository)
    - [Run Denwer](#3-run-denwer)
    - [Check Denwer status](#4-check-denwers-status)
    - [Open the project in the browser](#5-open-the-project-in-the-browser)
    - [Stop Denwer](#6-stop-denwer)
- [Denwer structure](#denwer-5-structure)
- [How to place and run php code](#how-to-place-and-run-php-code)
    - [One project, access via IP](#one-project-access-via-ip)
    - [Multiple projects with domains](#multiple-projects-with-domain-support-for-each-project)
- [Transfer Denwer to drive D](#transfer-denwer-to-drive-d)
- [F.A.Q.](#faq)
    - [How to find Denwer external IP](#how-to-find-denwer-external-ip)
    - [How to run Composer?](#how-to-run-composer)
    - [Where is Adminer?](#where-is-adminer)
    - [Where is PhpMyAdmin?](#where-is-phpmyadmin)
    - [How to connect to MySQL, Redis, Memcache from PHP?](#how-to-connect-to-mysql-redis-memcache-from-php)
    - [How to connect to MySQL, Redis, Memcache from PC?](#how-to-connect-to-mysql-redis-memcache-from-pc)
    - [How to enable PHP extension?](#how-to-enable-php-extension)
    - [How to change PHP version?](#how-to-change-php-version)
- [Troubleshooting](#troubleshooting) 







## How to use?

### 1. Install Docker

[Docker Toolbox for Windows](https://docs.docker.com/toolbox/toolbox_install_windows/) - for Windows 7, 8, 10 Home  
```text
Select all optional components. (Full Installation):
+ Docker Compose
+ VirtualBox
+ Kitematic
+ Git for Windows

> Create desktop shortcuts!
```

[Docker for Windows](https://docs.docker.com/docker-for-windows/install/#start-docker-for-windows) - for Windows 10 Professional, Enterprise  
```text
Read the instructions carefully!
You will need to enable support for Hyper-V, after which VMs will not be able to start in VirtualBox
before disabling Hyper-V.
If you are not sure or use VirtualBox - use Docker Toolbox for Windows above.
```

[Docker Toolbox for macOS](https://docs.docker.com/toolbox/toolbox_install_mac/) - for macOS
  



### 2. Clone the repository

**Important for WINDOWS Users**  
```text
Due to Docker Toolbox for Windows’s access restrictions to the host’s file system,
Work is possible only from the current user's home directory!  
For example, you can clone the repository in [C:/Users/$USER/Denwer],
where $USER is your Windows username.
```

To simplify further explanations, we will install Denwer into the `Denwer` folder,
and our Windows username is `User`.  
Full installation path: `C:/Users/User/Denwer`

P.S. There is a way to get around this limitation and install Denwer in an arbitrary directory 
(see [Transfer Denwer to drive D](#transfer-denwer-to-drive-d)).


### 3. Run Denwer
- Launch "Docker Quickstart Terminal" from the desktop.  
**The first launch can be long, because VM is created in VirtualBox**

- Go to the Denwer folder  
```bash
# absolute path is similar to unix format /drive/dir1/dir2/....
cd /c/Users/User/Denwer
# or
cd ~/Denwer
```

- run Denwer (the first start will be long, the custom docker's PHP-image is built)
```bash
docker-compose up -d
```

### 4. Check Denwer's status
- Launch "Docker Quickstart Terminal" from the desktop.  
- Go to the Denwer folder 
```bash
cd /c/Users/User/Denwer
```
- Check status of the containers
```bash
docker-compose ps
```

- All containers are up and running. (State = Up).
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
If something is not working - see [troubleshooting](#troubleshooting)



### 5. Open the project in the browser
- Go to `http://192.168.99.100` in the browser
- We see the output of the test PHP script, which is trying to connect MySQL, Redis and Memcache
```text
/var/www/projects/default/public/index.php:8:string '2018-10-03 12:42:33' (length=19)
/var/www/projects/default/public/index.php:14:int 1538570553
/var/www/projects/default/public/index.php:20:string '1538570553' (length=10)
```
- If nothing works, then Denwer received a different IP address (not 192.168.99.100).  
See [how to find the Denwer's external IP](#how-to-find-denwer-external-ip) 

**Denwer 5 supports multi-project!**  
Read more about [Denwer's multi-project](#how-to-place-and-run-php-code)


### 6. Stop Denwer
- Launch "Docker Quickstart Terminal" from the desktop.  
- Go to the Denwer folder 
```bash
cd /c/Users/User/Denwer
```

- Stop Denwer
```bash
docker-compose down
```

- Check status of the containers
```bash
docker-compose ps
```

- None running container
```text
Name   Command   State   Ports
------------------------------
```


## Denwer 5 structure

- `./etc`  
Here are the configs of components that are forwarded to the inside of the container (for example, nginx.conf, php.ini).   
After configs change you need to restart Denwer!

- `./var`  
Permanent storage for stateful containers (DB).
You can safely delete all files (except the .gitkeep file) inside the `mysql` or` redis` folders, it will reset the database and force
Denwer initialize it empty again (first stop Denwer, then delete files, then start Denwer).

- `./env`  
Environment files that are bound in containers.

- `./home`  
Here are your PHP projects.
(see. [How to place and run php code](#how-to-place-and-run-php-code))

- `./docker-compose.yml`  
Description of all project containers for Docker Compose.




## How to place and run PHP code
Denwer offers two approaches for placing PHP code inside:
- Multiple-projects with domain support for each project
- Single-project with IP access

### One project, access via IP
- Put all your files in `./home/default`
- Your site will be accessible by IP `http://192.168.99.100` (if not working - Denwer got another IP, 
  see [how to find the Denwer's external IP](#how-to-find-denwer-external-ip)  )
- Note that `index.php` should be located in the `public` subfolder, not at the root! (good: `./home/default/public/index.php`)

### Multiple-projects with domain support for each project
- Each folder inside `./home` is a project and is available by the name of the form `*.denwer`
  (for example, the default project `default`, which is located in `./home/default` is available at `http://default.denwer/`)
- You need to add an entry for the `default.denwer` domain to the file `C:\Windows\System32\drivers\etc\hosts` on your PC
```text
192.168.99.100 default.denwer
192.168.99.100 project1.denwer
192.168.99.100 project2.denwer
```
- Instead of `192.168.99.100` use your Denwer external IP 
([how to find the Denwer's external IP](#how-to-find-denwer-external-ip))
- By default, the file `C:\Windows\System32\drivers\etc\hosts` is write-protected. Use google to unlock :)



## Transfer Denwer to drive D
- Stop Denwer
- Switch off default docker machine 
```bash
docker-machine stop default
```
- Copy Denwer to new location:  
    - Old location: `C:\Users\User\Denwer`  
    - New location: `D:\Denwer` (you can choose any location)  
- Open VirtualBox, go to Settings of Docker VM (named default)
- Go to `Shared folders` config and add a new Shared folder:  
    - Path: `D:\Denwer`  
    - Name: `d/Denwer`  
    - Auto mount: yes  
- Note that `Name` must repeat `Path` considering the features of mapping the path of Windows to Linux:
    - `E:\Work\PurpleGames\Denwer` => `e/Work/PurpleGames/Denwer`
    - `D:\SomeFolder\DENWER` => `d/SomeFolder/DENWER`
- Start default Docker Machine
```bash
docker-machine start default
```
- Run Denwer  
If something is not work - see [Troubleshooting](#troubleshooting)


## F.A.Q

### How to find Denwer external IP?
- Launch "Docker Quickstart Terminal" from the desktop.
- Display a list of docker-machines
```bash
docker-machine ls
```
- Look at the IP in the URL column (in my case IP = 192.168.99.100):
```text
NAME      ACTIVE   DRIVER       STATE     URL                         SWARM   DOCKER        ERRORS
default   *        virtualbox   Running   tcp://192.168.99.100:2376           v18.06.1-ce
```
- Go to `http://192.168.99.100`


### How to run Composer?
@todo








































### Where is Adminer?
- Go to `http://192.168.99.100:8080`. (see [MySQL credentials](#how-to-connect-to-mysql-redis-memcache-from-php)).
- If it does not open, then Denwer has another IP ([how to find the Denwer's external IP](#how-to-find-denwer-external-ip))


### Where is PhpMyAdmin?
Nowhere. Use Adminer.


### How to connect to MySQL, Redis, Memcache from PHP?
- See `./home/default/index.php`, is an example to connect for MySQL, Redis and Memcached.
- If example is lost, use credentials:
```text
Mysql:
    host=mysql
    port=3306
    user=root
    pass=root
    
Redis:
    host=redis
    port=6379
    
Memcached:
    host=memcached
    port=11211        
```


### How to connect to MySQL, Redis, Memcache from PC?
@todo


### How to enable PHP extension?
- mkdir `./build/php`
- Clone repository `https://github.com/Shcneider/denwer5-php7.2-docker-image` into `./build/php`
- Add custom extensions in `Dockerfile`
- Edit `docker-compose.yml`: comment `image` section of service `php`, uncomment `build` of service `php`
- Run `docker-compose build`
- Run Denwer
- Your custom php image is ready and work!

### How to change PHP version?
- mkdir `./build/php`
- Clone repository `https://github.com/Shcneider/denwer5-php7.2-docker-image` into `./build/php`
- Change PHP version in `Dockerfile` (first line)
- Edit `docker-compose.yml`: comment `image` section of service `php`, uncomment `build` of service `php`
- Run `docker-compose build`
- Run Denwer
- Your custom php image is ready and work!




## Troubleshooting
@todo

[Русская документация](README_RU.md)