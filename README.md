# Brainfuck

[![Join the chat at https://gitter.im/Brainfuck-Interpreter/Lobby](https://badges.gitter.im/Brainfuck-Interpreter/Lobby.svg)](https://gitter.im/Brainfuck-Interpreter/Lobby?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

My implementations of the Brainfuck interpreter in a number of general-purpose programming languages, extensively tested using a wide range of different Brainfuck programs.

## What is Brainfuck?

[Brainfuck](https://esolangs.org/wiki/Brainfuck) is a minimal [Turing-complete](https://en.wikipedia.org/wiki/Turing_completeness) programming language with just 8 commands. Despite its Turing-completeness, it is often impractical to write nontrivial programs in it, [hence its name](https://en.wikipedia.org/wiki/Brainfuck) - in fact, it was invented to demonstrate that Turing-completeness is very easy to achieve and that theoretical computational power does not entail usability in practice. Nevertheless, there are programmers skilled in writing sophisticated Brainfuck programs. In the original implementation of Brainfuck, the memory model consists of a memory tape containing 30,000 wrapping byte-sized cells each initialized to 0, with a memory pointer initially pointing at the leftmost cell. However, perhaps due to the ambiguity in the original Brainfuck specification, many variants of Brainfuck have been created over the years with slightly different behavior, e.g. an infinite memory tape instead of one with exactly 30,000 cells.

The commands are as follows:

| Command | Action |
| --- | --- |
| `>` | Move memory pointer 1 cell to the right |
| `<` | Move memory pointer 1 cell to the left |
| `+` | Increment byte in cell under memory pointer by 1 |
| `-` | Decrement byte in cell under memory pointer by 1 |
| `.` | Output byte in cell under memory pointer |
| `,` | Read byte from input stream and store in cell under memory pointer |
| `[` | Jump to matching `]` if byte in cell under memory pointer is `0` |
| `]` | Jump back to matching `[` (unless byte in cell under memory pointer is `0`) |
| Any other character | No-op - commonly used to annotate the program |

Together, `[` and `]` form a while loop.

## A Simple Example - Hello World

Below is a simple example of a Brainfuck program that outputs `Hello World!`, heavily annotated to explain how the program works.

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

## Implementations

All implementations in this repo roughly follow the original Brainfuck implementation:

- Non-wrapping memory tape of 30,000 wrapping (unsigned) byte-sized cells all initialized to `0`, with memory pointer initially pointing at leftmost cell
- When executing `,` command with input stream exhausted, a `0` byte is read into cell under memory pointer (at least) once - the behavior of subsequent reads is unspecified and may vary between different implementations

Furthermore, the behavior on invalid programs and memory pointer going out of bounds is (generally) unspecified and may vary between different implementations.

### PHP

| Path | Description |
| --- | --- |
| `php/function.brainfuck.php` | Brainfuck interpreter in PHP |
| `php/test_cases.php` | Test cases written using [PHPTester](https://github.com/DonaldKellett/PHPTester) |
| `php/progs/utm.b` | [Universal Turing Machine](https://en.wikipedia.org/wiki/Universal_Turing_machine) simulation in Brainfuck [by Daniel Cristofani](http://www.hevanet.com/cristofd/brainfuck/utm.b) |
| `php/PHPTester/` | Testing framework by @DonaldKellett (see [repo](https://github.com/DonaldKellett/PHPTester) for details) |

The function signature of the interpreter is as follows:

```php
string brainfuck(string $code[, string $input = ""])
```

Due to use of type annotations, PHP 7 or later is required.

### JavaScript

| Path | Description |
| --- | --- |
| `js/function.brainfuck.js` | Brainfuck interpreter in JavaScript |
| `js/proof.html` | Test runs using various Brainfuck programs |

Usage (with TypeScript-style type annotations):

```typescript
var output: string = brainfuck(code: string[, input: string = ""]);
```

### Netwide Assembler (for macOS only)

| Path | Description |
| --- | --- |
| `nasm-c/brainfuck.asm` | Brainfuck interpreter in NASM, for use with C |
| `nasm-c/example.c` | Unusual Hello World program in C implemented by executing an equivalent Brainfuck program, provided as an example use case of the interpreter |
| `nasm-c/proof.c` | Test runs of the interpreter using various Brainfuck programs |

Function signature in C:

```c
char *brainfuck(const char *code, const char *input);
```

To use the interpreter in your C development, first assemble `nasm-c/brainfuck.asm` as follows:

```bash
# Assemble brainfuck.asm (produces brainfuck.o object file)
# Note that NASM v2.x.x is required
$ nasm -fmacho64 brainfuck.asm
```

Then, in every C file where you need to use it, add the function signature shown above to the file concerned (see `nasm-c/example.c` for a minimal example). Finally, when compiling with e.g. `gcc`, just pass `brainfuck.o` along with the C files to be compiled. So, for `example.c`:

```bash
$ gcc example.c brainfuck.o
```

### Excel VBA (for Windows Microsoft Excel 2016)

| Path | Description |
| --- | --- |
| `excel-vba/Brainfuck.xlsm` | Macro-enabled spreadsheet containing Brainfuck interpreter |

To see the interpreter in action, simply open the spreadsheet, enable macros, and the rest should be self-explanatory. But just to be explicit here, enter your Brainfuck program in cell B1, the program input in cell B2 and click "Execute" to see the program output in cell B3.

### MIPS

| Path | Description |
| --- | --- |
| `mips/brainfuck.asm` | Brainfuck interpreter in MIPS (tested with [MARS](http://courses.missouristate.edu/KenVollmar/mars/)) with test runs using various Brainfuck programs |

Equivalent function signature in C assuming [standard MIPS calling convention](https://gist.github.com/internetsadboy/28d6862db63ecbbb2324):

```c
void brainfuck(const char *code, const char *input, char *output);
```

i.e. before `jal brainfuck`, `$a0` should contain a pointer to the beginning of the NUL-terminated Brainfuck program to be executed, `$a1` a pointer to the beginning of the NUL-terminated input stream and `$a2` a pointer to the beginning of a "large enough" writable character buffer. The program output written to the buffer pointed to by `$a2` is guaranteed to be NUL-terminated even if the Brainfuck program itself does not output a trailing `0`.

### Haskell

| Path | Description |
| --- | --- |
| `haskell/Brainfuck.hs` | Brainfuck interpreter in Haskell |
| `haskell/Main.hs` | Test cases written using [Hspec](https://hspec.github.io) |
| `haskell/progs/` | Brainfuck programs used for testing the interpreter |

Usage: `import Brainfuck` in your Haskell development gives you two variants of the Brainfuck interpreter:

```haskell
-- Standard usage
brainfuck (code :: String) (input :: String) :: Either String String
-- For programs that do not read user input (the empty input stream is passed to the program)
brainfuck' (code :: String) :: Either String String
```

The output `String` generated by the Brainfuck program is encapsulated in `Either String`, with `Left` values carrying error messages indicating whether it is a parse error (due to unmatched brackets) or runtime error (when dereferencing the memory pointer while out-of-bounds).

## License

[MIT License](./LICENSE)
