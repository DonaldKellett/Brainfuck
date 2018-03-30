;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
; brainfuck.asm                                                           ;
;                                                                         ;
; A Brainfuck interpreter written in NASM v2.13.03 for Mac OS X,          ;
; for use in C programs                                                   ;
;                                                                         ;
; Function signature:                                                     ;
; char *brainfuck(const char *code, const char *input)                    ;
;                                                                         ;
; Interpreter details:                                                    ;
; - 30000 wrapping 8-bit cells as per the original implementation         ;
; - All cells initialized to 0 at the beginning of program execution      ;
; - Tape pointer starts from the leftmost cell                            ;
; - Memory tape is *not* toroidal - an out of bounds memory pointer will  ;
; likely crash the program                                                ;
; - EOF is denoted by the NULL terminator (i.e. byte(0))                  ;
;                                                                         ;
; Additional implementation details:                                      ;
; - Output buffer is allocated statically, not dynamically                ;
; - Maximum output allowed is 1024 bytes = 1 kB, not including the        ;
; NULL terminator.  Exceeding this output limit causes undefined behavior ;
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;

global _brainfuck
section .text
_brainfuck:
  lea r10, [rel memtape] ; r10 <- memtape
  mov r11, 0 ; r11 <- 0 (no. of cells reset to byte(0))
reset:
  mov byte [r10], 0 ; *r10 <- byte(0)
  inc r10 ; r10++
  inc r11 ; Keep track of no. of memory cells reset to byte(0)
  cmp r11, 30000 ; Have we reset all 30000 cells to byte(0) yet?
  jl reset ; If not, reset the next memory cell to byte(0)
  lea r10, [rel memtape] ; Initially tape pointer starts at leftmost cell
  lea rax, [rel stdout] ; rax <- stdout (value to be returned is output buffer)
execToken:
  cmp byte [rdi], 0 ; Have we reached the end of the program?
  je done ; If so, go straight to returning the output buffer
  cmp byte [rdi], '+' ; *code == '+'?
  je incCellVal ; If so, increment current cell value under tape pointer
  cmp byte [rdi], '-' ; *code == '-'?
  je decCellVal ; If so, decrement current cell value under tape pointer
  cmp byte [rdi], '>' ; *code == '>'?
  je incTapePtr ; If so, move tape pointer to next cell
  cmp byte [rdi], '<' ; *code == '<'?
  je decTapePtr ; If so, move tape pointer to previous cell
  cmp byte [rdi], '.' ; *code == '.'?
  je printCellVal ; If so, print byte in current cell under tape pointer to stdout
  cmp byte [rdi], ',' ; *code == ','?
  je writeCellVal ; If so, write current input byte into cell under tape pointer
  cmp byte [rdi], '[' ; *code == '['?
  je openWhile ; If so, check value of cell under pointer against zero and make a decision accordingly
  cmp byte [rdi], ']' ; *code == ']'?
  je closeWhile ; If so, check value of cell under pointer against zero and make a decision accordingly
  jmp nextToken ; Otherwise, current character is a no-op; skip it
incCellVal:
  inc byte [r10] ; (*memtape)++
  jmp nextToken
decCellVal:
  dec byte [r10] ; (*memtape)--
  jmp nextToken
incTapePtr:
  inc r10 ; memtape++
  jmp nextToken
decTapePtr:
  dec r10 ; memtape--
  jmp nextToken
printCellVal:
  mov r12b, byte [r10] ; temp <- *memtape
  mov byte [rax], r12b ; *stdout <- temp
  inc rax ; stdout++
  jmp nextToken
writeCellVal:
  cmp byte [rsi], 0 ; Have we reached the end of input yet?
  jne normalWrite ; If not, set value of cell under tape pointer to
  ; current input byte and move input pointer to next input byte
  ; Otherwise, write value of 0 to cell under pointer
  mov byte [r10], 0 ; *memtape <- 0
  jmp nextToken
normalWrite:
  mov r12b, byte [rsi] ; temp <- *input
  mov byte [r10], r12b ; *memtape <- temp
  inc rsi ; input++
  jmp nextToken
openWhile:
  cmp byte [r10], 0 ; Is the value under the pointer zero?
  jne nextToken ; If not, simply ignore this command
  ; Otherwise, jump to the matching ]
  mov r13, 1 ; unmatched <- 1 (we now have one unmatched opening bracket)
checkNextCmdForMatchingCloseBracket:
  inc rdi ; code++
  cmp byte [rdi], '[' ; Is the next command an opening bracket?
  je incUnmatchedOpenBracket ; If so, we now have one more unmatched opening bracket
  cmp byte [rdi], ']' ; Is the next command a closing bracket?
  je decUnmatchedOpenBracket ; If so, we now have one less unmatched opening bracket
  jmp checkNextCmdForMatchingCloseBracket ; Otherwise, keep searching
incUnmatchedOpenBracket:
  inc r13 ; unmatched++
  jmp checkNextCmdForMatchingCloseBracket ; Keep searching
decUnmatchedOpenBracket:
  dec r13 ; unmatched--
  cmp r13, 0 ; Have we found our matching closing bracket yet?
  jne checkNextCmdForMatchingCloseBracket ; If not, keep searching
  jmp nextToken ; Otherwise, proceed to the next command as usual
closeWhile:
  cmp byte [r10], 0 ; Is the value under the pointer zero?
  je nextToken ; If so, simply ignore this command
  ; Otherwise, jump back to the matching [
  mov r13, 1 ; unmatched <- 1 (we now have an unmatched closing bracket)
checkPrevCmdForMatchingOpenBracket:
  dec rdi ; code--
  cmp byte [rdi], '[' ; Is the previous command an open bracket?
  je decUnmatchedClosedBracket ; If so, we now have one less unmatched closing bracket
  cmp byte [rdi], ']' ; Is the previous command a closed bracket?
  je incUnmatchedClosedBracket ; If so, we now have one more unmatched closing bracket
  jmp checkPrevCmdForMatchingOpenBracket ; Otherwise, keep searching
decUnmatchedClosedBracket:
  dec r13 ; unmatched--
  cmp r13, 0 ; Have we found our matching opening bracket yet?
  jne checkPrevCmdForMatchingOpenBracket ; If not, keep searching
  jmp nextToken ; Otherwise, proceed to the next command as usual
incUnmatchedClosedBracket:
  inc r13 ; unmatched++
  jmp checkPrevCmdForMatchingOpenBracket ; Keep searching
nextToken:
  inc rdi ; code++
  jmp execToken ; Execute the next command
done:
  mov byte [rax], 0 ; Insert null terminator at end of output buffer
  lea rax, [rel stdout] ; Reset rax to beginning of output buffer before returning
  ret ; return rax

section .bss
memtape resb 30000
stdout resb 1025
