.data

init: .asciiz "Running tests for void brainfuck(const char *code, const char *input, char *output) ... \n"
test1: .asciiz "1. CAT program with NUL terminator signifying EOF\n"
cat: .asciiz ",[.,]"
cat_input: .asciiz "CAT program"
output: .byte 0:1025
hello: .asciiz "++++++++[>++++[>++>+++>+++>+<<<<-]>+>+>->>+[<]<-]>>.>---.+++++++..+++.>>.<-.<.+++.------.--------.>>+.>++."
empty_input: .asciiz ""
hello2: .asciiz "++++sdlkfjsdklfjsdklfjdsfkl++++[>++++[>++>SDLKFJSDKLFJSKLFJSDFKLSJDFKLSJDF+++>+++>+<<<<-]>+>+>98237489234729834723894723894723894723894->>+[<]<-]>>.>---.+++++++..+++.>>.<-.<\n\n\r\n.+++.------.--------.>huehuehue>+.>\n\n\n\n\n++\t\t\t\t\t\t\t\t\t\t."
hello3: .asciiz ">++++++++[-<+++++++++>]<.>>+>-[+]++>++>+++[>[->+++<<+++>]<<]>-----.>->\n+++..+++.>-.<<+[>[+>+]>>]<--------------.>>.+++.------.--------.>+.>+."
test2: .asciiz "2. Hello World Program\n"
test3: .asciiz "3. Hello World Program (with comments)\n"
test4: .asciiz "4. Complex Hello World Program that often triggers interpreter bugs\n"
test5: .asciiz "5. Universal Turing Machine\n"
utm: .asciiz "+++>++>>>+[>>,[>+++++<[[->]<<]<[>]>]>-[<<+++++>>-[<<---->>-[->]<]]\n<[<-<[<]+<+[>]<<+>->>>]<]<[<]>[-[>++++++<-]>[<+>-]+<<<+++>+>\n  [-\n    [<<+>->-\n      [<<[-]>>-\n        [<<++>+>-\n          [<<-->->>+++<-\n            [<<+>+>>--<-\n              [<<->->-\n                [<<++++>+>>+<-\n                  [>-<-\n                    [<<->->-\n                      [<<->>-\n                        [<<+++>>>-<-\n                          [<<---->>>++<-\n                            [<<++>>>+<-\n                              [>[-]<-\n                                [<<->>>+++<-\n                                  [<<->>>--<-\n                                    [<<++++>+>>+<-\n                                      [<<[-]>->>++<-\n                                        [<<+++++>+>>--<-\n                                          [<->>++<\n                                            [<<->>-\n]]]]]]]]]]]]]]]]]]]]]]<[->>[<<+>>-]<<<[>>>+<<<-]<[>>>+<<<-]]>>]\n>[-[---[-<]]>]>[+++[<+++++>--]>]+<++[[>+++++<-]<]>>[-.>]"
utm_input: .asciiz "b1b1bbb1c1c11111d"
tape: .byte 0:30000
end: .asciiz "Summary: 5 test cases executed in total\n"

.text
.globl main, brainfuck

main:
    li $v0, 4
    la $a0, init
    syscall 
    
    li $v0, 4
    la $a0, test1
    syscall
    
    la $a0, cat
    la $a1, cat_input
    la $a2, output
    jal brainfuck
    
    li $v0, 4
    la $a0, output
    syscall
    
    li $v0, 11
    li $a0, 10
    syscall
    
    li $v0, 4
    la $a0, test2
    syscall
    
    la $a0, hello
    la $a1, empty_input
    la $a2, output
    jal brainfuck
    
    li $v0, 4
    la $a0, output
    syscall
    
    li $v0, 4
    la $a0, test3
    syscall
    
    la $a0, hello2
    la $a1, empty_input
    la $a2, output
    jal brainfuck
    
    li $v0, 4
    la $a0, output
    syscall
    
    li $v0, 4
    la $a0, test4
    syscall
    
    la $a0, hello3
    la $a1, empty_input
    la $a2, output
    jal brainfuck
    
    li $v0, 4
    la $a0, output
    syscall
    
    li $v0, 4
    la $a0, test5
    syscall
    
    la $a0, utm
    la $a1, utm_input
    la $a2, output
    jal brainfuck
    
    li $v0, 4
    la $a0, output
    syscall
    
    li $v0, 4
    la $a0, end
    syscall
    
    li $v0, 10
    syscall

