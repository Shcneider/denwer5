## How to build custom PHP image?
- Clone repository here https://github.com/Shcneider/denwer5-php7.2-docker-image 
- Add custom extensions in `Dockerfile`
- Edit docker-compose.yml: comment `image` section of service `php`, uncomment `build` of service `php`
- Run `docker-compose build`
- Run Denwer
- Your custom php image is ready and work!