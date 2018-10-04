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
You will need to enable support for Hyper-V, after which virtualbucks will not be able to start in VirtualBox
before disabling Hyper-V.
If you are not sure or use VirtualBox - put Docker Toolbox for Windows above.
```

[Docker Toolbox for macOS](https://docs.docker.com/toolbox/toolbox_install_mac/) - for macOS
  


### 2. Clone the repository

To simplify further explanations, we will install Denwer into the `Denwer` folder,
and our Windows username is `User`.  
Full installation path: `C:/Users/User/Denwer`

**Important for WINDOWS Users**  
```text
Due to Docker Toolbox for Windows’s access restrictions to the host’s file system,
Work is possible only from the current user's home directory!  
For example, you can clone the repository in [C:/Users/$USER/Denwer],
where $USER is your Windows username.
```

P.S. There is a way to get around this limitation and install Denwer in an arbitrary directory 
(see [Transfer Denwer to drive D]()).


### 3. Run Denwer





[Русская документация](https://github.com/Shcneider/denwer5/blob/master/README_RU.md)