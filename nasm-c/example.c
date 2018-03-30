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
