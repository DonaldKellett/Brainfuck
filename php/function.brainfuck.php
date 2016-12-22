<?php

/*
  Brainfuck Interpreter
  (c) Donald Leung.  All rights reserved.
  MIT License
*/

function brainfuck(string $code, string $input = ""): string {
  // Sanitize BF code and store as program
  $program = preg_replace('/[^<>+\-.,\[\]]/', "", $code);
  // Initialize 30,000 cells initially set to 0
  $array = array_fill(0, 3e4, 0);
  // Start at cell #0
  $cell_index = 0;
  // Initially read from the first character of the input if "," used
  $input_index = 0;
  // Initial output is empty
  $output = "";
  // Loop through each character of the BF program
  for ($i = 0; $i < strlen($program); $i++) {
    switch ($program[$i]) {
      case ".":
      // Print the ASCII value at the current cell
      if ($array[$cell_index] !== 0) $output .= chr($array[$cell_index]);
      break;
      case ",":
      // Read 1 character from the input and store it in the current cell
      $array[$cell_index] = ord($input[$input_index++]);
      break;
      case "+":
      // Increase the value of the current cell by 1.  If value exceeds 255 then loop back to 0
      $array[$cell_index]++;
      if ($array[$cell_index] > 255) $array[$cell_index] -= 256;
      break;
      case "-":
      // Decrease the value of the current cell by 1.  If value is below 0 then loop back to 255
      $array[$cell_index]--;
      if ($array[$cell_index] < 0) $array[$cell_index] += 256;
      break;
      case ">":
      // Move to the next cell
      $cell_index++;
      break;
      case "<":
      // Move to the previous cell
      $cell_index--;
      break;
      case "[":
      if ($array[$cell_index] === 0) {
        // Unmatched opening bracket found.  Jump forwards in the BF program until matching closing bracket found
        $unmatched = 1;
        while ($unmatched > 0) {
          // Jump to next character in BF program
          $i++;
          // If next character is opening bracket then there is one more unmatched
          if ($program[$i] === "[") $unmatched++;
          // If next character is closing bracket then there is one less unmatched
          if ($program[$i] === "]") $unmatched--;
          // Else continue this process until matching closing bracket found
        }
      }
      break;
      case "]":
      if ($array[$cell_index] !== 0) {
        // Unmatched closing bracket found.  Read backwards in the BF program until matching opening bracket found
        $unmatched = 1;
        while ($unmatched > 0) {
          // Jump backwards 1 character in the BF program
          $i--;
          // If previous character is opening bracket then one less unmatched
          if ($program[$i] === "[") $unmatched--;
          // If previous character is closing bracket then one more unmatched
          if ($program[$i] === "]") $unmatched++;
          // Else continue process until matching opening bracket found
        }
      }
      break;
    }
  }
  // Return final output
  return $output;
}

?>
