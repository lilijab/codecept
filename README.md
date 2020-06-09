This project is a suite of acceptance and functional tests for a website login page written using Codeception framework.
​
## Prerequisites

* [Composer](https://getcomposer.org/)
​
* [Docker](https://docs.docker.com/get-docker/) (optional)
​
## Set up

* Clone the repository
​
* Run these commands in the project root: 
​
    * Install all the project dependencies:
​
    ```shell script
    composer install
    ```
    * copy the example file and create new .env file that will be used to set environment variables. 
    
    ```shell script
    cp .env.example .env
    ```

* Update `.env` with test data
​

To run with Selenium Standalone Server using Docker run this command before running the tests:
​
```shell script
docker run -d -p 4444:4444 -v /dev/shm:/dev/shm selenium/standalone-chrome:3.141.59-20200525
```
​
If you want to run tests with ChromeDriver install it from [here](https://sites.google.com/a/chromium.org/chromedriver/getting-started) and run: 
​
```shell script
./chromedriver --url-base=/wd/hub
```
> notice: make sure to change the port in `acceptance.suite.yml` to `9515`

# Run
​Tests in this project can be run in two environments - `mobile` and `desktop`.
​

To run all tests: 
```shell script
php vendor/bin/codecept run --env mobile --env desktop
```

> _Add `--steps` to the end of the command to see every step of the running test_
​
## TODO
- [ ] Setup docker-compose environment to run tests in parallel.
- [ ] Create test environments for other browsers (Safari, Firefox).