[![Build Status](https://travis-ci.org/statonlab/TripalTestSuite.svg?branch=master)](https://travis-ci.org/statonlab/TripalTestSuite) [![DOI](https://zenodo.org/badge/123318173.svg)](https://zenodo.org/badge/latestdoi/123318173)

TripalTestSuite is a composer package that handles
common test practices such as bootstrapping Drupal
before running the tests.

### Installation
Within your Drupal module path (e,g sites/all/my_module), run the following.
```bash
composer require statonlab/tripal-test-suite --dev
```

#### Automatic Set Up
This module will automatically configure your tests directory,
PHPUnit bootstrap files, and travis continuous integration file
as well as provide an example test to get you started. 

From your module's directory, execute:
```bash
./vendor/bin/tripaltest init MODULE_NAME 
```

This will 
- Set up the testing framework by creating the tests directory, phpunit.xml and tests/bootstrap.php
- Create an example test in tests/ExampleTest.php
- Create an example `.env` file.
- Create `.travis.yml` configured to use a tripal3 docker container to run your tests  

You can now write tests in your `tests` folder.  To enable continuous
integration testing, push your module to github and [enable Travis CI](https://travis-ci.org/).

### Usage

#### TripalTestCase
Test classes should extend the TripalTestCase class. Once extended, bootstrapping
Drupal and reading your `.env` file is done automatically when the first test is run.

```php
namespace Tests;

use StatonLab\TripalTestSuite\TripalTestCase;

class MyTest extends TripalTestCase {
}
```

### Using DB Transactions
Using DB transactions, cleans up the database after every test by rolling back
the database to the original state before the test started.

To activate DB Transactions, simply add the DBTransaction trait to your test class:

```php
namespace Tests;

use StatonLab\TripalTestSuite\TripalTestCase;
use StatonLab\TripalTestSuite\DBTransaction;

class MyTest extends TripalTestCase {
	use DBTransaction;
}
```

The trait will automatically activate DB transactions and rollback the database when the test is finished.

**NOTE**: If the code you are testing requires a transaction, Postgres
will fail since it does not support nested transactions.

### Environment Variables
You can specify the Drupal web root path in `tests/.env`.
```bash
# tests/.env
DRUPAL_ROOT=/var/www/html
```

This allows TripalTestSuite to bootstrap the entire Drupal framework and make it available in your tests.

## License
TripalTestSuite is licensed under GPLv3.
