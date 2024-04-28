## Local setup with docker

In order to make contribution and bug reporting easier, we have recently dockerized this package so that contributors can setup, run tests and view demo locally in just few steps.
You can clone this repository in your computer. Assuming you have docker desktop configured in your computer, you just have to run following command.


If docker desktop is not installed in your computer, You can setup docker desktop from official docs [Docker Desktop](https://docs.docker.com/desktop/)


    docker compose up -d 


On successful execution of above command, you will have a docker container `localstates` and `nginx` configuration too. You can access demo by visiting following url

[localstates.test](http://localstates.test)

With following command, we can enter to our container.

    docker compose exec localstates bash

In order to verify contribution align with php unit tests and php stan standards, you have to execute following commands

vendor/bin/phpunit

vendor/bin/phpstan analyse --level=9

## Docker Images

We have uploaded docker images for various version of the php. If you find bug related to specific version of the php, then you can report the bug or contribute on bug
fixing by using respective docker image in your setup.

In the docker file, you can update following line with specific docker image.

    FROM sagautam5/localstates_8.3:v1.0

As you can see, Above image is for php 8.3. We have the following docker images for respective php versions.

- [sagautam5/localstates_7.1:v1.0](https://hub.docker.com/r/sagautam5/localstates_7.1)
- [sagautam5/localstates_7.2:v1.0](https://hub.docker.com/r/sagautam5/localstates_7.2)
- [sagautam5/localstates_7.3:v1.0](https://hub.docker.com/r/sagautam5/localstates_7.3)
- [sagautam5/localstates_7.4:v1.0](https://hub.docker.com/r/sagautam5/localstates_7.4)
- [sagautam5/localstates_8.0:v1.0](https://hub.docker.com/r/sagautam5/localstates_8.0)
- [sagautam5/localstates_8.1:v1.0](https://hub.docker.com/r/sagautam5/localstates_8.1)
- [sagautam5/localstates_8.2:v1.0](https://hub.docker.com/r/sagautam5/localstates_8.2)
- [sagautam5/localstates_8.3:v1.0](https://hub.docker.com/r/sagautam5/localstates_8.3)

After updating docker file, you have recreate the container with following command.

    docker compose up -d --force-recreate

Now, it's ready with specific version of php