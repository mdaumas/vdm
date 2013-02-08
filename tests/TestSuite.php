<?php

use Symfony\Component\Finder\Finder;

/**
 * Test file selection for project
 */
class TestSuite extends PHPUnit_Framework_TestSuite
{

    /**
     * Called by PHPInit Framework to select test files
     *
     * @return \TestSuite
     */
    public static function suite()
    {
        $suite = new TestSuite();
        $finder = new Finder();

        // ---------- COMMENT OUT TO TEST A SPECIFIC FILE ----------
        // $suite->addTestFile('../src/<yourbundle>/DefaultBundle/Tests/Controller/SomeControllerTest.php');
        // return $suite;
        // ----------

        echo "Searching for test cases ...\n\n";
        foreach ($finder->files()->in('../src/')->name('*Test.php') as $file) {
            $pathName = str_replace('\\', '/', $file->getPathName());
            if (preg_match('%/Tests/[\w-/]+Test.php%i', $pathName)) {
                echo 'Adding test : ' . $pathName . "\n";
                $suite->addTestFile($pathName);
            }
        }
        echo "\n";

        return $suite;
    }

}