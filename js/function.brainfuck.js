/*
  Brainfuck Interpreter
  (c) Donald Leung.  All rights reserved.
  MIT License
*/

function brainfuck(code, input = "") {
  // Sanitize BF code and store as program
  var program = code.replace(/[^<>+\-.,\[\]]/g, "");
  // Initialize 30,000 cells initially set to 0
  var array = Array(3e4).fill(0);
  // Start at cell #0
  var cellIndex = 0;
  // Initially read from the first character of the input if "," used
  var inputIndex = 0;
  // Initial output is empty
  var output = "";
  // Loop through each character of BF program
  for (var i = 0; i < program.length; i++) {
    switch (program[i]) {
      case ".":
      // Print the ASCII value at the current cell
      if (array[cellIndex] !== 0) output += String.fromCharCode(array[cellIndex]);
      break;
      case ",":
      // Read one character of input into the current cell
      array[cellIndex] = (input[inputIndex++] ? input[inputIndex - 1] : String.fromCharCode(0)).charCodeAt();
      break;
      case "+":
      // Increment the value at the current cell by 1.  If value exceeds 255 then loop back to 0
      array[cellIndex]++;
      if (array[cellIndex] > 255) array[cellIndex] -= 256;
      break;
      case "-":
      // Decrement the value at the current cell by 1.  If value drops below 0 then loop back to 255
      array[cellIndex]--;
      if (array[cellIndex] < 0) array[cellIndex] += 256;
      break;
      case ">":
      // Go to the next cell
      cellIndex++;
      break;
      case "<":
      // Go to the previous cell
      cellIndex--;
      break;
      case "[":
      if (array[cellIndex] === 0) {
        // An unmatched bracket found.  Skip forwards in the BF program until the matching (closing) bracket is found
        var unmatched = 1;
        while (unmatched > 0) {
          // Jump to the next character in the BF program
          i++;
          // If the next character is also an opening bracket, there is one more unmatched bracket
          if (program[i] === "[") unmatched++;
          // If the next character is a closing bracket then there is one less unmatched bracket
          if (program[i] === "]") unmatched--;
          // Otherwise, keep jumping to the next character until the matching closing bracket is found
        }
      }
      break;
      case "]":
      if (array[cellIndex] !== 0) {
        // Unmatched ending bracket found.  Read backwards in the BF program to find its matching opening bracket
        var unmatched = 1;
        while (unmatched > 0) {
          // Jump to the previous character in the BF program
          i--;
          // If the next character is an opening bracket then there is one less unmatched bracket
          if (program[i] === "[") unmatched--;
          // If the next character is an ending bracket then there is one more unmatched bracket
          if (program[i] === "]") unmatched++;
          // Otherwise, keep reading backwards in the BF program until the matching opening bracket is found
        }
      }
      break;
    }
  }
  // Return final output
  return output;
}
