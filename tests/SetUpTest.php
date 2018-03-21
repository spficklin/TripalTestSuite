<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../src/SetUp.php';

class SetUpTest extends TestCase
{
    private $set_up;

    /**
     * Initialize.
     */
    protected function setUp()
    {
        $this->set_up = new StatonLab\TripalTestSuite\SetUp();
    }

    /**
     * Assert that the Test Set Up constructs
     */
    public function testAdd()
    {
        $this->assertInstanceOf("StatonLab\TripalTestSuite\SetUp", $this->set_up);
    }

    /**
     * Tests that the setup method creates all expected folders and files exist.
     * We also include a $cleanup variable to signal if the created file should be deleted after (the example env file)
     * Or if it should be left (The tests folder, where this test lives!)
     */
    public function testCreateTestDirectory()
    {
        $dir = __DIR__;

        $set_up = $this->set_up;
        $set_up->run();

        $tests = [
            [$dir."/TripalExampleTest.php", true, "The example test was not created"],
            [$dir."/example.env", true, "The example environment file was not created."],
            [$dir."/../.travis.yml", false, "The travis.yml file was not created"],
            [$dir."/bootstrap.php", false, "The bootstrap file was not copied to test."],
        ];

        foreach ($tests as $file_to_check) {
            $file = $file_to_check[0];
            $cleanup = $file_to_check[1];
            $message = $file_to_check[2];
            $this->assertTrue(file_exists($file), $message);
            if ($cleanup) {
                unlink($file);
            }
        }
    }
}
