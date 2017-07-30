<?php

/*
  Test Cases for my Brainfuck Interpreter
  Written in PHPTester (https://github.com/DonaldKellett/PHPTester)
  (c) Donald Leung.  All rights reserved.
  MIT License
*/

require 'function.brainfuck.php'; // Brainfuck Interpreter
require 'PHPTester/class.phptester.php'; // PHPTester testing framework

$test = new PHPTester;

$test->describe("The Brainfuck Interpreter", function () use ($test) {
  $test->it("should print the string \"Hello World!\" for the example Hello World program provided in the README", function () use ($test) {
    $test->assert_equals(brainfuck("++++++++++ Initialize cell #0 to 10
    [
      \"while\" loop begins
      >+++ Go to cell #1 and add 3
      >+++++++ Go to cell #2 and add 7
      >+++++++++ Go to cell #3 and add 9
      >++++++++++ Go to cell #4 and add 10
      >+++++++++++ Go to cell #5 and add 11
      <<<<<- Return to cell #0 and decrement its value
      \"while\" loop ends
    ]
    [
      Now cell #0 has value 0,
      cell #1 has value 70,
      cell #2 has value 100,
      cell #3 has value 110,
      and cell #4 has value 30:
      0 | 70 | 100 | 110 | 30 | 0 | ...
      Note that this is what is known as a \"comment loop\".
      In a comment loop, all special characters in Brainfuck are ignored
      PROVIDED THAT: the value of the current cell is 0
      AND: all opening and closing square brackets \"[]\" are balanced
    ]
    >>++. Print \"H\"
    >>+. Print \"e\"
    >--. Print \"l\"
    . Print \"l\"
    +++. Print \"o\"
    <<<<++. Print \" \" (spacebar character)
    >>---. Print \"W\"
    >>. Print \"o\"
    +++. Print \"r\"
    ------. Print \"l\"
    <-. Print \"d\"
    <<<+. Print \"!\""), "Hello World!");
  });
  $test->it("should work for some other simple examples", function () use ($test) {
    $test->assert_equals(brainfuck(",+[-.,+]", "Codewars" . chr(255)), "Codewars");
    $test->assert_equals(brainfuck(",[.[-],]", "Codewars" . chr(0)), "Codewars");
    $test->assert_equals(ord(brainfuck(",>,<[>[->+>+<<]>>[-<<+>>]<<<-]>>.", chr(8) . chr(9))), 72);
    $test->assert_equals(ord(brainfuck(",>,<[>[->+>+<<]>>[-<<+>>]<<<-]>>.", chr(9) . chr(8))), 72);
    $test->assert_equals(ord(brainfuck(",>,<[>[->+>+<<]>>[-<<+>>]<<<-]>>.", chr(3) . chr(5))), 15);
    $test->assert_equals(ord(brainfuck(",>,<[>[->+>+<<]>>[-<<+>>]<<<-]>>.", chr(4) . chr(6))), 24);
    $test->assert_equals(ord(brainfuck(",>,<[>[->+>+<<]>>[-<<+>>]<<<-]>>.", chr(7) . chr(7))), 49);
    $test->assert_equals(ord(brainfuck(",>,<[>[->+>+<<]>>[-<<+>>]<<<-]>>.", chr(13) . chr(12))), 156);
    $test->assert_equals(ord(brainfuck(",>,<[>[->+>+<<]>>[-<<+>>]<<<-]>>.", chr(15) . chr(15))), 225);
  });
  $test->it("should input 0 at the cell under the pointer when EOF is reached", function () use ($test) {
    $test->assert_equals(brainfuck(",[.,]", "Codewars"), "Codewars");
    $test->assert_equals(brainfuck(",[.,]", "@donaldsebleung"), "@donaldsebleung");
    $test->assert_equals(brainfuck(",[.,]", "brainfuck"), "brainfuck");
    $test->assert_equals(brainfuck(",[.,]", "BF"), "BF");
    $test->assert_equals(brainfuck(",[.,]", "PHPTester"), "PHPTester");
  });
  $test->it("should work for slightly more complicated Brainfuck programs", function () use ($test) {
    $test->assert_equals(brainfuck("++++++++++[>+++++++>++++++++++>+++>+<<<<-]>++.>+.+++++++..+++.>++.<<+++++++++++++++.>.+++.------.--------.>+."), "Hello World!");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(1)), "1");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(2)), "1, 1");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(3)), "1, 1, 2");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(4)), "1, 1, 2, 3");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(5)), "1, 1, 2, 3, 5");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(6)), "1, 1, 2, 3, 5, 8");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(7)), "1, 1, 2, 3, 5, 8, 13");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(8)), "1, 1, 2, 3, 5, 8, 13, 21");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(9)), "1, 1, 2, 3, 5, 8, 13, 21, 34");
    $test->assert_equals(brainfuck(",>+>>>>++++++++++++++++++++++++++++++++++++++++++++>++++++++++++++++++++++++++++++++<<<<<<[>[>>>>>>+>+<<<<<<<-]>>>>>>>[<<<<<<<+>>>>>>>-]<[>++++++++++[-<-[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<[>>>+<<<-]>>[-]]<<]>>>[>>+>+<<<-]>>>[<<<+>>>-]+<[>[-]<[-]]>[<<+>>[-]]<<<<<<<]>>>>>[++++++++++++++++++++++++++++++++++++++++++++++++.[-]]++++++++++<[->-<]>++++++++++++++++++++++++++++++++++++++++++++++++.[-]<<<<<<<<<<<<[>>>+>+<<<<-]>>>>[<<<<+>>>>-]<-[>>.>.<<<[-]]<<[>>+>+<<<-]>>>[<<<+>>>-]<<[<+>-]>[<+>-]<<<-]", chr(10)), "1, 1, 2, 3, 5, 8, 13, 21, 34, 55");
  });
  $test->it('should work for Daniel B Cristofani\'s Universal Turing Machine (UTM) simulation', function () use ($test) {
    $test->assert_max_execution_time(function () use ($test) {
      for ($i = 0; $i < 10; $i++) $test->assert_equals(brainfuck(file_get_contents('external-files/utm.b'), 'b1b1bbb1c1c11111d'), "1c11111\n");
    }, 1500);
  });
  $test->it('should throw a ParseError if unmatched brackets are detected', function () use ($test) {
    $test->expect_error('A lone opening square bracket should throw a ParseError', function () {
      brainfuck('[');
    });
    $test->expect_error('A lone closing square bracket should throw a ParseError', function () {
      brainfuck(']');
    });
    $test->expect_error('Inverted brackets should not be counted as properly matched', function () {
      brainfuck('][');
    });
    $test->expect_no_error('A properly matched pair of brackets should cause no problem', function () {
      brainfuck('[]');
    });
    $test->expect_error('The interpreter should detect unmatched brackets in more complicated cases', function () {
      brainfuck('[]]]]]]]]]][[[[[[[[[[]');
    });
  });
  $test->it('should throw an OutOfBoundsException if the pointer goes out of bounds', function () use ($test) {
    $test->expect_error('Too far to the left', function () {
      brainfuck('<');
    });
    $test->expect_error('Too far to the right', function () {
      brainfuck('+[>+]');
    });
    $test->expect_error('Too far to the right (2)', function () {
      brainfuck('-[>-]');
    });
  });
  $test->it('should work for a few bizzare edge cases', function () use ($test) {
    $test->assert_equals(brainfuck(str_repeat('+', 103496) . '.'), 'H');
    $test->assert_equals(brainfuck(str_repeat('-', 117944) . '.'), 'H');
    $test->assert_equals(brainfuck(str_repeat('-', 117944) . str_repeat('.', 93)), str_repeat('H', 93));
  });
});

?>
