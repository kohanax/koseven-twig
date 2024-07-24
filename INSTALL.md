
## Docker
Prepare for
https://hub.docker.com/r/kohanaworld/docker

```shell
Stop 
docker ps -q | xargs --no-run-if-empty docker stop
# Remove containers
docker rm unit

```shell
cd /srv/www/github/kohanax/koseven-twig

docker run --name unit -d -p 80:80 -v $(pwd):/app unit:1.33.0-php7.3
docker exec -it unit bash
```

```shell
chown -R 1000:1000 /app/
usermod -u 1000 unit
cd /app
php -v
composer install
```

## TESTS

```shell
/app# vendor/bin/phpunit --debug
PHPUnit 7.5.20 by Sebastian Bergmann and contributors.
Test 'TwigTest::testLoadingTwig' started
Test 'TwigTest::testLoadingTwig' ended
Test 'TwigTest::testInit' started
Test 'TwigTest::testInit' ended
Test 'TwigTest::testFactory' started
Test 'TwigTest::testFactory' ended
Test 'TwigTest::testRender' started
Test 'TwigTest::testRender' ended
Time: 22 ms, Memory: 6.00 MB

```