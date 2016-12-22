<?php

/*
  arrays.php
  A simple introduction to array assertion methods in PHPTester
  For the actual testing framework, please refer to `class.phptester.php`
*/

require '../class.phptester.php';
$test = new PHPTester;
$test->describe("The \"multiples_of\" function", function () {
  global $test;
  $test->it("should return the first multiple of \$x (the first argument of the function) correctly", function () {
    global $test;
    $test->assert_equals(multiples_of(5)[0], 5);
    $test->assert_equals(multiples_of(10)[0], 10);
    $test->assert_equals(multiples_of(3)[0], 3);
    $test->assert_equals(multiples_of(13)[0], 13);
  });
  $test->it("should return the first 10 multiples by default", function () {
    global $test;
    $test->assert_similar(multiples_of(5), [5, 10, 15, 20, 25, 30, 35, 40, 45, 50]);
    $test->assert_similar(multiples_of(13), [13, 26, 39, 52, 65, 78, 91, 104, 117, 130]);
  });
  $test->it("should be able to receive an optional second argument which specifies the number of multiples", function () {
    global $test;
    $test->assert_similar(multiples_of(5, 3), [5, 10, 15]);
    $test->assert_similar(multiples_of(21, 5), [21, 42, 63, 84, 105]);
    // NOTE: The assert_similar method can handles associative arrays and nested arrays (to any level of depth) properly
    $test->assert_similar([multiples_of(5, 1), multiples_of(5, 2), multiples_of(5, 3), ["multiples of 21 up to the second multiple of 21" => multiples_of(21, 2), "upto fifth" => multiples_of(21, 5)]], [[5], [5, 10], [5, 10, 15], ["multiples of 21 up to the second multiple of 21" => [21, 42], "upto fifth" => [21, 42, 63, 84, 105]]]);
  });
  $test->it("should start counting from the first multiple of the number \$x and not count from 0", function () {
    global $test;
    $test->assert_not_similar(multiples_of(5, 3), [0, 5, 10]);
    $test->assert_not_similar(multiples_of(5, 3), [0, 5, 10, 15]);
  });
});

function multiples_of($x, $n = 10) {
  return array_map(function ($n, $x) {return $n * $x;}, range(1, $n), array_fill(0, $n, $x));
}

?>
