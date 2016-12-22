<?php

/*
  numbers.php
  A simple introduction to number assertions in PHPTester
  For the actual testing framework, please refer to `class.phptester.php`
*/

require '../class.phptester.php';
$test = new PHPTester;
$test->describe("The \"circle_area\" function", function () {
  global $test;
  $test->it("should return the area of a circle given its radius", function () {
    global $test;
    $test->assert_fuzzy_equals(circle_area(1), M_PI); // Default Range: 1e-12 (almost exact)
    $test->assert_fuzzy_equals(circle_area(1), M_PI, 1e-9); // Pretty accurate
    $test->assert_fuzzy_equals(circle_area(1), M_PI, 1e-6); // Close-ish
    $test->assert_fuzzy_equals(circle_area(3), 9 * M_PI);
    $test->assert_fuzzy_equals(circle_area(3), 9 * M_PI, 1e-9);
    $test->assert_fuzzy_equals(circle_area(3), 9 * M_PI, 1e-6);
    $test->assert_fuzzy_equals(circle_area(5), M_PI * 25);
    $test->assert_fuzzy_equals(circle_area(5), M_PI * 25, 1e-9);
    $test->assert_fuzzy_equals(circle_area(5), M_PI * 25, 1e-6);
  });
  $test->it("should NOT return the circumference of the circle", function () {
    global $test;
    $test->assert_not_fuzzy_equals(circle_area(1), 2 * M_PI);
    $test->assert_not_fuzzy_equals(circle_area(1), 2 * M_PI, 1e-9);
    $test->assert_not_fuzzy_equals(circle_area(1), 2 * M_PI, 1e-6);
    $test->assert_not_fuzzy_equals(circle_area(3), 6 * M_PI);
    $test->assert_not_fuzzy_equals(circle_area(3), 6 * M_PI, 1e-9);
    $test->assert_not_fuzzy_equals(circle_area(3), 6 * M_PI, 1e-6);
    $test->assert_not_fuzzy_equals(circle_area(5), 10 * M_PI);
    $test->assert_not_fuzzy_equals(circle_area(5), 10 * M_PI, 1e-9);
    $test->assert_not_fuzzy_equals(circle_area(5), 10 * M_PI, 1e-6);
  });
});

function circle_area($radius) {
  return $radius * M_PI * $radius;
}
?>
