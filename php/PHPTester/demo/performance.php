<?php

/*
  performance.php
  A simple introduction to performance assertions in PHPTester
  For the actual testing framework, please refer to `class.phptester.php`
*/

require '../class.phptester.php';
$test = new PHPTester;
$test->describe("The \"sum\" function", function () {
  global $test;
  $test->it("should return the correct sum of all terms from 1 to \$n inclusive given the value of \$n", function () {
    global $test;
    $test->assert_equals(sum(1), 1);
    $test->assert_equals(sum(2), 3);
    $test->assert_equals(sum(3), 6);
    $test->assert_equals(sum(4), 10);
    $test->assert_equals(sum(5), 15);
    $test->assert_equals(sum(6), 21);
    $test->assert_equals(sum(7), 28);
    $test->assert_equals(sum(8), 36);
    $test->assert_equals(sum(9), 45);
    $test->assert_equals(sum(10), 55);
    $test->assert_equals(sum(100), 5050);
    $test->assert_equals(sum(1000), 500500);
  });
  $test->it("should have an optimal performance", function () {
    global $test;
    $test->assert_max_execution_time(function () {
      for ($i = 0; $i < 100000; $i++) {
        sum(1000);
      }
    }, 30);
  });
});
$test->describe("The \"iterative_sum\" function", function () {
  global $test;
  $test->it("should return the correct sum of all terms from 1 to \$n inclusive given the value of \$n", function () {
    global $test;
    $test->assert_equals(iterative_sum(1), 1);
    $test->assert_equals(iterative_sum(2), 3);
    $test->assert_equals(iterative_sum(3), 6);
    $test->assert_equals(iterative_sum(4), 10);
    $test->assert_equals(iterative_sum(5), 15);
    $test->assert_equals(iterative_sum(6), 21);
    $test->assert_equals(iterative_sum(7), 28);
    $test->assert_equals(iterative_sum(8), 36);
    $test->assert_equals(iterative_sum(9), 45);
    $test->assert_equals(iterative_sum(10), 55);
    $test->assert_equals(iterative_sum(100), 5050);
    $test->assert_equals(iterative_sum(1000), 500500);
  });
  $test->it("should add the numbers from 1 to \$n iteratively and not use the formula", function () {
    global $test;
    $test->assert_min_execution_time(function () {
      for ($i = 0; $i < 100000; $i++) {
        iterative_sum(100);
      }
    }, 800);
  });
});
$test->describe("The \"recursive_sum\" function", function () {
  global $test;
  $test->it("should return the correct sum of all terms from 1 to \$n inclusive given the value of \$n", function () {
    global $test;
    $test->assert_equals(recursive_sum(1), 1);
    $test->assert_equals(recursive_sum(2), 3);
    $test->assert_equals(recursive_sum(3), 6);
    $test->assert_equals(recursive_sum(4), 10);
    $test->assert_equals(recursive_sum(5), 15);
    $test->assert_equals(recursive_sum(6), 21);
    $test->assert_equals(recursive_sum(7), 28);
    $test->assert_equals(recursive_sum(8), 36);
    $test->assert_equals(recursive_sum(9), 45);
    $test->assert_equals(recursive_sum(10), 55);
    $test->assert_equals(recursive_sum(100), 5050);
    $test->assert_equals(recursive_sum(1000), 500500);
  });
  $test->it("should add the numbers from 1 to \$n recursively (not iteratively) and not use the formula", function () {
    global $test;
    $test->assert_min_execution_time(function () {
      for ($i = 0; $i < 100000; $i++) {
        recursive_sum(100);
      }
    }, 2000);
  });
});

function sum($n) {
  return $n * ($n + 1) / 2;
}
function iterative_sum($n) {
  $result = 0;
  for ($i = 1; $i <= $n; $i++) {
    $result += $i;
  }
  return $result;
}
function recursive_sum($n) {
  return $n === 1 ? 1 : $n + recursive_sum($n - 1);
}

?>
