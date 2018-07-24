# Brainfuck

[![Join the chat at https://gitter.im/Brainfuck-Interpreter/Lobby](https://badges.gitter.im/Brainfuck-Interpreter/Lobby.svg)](https://gitter.im/Brainfuck-Interpreter/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

*Related Kata (Codewars): [My smallest code interpreter (aka Brainf**k)](http://www.codewars.com/kata/my-smallest-code-interpreter-aka-brainf-star-star-k)*

My implementations of the Brainfuck Interpreter in a number of Turing-complete programming languages.  Complete with comments throughout the code to explain what is happening in the interpreter.  Guaranteed to work properly for all *valid* Brainfuck programs, with or without comments.  **MIT Licensed**

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

### PHP

- Folder: `php`
- File containing interpreter: `function.brainfuck.php`
- Full suite of test cases (powered by [PHPTester](https://github.com/DonaldKellett/PHPTester)): `test_cases.php`

#### The Interpreter

*Requires PHP 7 or later*

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

### Netwide Assembler (for Mac OS)

- Folder: `nasm-c`
- File containing interpreter: `brainfuck.asm`
- Proof of working interpreter (no testing framework employed): `proof.c`

#### The Interpreter

*N.B. The interpreter only works on Mac OS with NASM v2.x.x or later installed.  If you are using a Mac, you can check whether you have the latest version of NASM installed by executing the* `nasm -v` *command in your Terminal.*

```c
char *brainfuck(const char *code, const char *input);
```

The interpreter uses a standard implementation with the following implementation details:

- Consists of a memory tape of 30000 8-bit wrapping cells, all initialized to `0` at the start of the BF program to be executed.  The memory tape is non-toroidal
- EOF is denoted as `byte(0)`, i.e. once the input byte stream `input` is exhausted, the `,` command will enter a value of `0` to the cell under the tape pointer
- No standard hacks enabled (such as `!` for separating program and input); no special treatment of newline character

To use the interpreter in your C program, simply include the function declaration as shown above before your `main` function (or any other function that may invoke `brainfuck`).  For example:

```c
/*
 * example.c
 * A simple example on how to use the Brainfuck interpreter written in NASM
 * v2.13.03 for Mac OS
 */

#include <stdio.h>

char *brainfuck(const char *, const char *);

int main() {
  printf("%s\n", brainfuck(">>>>--<-<<+[+[<+>--->->->-<<<]>]<<--.<++++++.<<-..<<.<+.>>.>>.<<<.+++.>>.>>-.<<<+.", "")); // > Hello, World!
  return 0;
}
```

This file has been included in the directory `nasm-c` as `example.c` for your reference.  To assemble, compile and run (including the console output):

```
$ nasm -fmacho64 brainfuck.asm && gcc example.c brainfuck.o && ./a.out
Hello, World!
```

#### Proof of Correctness

To test whether the Brainfuck interpreter located at `brainfuck.asm` is behaving as expected, change directory to the `nasm-c` folder and run the following sequence of commands: `nasm -fmacho64 brainfuck.asm && gcc proof.c brainfuck.o && ./a.out`.  If the interpreter is working as expected, you should see the following output (minus any compiler warnings):

```
$ nasm -fmacho64 brainfuck.asm && gcc proof.c brainfuck.o && ./a.out
Hello, World!
Hello World!
Hello World!
Netwide Assembler
ABCDEFGHIJKLMNOPQRSTUVWXYZ
ABCDEFGHIJKLMNOPQRSTUVWXYZ
abcdefghijklmnopqrstuvwxyz
Hello World!
Hello, World!
NASM + C = pure awesomeness :)
H
8
1, 1, 2, 3, 5, 8, 13, 21, 34, 55
```

### Excel VBA (for Windows Microsoft Excel 2016)

- Folder: `excel-vba`
- File containing interpreter: `Brainfuck.xlsm`

#### The Interpreter

The spreadsheet itself can be used as a Brainfuck interpreter - just enter the BF program and input stream in the correct cells (B1 and B2 respectively), click "Execute" and the program output will be displayed in the output cell (cell B3).  The text in adjacent cells acting as labels should make it clear which cells correspond to the program, input and output.

Alternatively, a function `Brainfuck(ByVal Program As String, ByVal ProgInput As String) As String` has been defined in the same "file" (?) as the event handler for the "Execute" button (which is named `ExecuteButton`) so you could also use that function independently from the spreadsheet interface provided.  For example, you could invoke the `Brainfuck` function with a Hello World program every time the spreadsheet is opened and display the result through a `MsgBox`, like such:

```vba
Sub Sheet1_Open() ' or whatever that handler is called, idk :p
  MsgBox Brainfuck( _
    "++++++++[>++++[>++>+++>+++>+<<<<-]>+>+>->>+[<]<-]>>.>---.+++++++..+++.>>.<-.<.+++.------.--------.>>+.>++.", _
    "" _
  )
End Sub
```

*NOTE: You might have to first copy the function definition of* `Brainfuck` *from the "file" containing the* `ExecuteButton` *event handler to the worksheet open event handler; I'm not sure because I haven't tested it out yet.*

The interpreter used is a standard implementation where the memory tape is exactly `30000` cells long, each cell holds exactly 1 byte (with wrapping behavior), the tape pointer starts at the leftmost cell of the memory tape (and the tape itself does *not* wrap; going out of bounds will likely generate a runtime error) and EOF is denoted as `byte(0)`.  Traditional "hacks" such as `!` separating program from input are *not* supported.

Unlike the BF interpreters featured in the `js`, `php` and `nasm-c` folders, the `Brainfuck` interpreter featured in Excel VBA is not a standalone function - it relies on an externally defined class `VirtualMachine` which simulates the "hardware" a typical Brainfuck program runs on (namely, the memory tape with 30k byte-sized cells initialized to `0` on every run and a tape pointer starting from the leftmost cell).

#### Correctness of Implementation

I didn't provide any test cases in the spreadsheet file for you to verify the correctness of the interpreter; however, I have personally tested it against a few Hello World programs provided at http://esolangs.org/wiki/Brainfuck, a CAT program (assuming EOF is `byte(0)`) with program inputs of varying size, a [Bubblesort program](http://www.hevanet.com/cristofd/brainfuck/bsort.b) with program input "supercalifragilisticexpialidocious" and a [UTM simulation](http://www.hevanet.com/cristofd/brainfuck/utm.b) with the "quick and complete test case" provided in the comments of that program, all of which my implementation produced the expected results.  Feel free to notify me if you stumble across a program that triggers a bug in my interpreter :wink:

## Credits

1. [Learn X in Y minutes (where X = brainfuck)](https://learnxinyminutes.com/docs/brainfuck/)
