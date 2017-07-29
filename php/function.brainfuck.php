<?php

/*
  Brainfuck Interpreter
  (c) Donald Leung
  MIT License
*/

function brainfuck(string $code, string $input = ""): string {
  // Bracket validation - throw ParseError if unmatched brackets detected
  $brackets_only = preg_replace('/[^\[\]]/', '', $code);
  while (preg_match('/\[\]/', $brackets_only)) $brackets_only = preg_replace('/\[\]/', '', $brackets_only);
  if (!empty($brackets_only)) throw new ParseError('Unmatched brackets were detected in your Brainfuck program!');
  // Remove all non-command characters from the program
  $code = preg_replace('/[^+\-.,<>\[\]]/', '', $code);
  // Construct jump map to precompute jumps
  $jump_map = [];
  for ($i = 0; $i < strlen($code); $i++) {
    if ($code[$i] === '[') {
      $unmatched = 1;
      $temp = 0;
      while ($unmatched > 0) {
        $temp++;
        if ($code[$i + $temp] === '[') $unmatched++;
        elseif ($code[$i + $temp] === ']') $unmatched--;
      }
      $jump_map[$i] = $i + $temp;
    }
  }
  // Now the interpreting starts :D
  $output = '';
  $tape = array_fill(0, 3e4, 0);
  $pointer = 0;
  $j = 0;
  for ($i = 0; $i < strlen($code); $i++) {
    switch ($code[$i]) {
      case '.':
      $output .= chr($tape[$pointer]);
      break;
      case ',':
      $tape[$pointer] = isset($input[$j]) ? ord($input[$j++]) : 0;
      break;
      case '>':
      if (!isset($tape[++$pointer])) throw new OutOfBoundsException('Your memory pointer went too far to the right (rightmost cell of memory tape: cell #29999)!');
      break;
      case '<':
      if (!isset($tape[--$pointer])) throw new OutOfBoundsException('Your memory pointer moved leftwards beyond the first cell (cell #0)!');
      break;
      case '+':
      $tape[$pointer] = ($tape[$pointer] + 1) % 256;
      break;
      case '-':
      $tape[$pointer] = ($tape[$pointer] + 255) % 256;
      break;
      case '[':
      if ($tape[$pointer] === 0) $i = $jump_map[$i];
      break;
      case ']':
      if ($tape[$pointer] !== 0) $i = array_search($i, $jump_map);
      break;
    }
  }
  return $output;
}

?>
