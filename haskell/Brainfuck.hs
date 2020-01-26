module Brainfuck (brainfuck, brainfuck') where

import Data.Char
import Control.Monad.Trans.Class
import Control.Monad.Trans.State.Strict
import qualified Data.IntMap.Strict as IntMap

-- EBNF for Brainfuck:
-- <program> ::= <command unit>*
-- <command unit> ::= '>' | '<' | '+' | '-' | '.' | ',' | '[' <program> ']'
data CommandUnit = PtrInc | PtrDec | CellInc | CellDec | PrintByte | ReadByte | WhileNonZero [CommandUnit]
type Program = [CommandUnit]

getSubProg' :: Int -> String -> Either String (String, String)
getSubProg' _ "" = Left "Parse error: Unmatched '[' detected"
getSubProg' unmatched (x : xs) = case x of
  '[' -> do
    (subProg', remain) <- getSubProg' (unmatched + 1) xs
    return ('[' : subProg', remain)
  ']' -> if unmatched == 0 then return ("", xs) else do
    (subProg', remain) <- getSubProg' (unmatched - 1) xs
    return (']' : subProg', remain)
  _ -> do
    (subProg', remain) <- getSubProg' unmatched xs
    return (x : subProg', remain)

getSubProg :: String -> Either String (String, String)
getSubProg = getSubProg' 0

parseProgStr :: String -> Either String Program
parseProgStr "" = return []
parseProgStr (x : xs) = case x of
  '>' -> do
    prog' <- parseProgStr xs
    return (PtrInc : prog')
  '<' -> do
    prog' <- parseProgStr xs
    return (PtrDec : prog')
  '+' -> do
    prog' <- parseProgStr xs
    return (CellInc : prog')
  '-' -> do
    prog' <- parseProgStr xs
    return (CellDec : prog')
  '.' -> do
    prog' <- parseProgStr xs
    return (PrintByte : prog')
  ',' -> do
    prog' <- parseProgStr xs
    return (ReadByte : prog')
  '[' -> do
    (subProg, remain) <- getSubProg xs
    loopBody <- parseProgStr subProg
    prog' <- parseProgStr remain
    return (WhileNonZero loopBody : prog')
  ']' -> Left "Parse error: Unmatched ']' detected"
  _ -> parseProgStr xs

execProgWithState :: StateT (Program, String, IntMap.IntMap Int, Int, String) (Either String) String
execProgWithState = do
  (prog, input, tape, ptr, output) <- get
  case prog of
    [] -> return (reverse output)
    PtrInc : prog' -> do
      put (prog', input, tape, ptr + 1, output)
      execProgWithState
    PtrDec : prog' -> do
      put (prog', input, tape, ptr - 1, output)
      execProgWithState
    CellInc : prog' -> if not (IntMap.member ptr tape) then lift (Left "Runtime error: Tape pointer out of bounds") else do
      put (prog', input, IntMap.adjust (\byte -> mod (byte + 1) 256) ptr tape, ptr, output)
      execProgWithState
    CellDec : prog' -> if not (IntMap.member ptr tape) then lift (Left "Runtime error: Tape pointer out of bounds") else do
      put (prog', input, IntMap.adjust (\byte -> mod (byte - 1) 256) ptr tape, ptr, output)
      execProgWithState
    PrintByte : prog' -> case IntMap.lookup ptr tape of
      Just byte -> do
        put (prog', input, tape, ptr, chr byte : output)
        execProgWithState
      Nothing -> lift (Left "Runtime error: Tape pointer out of bounds")
    ReadByte : prog' -> if not (IntMap.member ptr tape) then lift (Left "Runtime error: Tape pointer out of bounds") else
      case input of
        x : xs -> do
          put (prog', xs, IntMap.adjust (const (ord x)) ptr tape, ptr, output)
          execProgWithState
        "" -> do
          put (prog', "", IntMap.adjust (const 0) ptr tape, ptr, output)
          execProgWithState
    WhileNonZero loopBody : prog' -> case IntMap.lookup ptr tape of
      Just byte -> if byte == 0
        then do
          put (prog', input, tape, ptr, output)
          execProgWithState
        else do
          put (loopBody, input, tape, ptr, output)
          execProgWithState
          (_, input', tape', ptr', output') <- get
          put (prog, input', tape', ptr', output')
          execProgWithState
      Nothing -> lift (Left "Runtime error: Tape pointer out of bounds")

execProg :: Program -> String -> Either String String
execProg prog input = evalStateT execProgWithState (prog, input, foldl (\tape ptr ->
  IntMap.insert ptr 0 tape) IntMap.empty [0..29999], 0, "")

brainfuck :: String -> String -> Either String String
brainfuck code input = do
  prog <- parseProgStr code
  execProg prog input

brainfuck' :: String -> Either String String
brainfuck' code = brainfuck code ""
