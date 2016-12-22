<?php

/*
  random.php
  A simple introduction to random testing methods in PHPTester
  For the actual testing framework, please refer to `class.phptester.php`
*/

require '../class.phptester.php';
$test = new PHPTester;
$test->describe("The Multiply Function", function () {
  global $test;
  $test->it("should work for some basic fixed tests", function () {
    global $test;
    $test->assert_equals(multiply(1, 1), 1);
    $test->assert_equals(multiply(2, 4), 8);
    $test->assert_equals(multiply(3, 5), 15);
    $test->assert_equals(multiply(21, 23), 483);
  });
  $test->it("should work for the same tests (and more) executed in random order", function () {
    // NOTE: The `randomize` method in PHPTester is best used to randomize the order of execution of a set of test cases which can be used to prevent cheat solutions from other developers from passing
    global $test;
    foreach ($test->randomize([function () {
      global $test;
      $test->assert_equals(multiply(1, 1), 1);
    }, function () {
      global $test;
      $test->assert_equals(multiply(2, 4), 8);
    }, function () {
      global $test;
      $test->assert_equals(multiply(3, 5), 15);
    }, function () {
      global $test;
      $test->assert_equals(multiply(21, 23), 483);
    }, function () {
      global $test;
      $test->assert_equals(multiply(11, 14), 154);
    }, function () {
      global $test;
      $test->assert_equals(multiply(13, 15), 195);
    }, function () {
      global $test;
      $test->assert_equals(multiply(132, 497), 65604);
    }]) as $testcase) $testcase();
  });
  $test->it("should work for random tests", function () {
    global $test;
    // Reference Solution - always assign the function to a local variable to prevent the cheat solution from accessing it
    $solution = function ($a,$b) {
      return $a * $b;
    };
    for ($i = 0; $i < 100; $i++) {
      $a = $test->random_number();
      $b = $test->random_number();
      $expected = $solution($a, $b); // Always compute your expected solution first - otherwise, the cheater's algorithm may be able to modify the input before it is passed to your function
      $actual = multiply($a, $b);
      $test->assert_equals($actual, $expected, "Expected $a times $b to equal $expected");
    }
  });
});
$test->describe("The \"greet\" function", function () {
  global $test;
  $test->it("should work for some fixed tests", function () {
    global $test;
    $test->assert_equals(greet("Donald"), "Hello Donald");
    $test->assert_equals(greet("Ella"), "Hello Ella");
    $test->assert_equals(greet("Ivan"), "Hello Ivan");
    $test->assert_equals(greet("Dennis"), "Hello Dennis");
    $test->assert_equals(greet("Charles"), "Hello Charles");
  });
  $test->it("should work for random tests", function () {
    global $test;
    // Reference Solution
    $solution = function ($n) {
      return "Hello $n";
    };
    for ($i = 0; $i < 100; $i++) {
      $name = $test->random_token(); // Returns a randomly generated string (length 10 by default if not specified)
      $expected = $solution($name);
      $actual = greet($name);
      $test->assert_equals($actual, $expected);
    }
  });
});

function multiply($x, $y) {
  return $x * $y;
}
function greet($name) {
  return "Hello $name";
}

?>
