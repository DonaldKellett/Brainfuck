# Brainfuck

[![Join the chat at https://gitter.im/Brainfuck-Interpreter/Lobby](https://badges.gitter.im/Brainfuck-Interpreter/Lobby.svg)](https://gitter.im/Brainfuck-Interpreter/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

*Related Kata (Codewars): [My smallest code interpreter (aka Brainf**k)](http://www.codewars.com/kata/my-smallest-code-interpreter-aka-brainf-star-star-k)*

My implementations of the Brainfuck Interpreter in a number of Turing-complete scripting languages.  Complete with comments throughout the code to explain what is happening in the interpreter.  Guaranteed to work properly for all *valid* Brainfuck programs, with or without comments.  **MIT Licensed**

## Brainfuck - The Language

Brainfuck is an extremely minimal Turing-complete programming language with just 8 commands. [[1]](https://learnxinyminutes.com/docs/brainfuck/)  It is represented by an array of 30,000 cells, each initialized to 0.  Initially, the data pointer points at the first cell (index 0).

The 8 commands are as follows:

- `.` - Prints the ASCII value of the current cell, e.g. `65 -> A`
- `,` - Stores one byte of input from the user into the current cell, e.g. `A -> 65`
- `+` - Increments the value of the current cell by 1.  If the value of the current cell overflows (i.e. exceeds `255`), the value is looped back to 0.
- `-` - Decrements the value of the current cell by 1.  If the value of the current cell is less than 0, the value is looped back to `255`.
- `>` - Moves the data pointer to the next cell
- `<` - Moves the data pointer to the previous cell
- `[` - If the value at the current cell is **zero**, skip to the corresponding `]`.  Otherwise, move to the next instruction. [[1]](https://learnxinyminutes.com/docs/brainfuck/)
- `]` - If the value at the current cell is **nonzero**, backtrack to the corresponding `[`.  Otherwise, move to the next instruction.

Common sense dictates that the `[` and `]` characters form a sort of (primitive) `while` loop when balanced.  Obviously, they must be balanced.  All other characters that do not belong to either of the 8 commands are simply ignored (and therefore can serve as comments).

## A Simple Example - Hello World

Below is a simple example of a Brainfuck program that prints out the string `"Hello World!"` to the screen.

```brainfuck
++++++++++ Initialize cell #0 to 10
[
  "while" loop begins
  >+++ Go to cell #1 and add 3
  >+++++++ Go to cell #2 and add 7
  >+++++++++ Go to cell #3 and add 9
  >++++++++++ Go to cell #4 and add 10
  >+++++++++++ Go to cell #5 and add 11
  <<<<<- Return to cell #0 and decrement its value
  "while" loop ends
]
[
  Now cell #0 has value 0,
  cell #1 has value 70,
  cell #2 has value 100,
  cell #3 has value 110,
  and cell #4 has value 30:
  0 | 70 | 100 | 110 | 30 | 0 | ...
  Note that this is what is known as a "comment loop".
  In a comment loop, all special characters in Brainfuck are ignored
  PROVIDED THAT: the value of the current cell is 0
  AND: all opening and closing square brackets "[]" are balanced
]
>>++. Print "H"
>>+. Print "e"
>--. Print "l"
. Print "l"
+++. Print "o"
<<<<++. Print " " (spacebar character)
>>---. Print "W"
>>. Print "o"
+++. Print "r"
------. Print "l"
<-. Print "d"
<<<+. Print "!"
```

Note that there are *countless* ways to print out `"Hello World!"` in a Brainfuck program.  The example shown above is fairly optimised in that it makes use of a simple `while` loop to simplify some of the calculations but there are probably shorter Brainfuck programs out there that does the same job.

## Interpreters

Brainfuck interpreters in each scripting language is placed in a folder of its own complete with test cases / examples to prove that it works.

### PHP

- Folder: `php`
- File containing interpreter: `function.brainfuck.php`
- Full suite of test cases (powered by [PHPTester](https://github.com/DonaldKellett/PHPTester)): `test_cases.php`

#### The Interpreter

*NOTE: The interpreter function in PHP requires PHP 7+ as it uses PHP 7 syntax features such as type declarations and return type declarations.  In order to adapt the interpreter for PHP 5+ (or older), simply remove the type declarations and return type declarations in the first line of the interpreter function and the code should work properly for older versions of PHP.*

```php
string brainfuck(string $code[, string $input = ""])
```

The function receives 1 required and 1 optional argument, the first (required) argument being the Brainfuck program passed in as a string.  Comments (i.e. characters other than the 8 command characters) are supported.  The second (optional) argument is the list of bytes of data (in the form of a **string** *not* an array) passed into the Brainfuck program if the program contains the `,` character.  For example, if your program contains two `,`s in total and your `$input` string is `"BF"`, then the value of the character `"B"` will be passed into the program upon the first `,` followed by the character value of `"F"` upon the second `,`.  The interpreter stores a value of `0` at the cell under the pointer when EOF is reached.

### JavaScript

- Folder: `js`
- File containing interpreter: `function.brainfuck.js`
- File containing proof of functioning interpreter (no testing framework employed): `proof.html`

#### The Interpreter

```javascript
var stringOutput = brainfuck(code[, input = ""]);
```

The interpreter accepts 1 required argument and 1 optional argument.  The first (required) argument is the Brainfuck program passed in as a string.  Comments (i.e. characters other than the 8 command characters in Brainfuck) are supported.  The second (optional) argument is the list of bytes of character data passed into the Brainfuck program if the program requires user input (i.e. `,`) **in the form of a string** *not* an array.  For example, if the Brainfuck program contains two `,`s and the `input` string is `"BF"` then `"B"` will be passed in for the first `,` and `"F"` for the next `,`.  When EOF is reached, the interpreter simply stores a value of `0` at the cell under the pointer.  The return value of the interpreter is *always* a string even if only digits are printed out.

## Credits

1. [Learn X in Y minutes (where X = brainfuck)](https://learnxinyminutes.com/docs/brainfuck/)
