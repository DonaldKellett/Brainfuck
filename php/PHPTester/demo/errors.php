<?php

/*
  errors.php
  A simple introduction to the error-handling methods in PHPTester and when/how to use them
  For the actual testing framework, please refer to `class.phptester.php`
*/

require '../class.phptester.php';
$test = new PHPTester;
$test->describe("The Advanced Multiply Function", function () {
  global $test;
  $test->it("should multiply two numbers properly and return the correct value", function () {
    global $test;
    $test->assert_equals(advanced_multiply(3, 5), 15);
    $test->assert_equals(advanced_multiply(2, 4), 8);
    $test->assert_equals(advanced_multiply(3.5, 3), 10.5);
    $test->assert_equals(advanced_multiply(1.2, 1.1), 1.32);
  });
  $test->it("should throw a TypeError for incorrect data types passed in", function () {
    global $test;
    $test->expect_error("Expected TypeError not thrown", function () {
      advanced_multiply("hello", 3);
    });
    $test->expect_error("Expected TypeError not thrown", function () {
      advanced_multiply(14, array(1, 2, 3));
    });
    $test->expect_error("Expected TypeError not thrown", function () {
      advanced_multiply(198, false);
    });
    $test->expect_error("Expected TypeError not thrown", function () {
      advanced_multiply(true, false);
    });
  });
  $test->it("should not throw an error for valid inputs", function () {
    global $test;
    $test->expect_no_error("Unexpected error thrown", function () {
      advanced_multiply(-3, -5);
    });
    $test->expect_no_error("Unexpected error thrown", function () {
      advanced_multiply(-7.89, 19.45);
    });
  });
});

function advanced_multiply($a, $b) {
  if ((!is_int($a) && !is_float($a)) || (!is_int($b) && !is_float($b))) throw new TypeError("\$a and \$b must be numbers!");
  return $a * $b;
}

?>
