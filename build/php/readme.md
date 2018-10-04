## How to build custom image?
- Clone repository here https://github.com/Shcneider/denwer5-php7.2-docker-image 
- Add custom extensions, changes and etc into `Dockerfile`
- Edit docker-compose.yml: comment `image` section for service `php`, uncomment `build` for service `php`
- Run `docker-compose build`
- Run Denwer
- Your custom php image is ready and work!