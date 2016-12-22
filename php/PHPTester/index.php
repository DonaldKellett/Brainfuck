<?php

/*
  Testing PHPTester
  Used internally by the author of PHPTester to make sure everything is working as intended - nothing useful here
  For the actual testing framework, please refer to `class.phptester.php`
*/

require 'class.phptester.php';
$test = new PHPTester;
$test->describe("PHPTester " . PHPTester::VERSION, function () {
  global $test;
  $test->it("should have a working 'expect' method", function () {
    global $test;

    # Passing Tests with Default Message
    $test->expect(true);
    $test->expect(true);
    $test->expect(true);
    $test->expect(true);
    $test->expect(true);

    # Passing Tests with Custom Message
    $test->expect(true, "", "Hooray!  You passed the test.");
    $test->expect(true, "", "Hooray!  You passed the test.");
    $test->expect(true, "", "Hooray!  You passed the test.");
    $test->expect(true, "", "Hooray!  You passed the test.");
    $test->expect(true, "", "Hooray!  You passed the test.");

    # Failing Tests with Default Message
    $test->expect(false);
    $test->expect(false);
    $test->expect(false);
    $test->expect(false);
    $test->expect(false);

    # Failing Tests with Custom Message
    $test->expect(false, "You failed, better luck next time");
    $test->expect(false, "You failed, better luck next time");
    $test->expect(false, "You failed, better luck next time");
    $test->expect(false, "You failed, better luck next time");
    $test->expect(false, "You failed, better luck next time");
  });
  $test->it("should have a functioning (protected) 'display' method", function () {
    global $test;
    echo $test->display(true) . "<br />";
    echo $test->display(false) . "<br />";
    echo $test->display(NULL) . "<br />";
    echo $test->display(1) . "<br />";
    echo $test->display(0) . "<br />";
    echo $test->display(M_PI) . "<br />";
    echo $test->display("Hello World") . "<br />";
    echo $test->display("bacon") . "<br />";
    echo $test->display(array(1, 2, 3, 4, 5)) . "<br />";
    echo $test->display(array(array(1, 2, 3), array(1, 2, 3), array(1, 2, 3))) . "<br />";
    class Cat {
      public $public = "public";
      private $private = "private";
      protected $protected = "protected";
      public $array = array(5, 4, 3, 2, 1, 10, 100);
    }
    echo $test->display(new Cat) . "<br />";
  });
  $test->it("should have a working assert_equals method", function () {
    global $test;

    # Passing Tests with Default Message
    $test->assert_equals(1, 1);
    $test->assert_equals(0, 0);
    $test->assert_equals(true, true);
    $test->assert_equals(false, false);
    $test->assert_equals("Hello World", "Hello World");

    # Passing Tests with Custom Message
    $test->assert_equals(1, 1, "", "Well done, you passed the test");
    $test->assert_equals(0, 0, "", "Well done, you passed the test");
    $test->assert_equals(true, true, "", "Well done, you passed the test");
    $test->assert_equals(false, false, "", "Well done, you passed the test");
    $test->assert_equals("Hello World", "Hello World", "", "Well done, you passed the test");

    # Failing Tests with Default Message
    $test->assert_equals(1, true);
    $test->assert_equals(0, false);
    $test->assert_equals(true, false);
    $test->assert_equals(0, 1);
    $test->assert_equals("Goodbye World", "Hello World");

    # Failing Tests with Custom Message
    $test->assert_equals(1, true, "Bad luck, you failed the test");
    $test->assert_equals(0, false, "Bad luck, you failed the test");
    $test->assert_equals(true, false, "Bad luck, you failed the test");
    $test->assert_equals(0, 1, "Bad luck, you failed the test");
    $test->assert_equals("Goodbye World", "Hello World", "Bad luck, you failed the test");

    # Error
    $test->assert_equals(array(3, 4, 5, 10, 12), 34);
  });
  $test->it("should have a working assert_not_equals method", function () {
    global $test;

    # Passing Tests with Default Message
    $test->assert_not_equals(1, true);
    $test->assert_not_equals(0, false);
    $test->assert_not_equals(M_PI, M_E);
    $test->assert_not_equals(3, M_PI);
    $test->assert_not_equals("Goodbye World", "Hello World");

    # Passing Tests with Custom Message
    $test->assert_not_equals(1, true, "", "Hooray, you passed");
    $test->assert_not_equals(0, false, "", "Hooray, you passed");
    $test->assert_not_equals(M_PI, M_E, "", "Hooray, you passed");
    $test->assert_not_equals(3, M_PI, "", "Hooray, you passed");
    $test->assert_not_equals("Goodbye World", "Hello World", "", "Hooray, you passed");

    # Failing Tests with Default Message
    $test->assert_not_equals(1, 1);
    $test->assert_not_equals(0, 0);
    $test->assert_not_equals(true, true);
    $test->assert_not_equals(false, false);
    $test->assert_not_equals("Hello World", "Hello World");

    # Failing Tests with Custom Message
    $test->assert_not_equals(1, 1, "Test did not pass");
    $test->assert_not_equals(0, 0, "Test did not pass");
    $test->assert_not_equals(true, true, "Test did not pass");
    $test->assert_not_equals(false, false, "Test did not pass");
    $test->assert_not_equals("Hello World", "Hello World", "Test did not pass");

    # Error
    $test->assert_not_equals(M_PI, array(1, 2, 3, 4, 5));
  });
  /* $test->it("should have a working assert_fuzzy_equals method", function () {
    global $test;

    # Passing Tests with Default Message
    $test->assert_fuzzy_equals(3.14159495, M_PI);
    $test->assert_fuzzy_equals(2.718284969, M_E);
    $test->assert_fuzzy_equals(3, M_PI, 0);
    $test->assert_fuzzy_equals(3, M_E, 0);
    $test->assert_fuzzy_equals(M_PI, M_E, 0);

    # Passing Tests with Custom Message
    $test->assert_fuzzy_equals(3.14159495, M_PI, 5, "", "Your value was within the accepted range");
    $test->assert_fuzzy_equals(2.718284969, M_E, 5, "", "Your value was within the accepted range");
    $test->assert_fuzzy_equals(3, M_PI, 0, "", "Your value was within the accepted range");
    $test->assert_fuzzy_equals(3, M_E, 0, "", "Your value was within the accepted range");
    $test->assert_fuzzy_equals(M_PI, M_E, 0, "", "Your value was within the accepted range");

    # Failing Tests with Default Message
    $test->assert_fuzzy_equals(2.718289, M_E);
    $test->assert_fuzzy_equals(3.141598, M_PI);
    $test->assert_fuzzy_equals(3, M_PI, 1);
    $test->assert_fuzzy_equals(3, M_E, 1);
    $test->assert_fuzzy_equals(M_PI, M_E, 1);

    # Failing Tests with Custom Message
    $test->assert_fuzzy_equals(2.718289, M_E, 5, "Your value was not within the accepted range");
    $test->assert_fuzzy_equals(3.141598, M_PI, 5, "Your value was not within the accepted range");
    $test->assert_fuzzy_equals(3, M_PI, 1, "Your value was not within the accepted range");
    $test->assert_fuzzy_equals(3, M_E, 1, "Your value was not within the accepted range");
    $test->assert_fuzzy_equals(M_PI, M_E, 1, "Your value was not within the accepted range");

    # Error
    $test->assert_fuzzy_equals(3, 3, 3.0);
  });
  $test->it("should have a working assert_not_fuzzy_equals method", function () {
    global $test;

    # Passing Tests with Default Message
    $test->assert_not_fuzzy_equals(2.718289, M_E);
    $test->assert_not_fuzzy_equals(3.141598, M_PI);
    $test->assert_not_fuzzy_equals(3, M_PI, 1);
    $test->assert_not_fuzzy_equals(3, M_E, 1);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 1);

    # Passing Tests with Custom Message
    $test->assert_not_fuzzy_equals(2.718289, M_E, 5, "", "Your value was outside the forbidden range");
    $test->assert_not_fuzzy_equals(3.141598, M_PI, 5, "", "Your value was outside the forbidden range");
    $test->assert_not_fuzzy_equals(3, M_PI, 1, "", "Your value was outside the forbidden range");
    $test->assert_not_fuzzy_equals(3, M_E, 1, "", "Your value was outside the forbidden range");
    $test->assert_not_fuzzy_equals(M_PI, M_E, 1, "", "Your value was outside the forbidden range");

    # Failing Tests with Default Message
    $test->assert_not_fuzzy_equals(3.14159495, M_PI);
    $test->assert_not_fuzzy_equals(2.718284969, M_E);
    $test->assert_not_fuzzy_equals(3, M_PI, 0);
    $test->assert_not_fuzzy_equals(3, M_E, 0);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0);

    # Failing Tests with Custom Message
    $test->assert_not_fuzzy_equals(3.14159495, M_PI, 5, "Your value was within the forbidden range");
    $test->assert_not_fuzzy_equals(2.718284969, M_E, 5, "Your value was within the forbidden range");
    $test->assert_not_fuzzy_equals(3, M_PI, 0, "Your value was within the forbidden range");
    $test->assert_not_fuzzy_equals(3, M_E, 0, "Your value was within the forbidden range");
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0, "Your value was within the forbidden range");

    # Error
    $test->assert_not_fuzzy_equals(M_PI, "Hello World");
  }); */
  $test->it("should have a working expect_error method", function () {
    global $test;

    # Passing Tests
    $test->expect_error("A PHPTesterException was not thrown", function () {
      throw new PHPTesterException("This exception should pass the test.");
    });
    $test->expect_error("Expected error was not thrown", function () {
      throw new ErrorException;
    });

    # Failing Tests
    $test->expect_error("A PHPTesterException was not thrown", function () {
      echo new PHPTesterException("Now this should fail the test") . "<br />";
    });
    $test->expect_error("Expected error was not thrown", function () {
      echo new ErrorException . "<br />";
    });
  });
  $test->it("should have a working expect_no_error method", function () {
    global $test;

    # Passing Tests
    $test->expect_no_error("Error should not be thrown", function () {
      echo new PHPTesterException("This should pass the test") . "<br />";
    });
    $test->expect_no_error("Error should not be thrown", function () {
      echo new ErrorException . "<br />";
    });

    # Failing Tests
    $test->expect_no_error("An exception should not be thrown", function () {
      throw new PHPTesterException("Now this should fail the test");
    });
    $test->expect_no_error("An ErrorException should not be thrown", function () {
      throw new ErrorException;
    });
  });
  $test->it("should have a functioning (protected) check_similar method", function () {
    global $test;
    $test->expect($test->check_similar(NULL, NULL));
    $test->expect($test->check_similar(1, 1));
    $test->expect($test->check_similar(0, 0));
    $test->expect($test->check_similar(true, true));
    $test->expect($test->check_similar(false, false));
    $test->expect($test->check_similar(M_PI, M_PI));
    $test->expect($test->check_similar(M_E, M_E));
    $test->expect($test->check_similar("Hello World", "Hello World"));
    $test->expect($test->check_similar("HELLO WORLD", "HELLO WORLD"));
    $test->expect($test->check_similar(array(2, 4, 6, 8, 10, 12, 14, 16, 18, 20), array(2, 4, 6, 8, 10, 12, 14, 16, 18, 20)));
    $test->expect($test->check_similar(array("Hello" => "World", "Goodbye" => "World", "bacon" => "necessity"), array("Hello" => "World", "Goodbye" => "World", "bacon" => "necessity")));
    $test->expect($test->check_similar(array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    ), array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    )));
    $test->expect(!$test->check_similar(NULL, false));
    $test->expect(!$test->check_similar(false, NULL));
    $test->expect(!$test->check_similar(true, 1));
    $test->expect(!$test->check_similar(1, true));
    $test->expect(!$test->check_similar(1, 0));
    $test->expect(!$test->check_similar(0, 1));
    $test->expect(!$test->check_similar(0, NULL));
    $test->expect(!$test->check_similar(NULL, 0));
    $test->expect(!$test->check_similar(M_PI, M_E));
    $test->expect(!$test->check_similar(M_E, M_PI));
    $test->expect(!$test->check_similar("Hello World", "HELLO WORLD"));
    $test->expect(!$test->check_similar("HELLO WORLD", "Hello World"));
    $test->expect(!$test->check_similar(array(2, 4, 6, 8, 10, 12), array(2, 4, 6, 8, 10)));
    $test->expect(!$test->check_similar(array(2, 4, 6, 8, 10), array(2, 4, 6, 8, 10, 12)));
    $test->expect(!$test->check_similar(array(4, 2, 8, 10, 6), array(2, 4, 6, 8, 10)));
    $test->expect(!$test->check_similar(array(2, 4, 6, 8, 10), array(4, 2, 8, 10, 6)));
    $test->expect(!$test->check_similar(array(array()), array()));
    $test->expect(!$test->check_similar(array(), array(array())));
    $test->expect(!$test->check_similar(array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array("course"))))),
        "bacon" => "Most delicious of all"
      )
    ), array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    )));
    $test->expect(!$test->check_similar(array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    ), array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array("course"))))),
        "bacon" => "Most delicious of all"
      )
    )));
    $test->expect(!$test->check_similar(array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, false, NULL, "Hello World", true, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    ), array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    )));
    $test->expect(!$test->check_similar(array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    ), array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, false, NULL, "Hello World", true, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    )));
  });
  $test->it("should have working assert_similar and assert_not_similar methods", function () {
    global $test;

    # assert_similar (Passing Tests with Default Message Only)
    $test->assert_similar(array(), array());
    $test->assert_similar(array(2, 4, 6, 8, 10), array(2, 4, 6, 8, 10));
    $test->assert_similar(array("Hello" => "World", "bacon" => "delicious"), array("Hello" => "World", "bacon" => "delicious"));
    $test->assert_similar(array(array(array(array(array("Hello World"))))), array(array(array(array(array("Hello World"))))));
    $test->assert_similar(array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    ), array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    ));

    # assert_not_similar (Failing Tests with Default Message Only)
    $test->assert_not_similar(array(), array());
    $test->assert_not_similar(array(2, 4, 6, 8, 10), array(2, 4, 6, 8, 10));
    $test->assert_not_similar(array("Hello" => "World", "bacon" => "delicious"), array("Hello" => "World", "bacon" => "delicious"));
    $test->assert_not_similar(array(array(array(array(array("Hello World"))))), array(array(array(array(array("Hello World"))))));
    $test->assert_not_similar(array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    ), array(
      "Hello" => "World",
      "bacon" => "delicious",
      "array" => array(1, 2, 3, 4, 5),
      "nested array" => array("Hello" => "World", "bacon", "is", "not" => array("Just", "kidding", "!") , "delicious"),
      "complex nested array" => array(
        "ice cream" => array("quite" => array(4, true, NULL, "Hello World", false, M_PI, "bacon", M_E), "delicious"),
        "curry" => array("Even" => "better", "of" => array(array(array(array(array("course")))))),
        "bacon" => "Most delicious of all"
      )
    ));
  });
  $test->it("should handle all types of errors and exceptions properly", function () {
    throw new TypeError;
  });
  $test->it("should handle all types of errors and exceptions properly", function () {
    throw new ParseError;
  });
  $test->it("should handle all types of errors and exceptions properly", function () {
    throw new DivisionByZeroError;
  });
  $test->it("should handle all types of errors and exceptions properly", function () {
    throw new AssertionError;
  });
  $test->it("should handle all types of errors and exceptions properly", function () {
    throw new ArithmeticError;
  });
  $test->it("should handle all types of errors and exceptions properly", function () {
    throw new Error;
  });
  $test->it("should handle all types of errors and exceptions properly", function () {
    throw new ErrorException;
  });
  $test->it("should handle all types of errors and exceptions properly", function () {
    throw new Exception;
  });
  $test->it("should have a working assert_max_execution_time", function () {
    global $test;
    $test->assert_max_execution_time(function () {
      $s = "";
      for ($i = 0; $i < 1000000; $i++) {
        $s .= "Hello World<br />";
      }
    }, 1000);
    $test->assert_max_execution_time(function () {
      $s = "";
      for ($i = 0; $i < 1000000; $i++) {
        $s .= "Hello World<br />";
      }
    }, 10);
  });
  $test->it("should have a working assert_min_execution_time", function () {
    global $test;
    $test->assert_min_execution_time(function () {
      $s = "";
      for ($i = 0; $i < 1000000; $i++) {
        $s .= "Hello World<br />";
      }
    }, 10);
    $test->assert_min_execution_time(function () {
      $s = "";
      for ($i = 0; $i < 1000000; $i++) {
        $s .= "Hello World<br />";
      }
    }, 1000);
  });
  $test->it("should have a working assert_fuzzy_equals", function () {
    global $test;
    $test->assert_fuzzy_equals(M_E, M_PI, 0.1);
    $test->assert_fuzzy_equals(M_E, M_PI, 0.2);
    $test->assert_fuzzy_equals(M_E, M_PI, 0.3);
    $test->assert_fuzzy_equals(M_E, M_PI, 0.4);
    $test->assert_fuzzy_equals(M_E, M_PI, 0.5);
    $test->assert_fuzzy_equals(M_E, M_PI, 0.6);
    $test->assert_fuzzy_equals(M_E, M_PI, 0.7);
    $test->assert_fuzzy_equals(M_E, M_PI, 0.8);

    $test->assert_fuzzy_equals(M_PI, M_E, 0.1);
    $test->assert_fuzzy_equals(M_PI, M_E, 0.2);
    $test->assert_fuzzy_equals(M_PI, M_E, 0.3);
    $test->assert_fuzzy_equals(M_PI, M_E, 0.4);
    $test->assert_fuzzy_equals(M_PI, M_E, 0.5);
    $test->assert_fuzzy_equals(M_PI, M_E, 0.6);
    $test->assert_fuzzy_equals(M_PI, M_E, 0.7);
    $test->assert_fuzzy_equals(M_PI, M_E, 0.8);


    $test->assert_fuzzy_equals(3, 3.00001, 1e-8);
    $test->assert_fuzzy_equals(3, 3.00001, 1e-7);
    $test->assert_fuzzy_equals(3, 3.00001, 1e-6);
    $test->assert_fuzzy_equals(3, 3.00001, 1e-5);
    $test->assert_fuzzy_equals(3, 3.00001, 1e-4);
    $test->assert_fuzzy_equals(3, 3.00001, 1e-3);
    $test->assert_fuzzy_equals(3, 3.00001, 1e-2);
    $test->assert_fuzzy_equals(3, 3.00001, 1e-1);

    $test->assert_fuzzy_equals(3.00001, 3, 1e-1);
    $test->assert_fuzzy_equals(3.00001, 3, 1e-2);
    $test->assert_fuzzy_equals(3.00001, 3, 1e-3);
    $test->assert_fuzzy_equals(3.00001, 3, 1e-4);
    $test->assert_fuzzy_equals(3.00001, 3, 1e-5);
    $test->assert_fuzzy_equals(3.00001, 3, 1e-6);
    $test->assert_fuzzy_equals(3.00001, 3, 1e-7);
    $test->assert_fuzzy_equals(3.00001, 3, 1e-8);

    $test->assert_fuzzy_equals(3, 3 + 1e-15);
    $test->assert_fuzzy_equals(3, 3 + 1e-14);
    $test->assert_fuzzy_equals(3, 3 + 1e-13);
    $test->assert_fuzzy_equals(3, 3 + 1e-12);
    $test->assert_fuzzy_equals(3, 3 + 1e-11);
    $test->assert_fuzzy_equals(3, 3 + 1e-10);

    $test->assert_fuzzy_equals(3 + 1e-15, 3);
    $test->assert_fuzzy_equals(3 + 1e-14, 3);
    $test->assert_fuzzy_equals(3 + 1e-13, 3);
    $test->assert_fuzzy_equals(3 + 1e-12, 3);
    $test->assert_fuzzy_equals(3 + 1e-11, 3);
    $test->assert_fuzzy_equals(3 + 1e-10, 3);
  });
  $test->it("should have a working assert_not_fuzzy_equals method", function () {
    global $test;
    $test->assert_not_fuzzy_equals(M_E, M_PI, 0.1);
    $test->assert_not_fuzzy_equals(M_E, M_PI, 0.2);
    $test->assert_not_fuzzy_equals(M_E, M_PI, 0.3);
    $test->assert_not_fuzzy_equals(M_E, M_PI, 0.4);
    $test->assert_not_fuzzy_equals(M_E, M_PI, 0.5);
    $test->assert_not_fuzzy_equals(M_E, M_PI, 0.6);
    $test->assert_not_fuzzy_equals(M_E, M_PI, 0.7);
    $test->assert_not_fuzzy_equals(M_E, M_PI, 0.8);

    $test->assert_not_fuzzy_equals(M_PI, M_E, 0.1);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0.2);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0.3);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0.4);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0.5);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0.6);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0.7);
    $test->assert_not_fuzzy_equals(M_PI, M_E, 0.8);


    $test->assert_not_fuzzy_equals(3, 3.00001, 1e-8);
    $test->assert_not_fuzzy_equals(3, 3.00001, 1e-7);
    $test->assert_not_fuzzy_equals(3, 3.00001, 1e-6);
    $test->assert_not_fuzzy_equals(3, 3.00001, 1e-5);
    $test->assert_not_fuzzy_equals(3, 3.00001, 1e-4);
    $test->assert_not_fuzzy_equals(3, 3.00001, 1e-3);
    $test->assert_not_fuzzy_equals(3, 3.00001, 1e-2);
    $test->assert_not_fuzzy_equals(3, 3.00001, 1e-1);

    $test->assert_not_fuzzy_equals(3.00001, 3, 1e-1);
    $test->assert_not_fuzzy_equals(3.00001, 3, 1e-2);
    $test->assert_not_fuzzy_equals(3.00001, 3, 1e-3);
    $test->assert_not_fuzzy_equals(3.00001, 3, 1e-4);
    $test->assert_not_fuzzy_equals(3.00001, 3, 1e-5);
    $test->assert_not_fuzzy_equals(3.00001, 3, 1e-6);
    $test->assert_not_fuzzy_equals(3.00001, 3, 1e-7);
    $test->assert_not_fuzzy_equals(3.00001, 3, 1e-8);

    $test->assert_not_fuzzy_equals(3, 3 + 1e-15);
    $test->assert_not_fuzzy_equals(3, 3 + 1e-14);
    $test->assert_not_fuzzy_equals(3, 3 + 1e-13);
    $test->assert_not_fuzzy_equals(3, 3 + 1e-12);
    $test->assert_not_fuzzy_equals(3, 3 + 1e-11);
    $test->assert_not_fuzzy_equals(3, 3 + 1e-10);

    $test->assert_not_fuzzy_equals(3 + 1e-15, 3);
    $test->assert_not_fuzzy_equals(3 + 1e-14, 3);
    $test->assert_not_fuzzy_equals(3 + 1e-13, 3);
    $test->assert_not_fuzzy_equals(3 + 1e-12, 3);
    $test->assert_not_fuzzy_equals(3 + 1e-11, 3);
    $test->assert_not_fuzzy_equals(3 + 1e-10, 3);
  });
});
?>
