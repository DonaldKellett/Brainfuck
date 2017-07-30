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
  // Group consecutive "+"s, "-"s, "<"s, ">"s and "."s
  $code = preg_replace_callback('/\+{2,}|\-{2,256}|<{2,}|>{2,}|\.{2,}/', function ($m) {return $m[0][0] . strlen($m[0]);}, $code);
  $temp = [];
  preg_match_all('/[+\-<>.]\d*|[,\[\]]/', $code, $temp);
  $code = $temp[0];
  // Precompute jumps using jump map
  $jump_map = [];
  for ($i = 0; $i < count($code); $i++) {
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
  $tape = array_fill(0, 3e4, 0);
  $pointer = 0;
  $output = '';
  $j = 0;
  for ($i = 0; $i < count($code); $i++) {
    switch ($code[$i][0]) {
      case '[':
      if ($tape[$pointer] == 0) $i = $jump_map[$i];
      break;
      case ']':
      if ($tape[$pointer] != 0) $i = array_search($i, $jump_map);
      break;
      case ',':
      $tape[$pointer] = isset($input[$j]) ? ord($input[$j++]) : 0;
      break;
      case '+':
      if (strlen($code[$i]) == 1) $tape[$pointer] = ($tape[$pointer] + 1) % 256;
      else $tape[$pointer] = ($tape[$pointer] + intval(substr($code[$i], 1))) % 256;
      break;
      case '-':
      if (strlen($code[$i]) == 1) $tape[$pointer] = ($tape[$pointer] + 255) % 256;
      else $tape[$pointer] = ($tape[$pointer] + 256 - intval(substr($code[$i], 1))) % 256;
      break;
      case '<':
      if (strlen($code[$i]) == 1) {
        if (!isset($tape[--$pointer])) throw new OutOfBoundsException('Your memory pointer moved too far to the left!');
      } else {
        if (!isset($tape[$pointer -= intval(substr($code[$i], 1))])) throw new OutOfBoundsException('Your memory pointer moved too far to the left!');
      }
      break;
      case '>':
      if (strlen($code[$i]) == 1) {
        if (!isset($tape[++$pointer])) throw new OutOfBoundsException('Your memory pointer moved too far to the right!');
      } else {
        if (!isset($tape[$pointer += intval(substr($code[$i], 1))])) throw new OutOfBoundsException('Your memory pointer moved too far to the right!');
      }
      break;
      case '.':
      if (strlen($code[$i]) == 1) $output .= chr($tape[$pointer]);
      else $output .= str_repeat(chr($tape[$pointer]), intval(substr($code[$i], 1)));
      break;
    }
  }
  return $output;
}

?>
