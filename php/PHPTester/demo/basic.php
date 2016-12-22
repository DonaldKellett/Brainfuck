<?php

/*
  basic.php
  A basic demo on the usage of core PHPTester methods
  For the actual testing framework, please refer to `class.phptester.php`
*/

// 1. Require the 'class.phptester.php` file to start using PHPTester
require '../class.phptester.php';

// 2. Create a new instance of PHPTester
$test = new PHPTester;

// 3. Write your test cases
$test->describe("The Multiply Function", function () {
  global $test;
  $test->it("should exist as \"multiply\"", function () {
    global $test;
    $test->expect(function_exists('multiply'), "Function \"multiply\" is not defined");
  });
  $test->it("should multiply two numbers together", function () {
    global $test;
    $test->assert_equals(multiply(3, 5), 15, "Three times five should be fifteen");
    $test->assert_equals(multiply(2, 4), 8);
    $test->assert_equals(multiply(9, 9), 81);
    $test->assert_equals(multiply(12, 11), 132);
  });
  $test->it("should be commutative (i.e. order of multiplication does not matter)", function () {
    global $test;
    $test->assert_equals(multiply(5, 3), 15);
    $test->assert_equals(multiply(4, 2), 8);
    $test->assert_equals(multiply(11, 12), 132);
    $test->assert_equals(multiply(12, 8), 96);
    $test->assert_equals(multiply(8, 12), 96);
  });
  $test->it("should do multiplication and not addition", function () {
    global $test;
    $test->assert_not_equals(multiply(3, 5), 8, "Three times five is not eight, check your code");
    $test->assert_not_equals(multiply(12, 11), 23);
    $test->assert_not_equals(multiply(9, 9), 18);
  });
});

// 4. Program your code/algorithm to be tested
function multiply($a, $b) {
  return $a * $b;
}

?>
