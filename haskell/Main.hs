module Main where

import Brainfuck
import Test.Hspec
import Data.Char

main :: IO ()
main = hspec $ do
  describe "The Brainfuck Interpreter" $ do
    it "should print the string \"Hello World!\" for the example Hello World program provided in the README" $ do
      hello <- readFile "./progs/hello.b"
      brainfuck' hello `shouldBe` Right "Hello World!"
    it "should work for some other simple examples" $ do
      brainfuck ",+[-.,+]" ("Codewars" ++ [chr 255]) `shouldBe` Right "Codewars"
      brainfuck ",[.[-],]" ("Codewars" ++ [chr 0]) `shouldBe` Right "Codewars"
      let multiply = ",>,<[>[->+>+<<]>>[-<<+>>]<<<-]>>."
      brainfuck multiply [chr 8, chr 9] `shouldBe` Right [chr 72]
      brainfuck multiply [chr 9, chr 8] `shouldBe` Right [chr 72]
      brainfuck multiply [chr 3, chr 5] `shouldBe` Right [chr 15]
      brainfuck multiply [chr 4, chr 6] `shouldBe` Right [chr 24]
      brainfuck multiply [chr 7, chr 7] `shouldBe` Right [chr 49]
      brainfuck multiply [chr 13, chr 12] `shouldBe` Right [chr 156]
      brainfuck multiply [chr 15, chr 15] `shouldBe` Right [chr 225]
    it "should input 0 at the cell under the pointer when EOF is reached" $ do
      brainfuck ",[.,]" "Codewars" `shouldBe` Right "Codewars"
      brainfuck ",[.,]" "@donaldsebleung" `shouldBe` Right "@donaldsebleung"
      brainfuck ",[.,]" "brainfuck" `shouldBe` Right "brainfuck"
      brainfuck ",[.,]" "BF" `shouldBe` Right "BF"
      brainfuck ",[.,]" "Hspec" `shouldBe` Right "Hspec"
    it "should work for a few different Hello World programs" $ do
      hello2 <- readFile "./progs/hello-2.b"
      brainfuck' hello2 `shouldBe` Right "Hello World!"
      hello3 <- readFile "./progs/hello-3.b"
      brainfuck' hello3 `shouldBe` Right "Hello World!\n"
      hello4 <- readFile "./progs/hello-4.b"
      brainfuck' hello4 `shouldBe` Right "Hello World!\n"
      hello5 <- readFile "./progs/hello-5.b"
      brainfuck' hello5 `shouldBe` Right "Hello World!\n"
      hello6 <- readFile "./progs/hello-6.b"
      brainfuck' hello6 `shouldBe` Right "Hello, World!"
    it "should work for a Fibonacci program" $ do
      fib <- readFile "./progs/fib.b"
      brainfuck fib [chr 1] `shouldBe` Right "1"
      brainfuck fib [chr 2] `shouldBe` Right "1, 1"
      brainfuck fib [chr 3] `shouldBe` Right "1, 1, 2"
      brainfuck fib [chr 4] `shouldBe` Right "1, 1, 2, 3"
      brainfuck fib [chr 5] `shouldBe` Right "1, 1, 2, 3, 5"
      brainfuck fib [chr 6] `shouldBe` Right "1, 1, 2, 3, 5, 8"
      brainfuck fib [chr 7] `shouldBe` Right "1, 1, 2, 3, 5, 8, 13"
      brainfuck fib [chr 8] `shouldBe` Right "1, 1, 2, 3, 5, 8, 13, 21"
      brainfuck fib [chr 9] `shouldBe` Right "1, 1, 2, 3, 5, 8, 13, 21, 34"
      brainfuck fib [chr 10] `shouldBe` Right "1, 1, 2, 3, 5, 8, 13, 21, 34, 55"
    it "should work for Daniel B Cristofani's Universal Turing Machine (UTM) simulation" $ do
      utm <- readFile "./progs/utm.b"
      brainfuck utm "b1b1bbb1c1c11111d" `shouldBe` Right "1c11111\n"
    it "should report a parse error if unmatched brackets are detected" $ do
      brainfuck' "[" `shouldBe` Left "Parse error: Unmatched '[' detected"
      brainfuck' "]" `shouldBe` Left "Parse error: Unmatched ']' detected"
      brainfuck' "][" `shouldBe` Left "Parse error: Unmatched ']' detected"
      brainfuck' "[]" `shouldBe` Right ""
      brainfuck' "[]]]]]]]]]][[[[[[[[[[]" `shouldBe` Left "Parse error: Unmatched ']' detected"
    it "should report a runtime error if the pointer is dereferenced when out of bounds" $ do
      brainfuck' "<." `shouldBe` Left "Runtime error: Tape pointer out of bounds"
      brainfuck' "+[>+]" `shouldBe` Left "Runtime error: Tape pointer out of bounds"
      brainfuck' "-[>-]" `shouldBe` Left "Runtime error: Tape pointer out of bounds"
    it "should work for a few bizzare edge cases" $ do
      brainfuck' (replicate 103496 '+' ++ ".") `shouldBe` Right "H"
      brainfuck' (replicate 117944 '-' ++ ".") `shouldBe` Right "H"
      brainfuck' (replicate 117944 '-' ++ replicate 93 '.') `shouldBe` Right (replicate 93 'H')