brainfuck:
    addi $sp, $sp, -4
    sw $ra, 0($sp)
    addi $sp, $sp, -4
    sw $s0, 0($sp)
    la $s0, tape
    addi $t0, $zero, 30000
    tape_init:
        beq $t0, $zero, end_tape_init
        addi $t0, $t0, -1
        add $t1, $s0, $t0
        sb $zero, 0($t1)
        j tape_init
    end_tape_init:
    loop:
        lbu $t0, 0($a0)
        beq $t0, $zero, loop_end
        addi $t1, $zero, 43
        bne $t0, $t1, minus_case
        lbu $t0, 0($s0)
        addi $t0, $t0, 1
        sb $t0, 0($s0)
        j end_case
        minus_case:
        addi $t1, $zero, 45
        bne $t0, $t1, left_angle_bracket_case
        lbu $t0, 0($s0)
        addi $t0, $t0, -1
        sb $t0, 0($s0)
        j end_case
        left_angle_bracket_case:
        addi $t1, $zero, 60
        bne $t0, $t1, right_angle_bracket_case
        addi $s0, $s0, -1
        j end_case
        right_angle_bracket_case:
        addi $t1, $zero, 62
        bne $t0, $t1, dot_case
        addi $s0, $s0, 1
        j end_case
        dot_case:
        addi $t1, $zero, 46
        bne $t0, $t1, comma_case
        lbu $t0, 0($s0)
        sb $t0, 0($a2)
        addi $a2, $a2, 1
        j end_case
        comma_case:
        addi $t1, $zero, 44
        bne $t0, $t1, left_square_bracket_case
        lbu $t0, 0($a1)
        addi $a1, $a1, 1
        sb $t0, 0($s0)
        j end_case
        left_square_bracket_case:
        addi $t1, $zero, 91
        bne $t0, $t1, right_square_bracket_case
        lbu $t0, 0($s0)
        bne $t0, $zero, loop0_end
        addi $t0, $zero, 1
        loop0:
            addi $a0, $a0, 1
            lbu $t1, 0($a0)
            addi $t2, $zero, 91
            bne $t1, $t2, loop0_right_square_bracket_case
            addi $t0, $t0, 1
            j loop0_end_case
            loop0_right_square_bracket_case:
            addi $t2, $zero, 93
            bne $t1, $t2, loop0_end_case
            addi $t0, $t0, -1
            loop0_end_case:
            beq $t0, $zero, loop0_end
            j loop0
        loop0_end:
        j end_case
        right_square_bracket_case:
        addi $t1, $zero, 93
        bne $t0, $t1, end_case
        lbu $t0, 0($s0)
        beq $t0, $zero, end_case
        addi $t0, $zero, 1
        loop1:
            addi $a0, $a0, -1
            lbu $t1, 0($a0)
            addi $t2, $zero, 91
            bne $t1, $t2, loop1_right_square_bracket_case
            addi $t0, $t0, -1
            j loop1_end_case
            loop1_right_square_bracket_case:
            addi $t2, $zero, 93
            bne $t1, $t2, loop1_end_case
            addi $t0, $t0, 1
            loop1_end_case:
            beq $t0, $zero, end_case
            j loop1
        end_case:
        addi $a0, $a0, 1
        j loop
    loop_end:
    sb $zero, 0($a2)
    lw $s0, 0($sp)
    addi $sp, $sp, 4
    lw $ra, 0($sp)
    addi $sp, $sp, 4
    jr $ra