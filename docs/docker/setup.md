## Local setup with Docker

In order to make contribution and bug reporting easier, we have recently Dockerized this package so that contributors can setup, run tests and view demo locally in just a few steps.
You can clone this repository on your computer. Assuming you have docker desktop configured in your computer, you just have to run the following command:


If Docker Desktop is not installed on your computer, you can setup Docker Desktop from th official docs [Docker Desktop](https://docs.docker.com/desktop/)


    docker compose up -d 


On successful execution of the above command, you will have a Docker container `localstates` and `nginx` configuration too. You can access demo by visiting the following url

[localstates.test](http://localstates.test)

With the following command, we can enter our container.

    docker compose exec localstates bash

In order to verify contribution align with php unit tests and php stan standards, you have to execute following commands

vendor/bin/phpunit

vendor/bin/phpstan analyse --level=8 src/

vendor/bin/phpstan analyse --level=5 tests/

## Docker Images

We have uploaded docker images for various version of the php. If you find bug related to specific version of the php, then you can report the bug or contribute on bug
fixing by using respective docker image in your setup.

In the `Dockerfile`, you can update the following line with an specific Docker image.

    FROM sagautam5/localstates_8.3:v1.0

As you can see,the above image is for PHP 8.3. We have the following Docker images for the respective PHP versions.

- [sagautam5/localstates_7.1:v1.0](https://hub.docker.com/r/sagautam5/localstates_7.1)
- [sagautam5/localstates_7.2:v1.0](https://hub.docker.com/r/sagautam5/localstates_7.2)
- [sagautam5/localstates_7.3:v1.0](https://hub.docker.com/r/sagautam5/localstates_7.3)
- [sagautam5/localstates_7.4:v1.0](https://hub.docker.com/r/sagautam5/localstates_7.4)
- [sagautam5/localstates_8.0:v1.0](https://hub.docker.com/r/sagautam5/localstates_8.0)
- [sagautam5/localstates_8.1:v1.0](https://hub.docker.com/r/sagautam5/localstates_8.1)
- [sagautam5/localstates_8.2:v1.0](https://hub.docker.com/r/sagautam5/localstates_8.2)
- [sagautam5/localstates_8.3:v1.0](https://hub.docker.com/r/sagautam5/localstates_8.3)

After updating `Dockerfile`, you have to recreate the container with the following command:

    docker compose up -d --force-recreate

Now, it's ready with an specific version of PHP