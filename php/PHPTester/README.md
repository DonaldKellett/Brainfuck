# PHPTester

[![Join the chat at https://gitter.im/DonaldKellett/PHPTester](https://badges.gitter.im/DonaldKellett/PHPTester.svg)](https://gitter.im/DonaldKellett/PHPTester?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

A custom PHP TDD Framework.  MIT Licensed.

## Version Details

- Version Number: `v3.1.0`
- Status: Stable - Production Ready
- License: **MIT License**

## Overview

**PHPTester** currently consists of three major components:

- Interfaces - these provide you with the correct guidelines to implement a custom PHP testing framework shall you want to implement your own (instead of directly using the PHP testing framework provided in this software) and should be extendable
- The `PHPTesterException` class - this is used internally by the main class to generate more human-readable error messages in some cases.  It is extendable and can be used in your own code as well (shall you wish to do so).
- The main class where everything is implemented - `PHPTester`.  Can be extended using the `extends` keyword.

## Documentation

Please note that the Documentation is only meant as a simple, brief guide on the methods available in the `PHPTester` testing framework and how to use them.  In case of doubt, please refer to the **demos** (in the `demo` folder) and if you still don't understand how a particular method works, feel free to [contact me](mailto:dleung@connect.kellettschool.com).

### Class Constants

Class: `PHPTester`

#### VERSION

A string specifying the current version of `PHPTester` being used, e.g.

```php
echo PHPTester::VERSION; // v3.1.0
```

### Core

Interface: `PHPTesterCore`

#### describe

Used to group a set of test cases to be executed.

Argument Order: `$msg`, `$fn`

Argument Description:

1. `$msg` - Required.  Specifies the message to be displayed to the screen which describes the set of tests to be executed.
2. `$fn` - Required.  A function containing the set of test cases to be executed.

#### it

Used to group a *subset* of test cases to be executed.  Must be nested within the `describe` method.

Argument Order: `$msg`, `$fn`

Argument Description:

1. `$msg` - Required.  Specifies the message to be displayed to the screen which describes the *subset* of tests to be executed.
2. `$fn` - Required.  A function containing the *subset* of test cases to be executed.

#### expect

The core assertion method in which all other assertion methods are built on (in the main PHP testing framework class).  If you plan to implement your own testing framework, you are strongly advised to use this assertion method as a base assertion method.

Argument Order: `$passed`, `$msg`, `$success`

Argument Description:

1. `$passed` - Required.  Ideally a value of type `bool`.  If the value is truthy (or `true`) then the test is passed, else it fails.
2. `$msg` - *Optional*.  The message to be displayed if the test fails.  However, **it is a best practice to provide this argument** to aid debugging.
3. `$success` - *Optional*.  The message to be displayed upon a successful test.  This argument is not required and is usually used internally in other assertion methods.

#### assert_equals

A basic assertion method that compares two primitive values and passes the test if the two are equal.

**NOTE: The inverse assertion of `assert_equals` is `assert_not_equals` and takes exactly the same arguments in the same order.**

Argument Order: `$actual`, `$expected`, `$msg`, `$success`

Argument Description:

1. `$actual` - Required.  Must be a **primitive** value (e.g. `bool`, `int`, `float`, `string`) and must be the value returned by the algorithm being tested, NOT the expected return value.  The test is successful if this is equal to the expected return value.
2. `$expected` - Required.  Must be a **primitive** value (e.g. `bool`, `int`, `float`, `string`) and must be the expected return value, NOT the value returned by the algorithm being tested.  The test is successful if the actual return value is equal to this.
3. `$msg` - *Optional*.  The message to be shown in case of a failed test.  Best practice is to provide it to aid debugging.
4. `$success` - *Optional*.  The message to be shown when the test is successful.  Not required; usually used internally by other methods.

### Error Assertions

Interface: `PHPTesterErrorAssertions`

#### expect_error

Runs a function containing the code to be tested and catches any errors thrown in the process.  The test is successful if an `Error`/`ErrorException`/`Exception` is thrown and fails otherwise.

**NOTE: `expect_no_error` is the inverse assertion of this method and takes exactly the same arguments in the same order.**

Argument Order: `$msg`, `$fn`

Argument Description:

1. `$msg` - Required.  The message to be displayed in case of a failed test.
2. `$fn` - Required.  The function containing the code to be tested.

### Array Assertions

Interface: `PHPTesterArrayAssertions`

#### assert_similar

Compares two arrays and checks if they are the same recursively.  The test is successful if the two arrays are "the same" (in terms of structure) and fails otherwise.

**NOTE: The inverse of this assertion is `assert_not_similar` and takes exactly the same arguments in the same order.**

Argument Order: `$actual`, `$expected`, `$msg`, `$success`

Argument Description:

1. `$actual` - Required.  The **actual array returned by the code to be tested**.
2. `$expected` - Required.  The **expected array structure** (to be returned by the code when it is functioning properly).
3. `$msg` - *Optional*.  The message displayed upon failure.  Best practice is to provide it to aid debugging.
4. `$success` - *Optional*.  The success message when a test is passed.  Not required and usually used internally.

### Number Assertions

Interface: `PHPTesterNumberAssertions`

#### assert_fuzzy_equals

Compares two number values (`int` or `float`) to see if they are approximately equal to each other.  The test is successful if they are almost equal and fails otherwise.

**NOTE: The inverse of this assertion is `assert_not_fuzzy_equals` and takes the exact same arguments in the same order.**

Argument Order: `$actual`, `$expected`, `$range`, `$msg`, `$success`

Argument Description:

1. `$actual` - Required.  An `int` or `float` value **returned from the algorithm to be tested**.
2. `$expected` - Required.  An `int` or `float` value which is the **expected (approximate) answer**.
3. `$range` - *Optional*.  A tiny `float` value that specifies the maximum error as a fraction of the expected value.  It is `1e-12` by default (which will tolerate almost exact answers) but other suggested values include `1e-9` (pretty accurate) and `1e-6` (close-ish value).
4. `$msg` - *Optional*.  The message displayed upon failure.  Best practice is to provide it to aid debugging.
5. `$success` - *Optional*.  The success message when a test is passed.  Not required and usually used internally.

### Performance Assertions

Interface: `PHPTesterPerformanceAssertions`

#### assert_max_execution_time

Executes a block of code and times how long it takes (in milliseconds) to execute that code.  The test is then passed if the execution duration is *shorter than* the specified duration (in milliseconds) and fails otherwise.

**NOTE: The inverse of this assertion is `assert_min_execution_time` and takes the exact same arguments in the exact same order.**

Argument Order: `$fn`, `$ms`, `$msg`, `$success`

Argument Description:

1. `$fn` - Required.  The block of code to be executed and timed (in the form of a function).
2. `$ms` - Required.  The maximum acceptable execution duration in milliseconds.
3. `$msg` - *Optional*.  The message displayed upon failure.  Best practice is to provide it to aid debugging.
4. `$success` - *Optional*.  The success message when a test is passed.  Not required and usually used internally.

### Random Testing

Interface: `PHPTesterRandomTesting`

*Note: The random testing methods are best used in conjunction with a confirmed working algorithm/solution (as the source of validation) when using the testing framework to test others' code to prevent hard-coded (cheat) solutions.*

#### random_number

Returns a random integer in a specified range.

Argument Order: `$min`, `$max`

Argument Description:

1. `$min` - *Optional*.  The minimum possible integer value that can be returned by the method.  Defaults to `0` if not specified.
2. `$max` - *Optional*.  The maximum possible integer value that can be returned by the method.  Defaults to `100` if not specified.

#### random_token

Returns a randomly generated string of a specified length, containing only lowercase alphabet letters and/or digits.

Argument Order: `$length`

Argument Description:

1. `$length` - *Optional*.  Specifies the length of the string to be randomly generated.

#### randomize

Receives a non-associative array as its only argument and returns a new array with the order of the elements shuffled.

Argument Order: `$array`

Argument Description:

1. `$array` - Required.  The **non-associative** array to be shuffled and returned.  Please note that this method is **clean** which means that it does not mutate the original array; rather, it *returns* a new array with the order of the elements shuffled.

### A note regarding implementing your own custom PHP testing framework by implementing the interfaces provided in this software

If you are a senior PHP developer wanting to implement your own PHP testing framework by implementing certain interfaces predefined in this software, it is **highly recommended** that you implement `PHPTesterCore` before implementing any other interfaces.  Please also note that if your `assert_equals` method already handles arrays properly, it is then not required to implement `PHPTesterArrayAssertions`.

## Demos

Folder: `demo`

1. `basic.php` - A basic demo regarding how to use the core PHPTester methods
2. `errors.php` - A simple introduction to the error-handling methods in PHPTester and when/how to use them
3. `arrays.php` - A simple introduction to array assertion methods in PHPTester
4. `numbers.php` - A simple introduction to number assertions in PHPTester
5. `performance.php` - A simple introduction to performance assertions in PHPTester
6. `random.php` - A simple introduction to random testing methods in PHPTester
