This project is a suite of acceptance and functional tests for a website login page written using Codeception framework.

## Prerequisites

Install [Composer](https://getcomposer.org/)

_Optional_: install [Docker](https://docs.docker.com/get-docker/)

## Set up

1. Clone the repository

2. Run these commands in the project root: 

`composer install ` to install all the project dependencies

`cp .env.example .env` to will copy the example file and create new .env file that will be used to set environment variables. 

3. Update .env with test data

To run with Selenium Standalone Server using Docker run this command before running the tests:

`docker run -d -p 4444:4444 -v /dev/shm:/dev/shm selenium/standalone-chrome:3.141.59-20200525`

If you want to run tests with ChromeDriver install it from [here](https://sites.google.com/a/chromium.org/chromedriver/getting-started) and run `./chromedriver --url-base=/wd/hub` before running the tests

## Run

Tests in this project can be run in two environments - `mobile` and `desktop`.

To run desktop tests: `php vendor/bin/codecept run --env desktop`

To run mobile tests: `php vendor/bin/codecept run --env mobile`

_Add `--steps` to the end of the command to see every step of the running test_ 
