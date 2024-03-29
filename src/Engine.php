<?php

namespace Brain\Games\Engine;

use function cli\line;
use function cli\prompt;

function calculate($operand1, $operand2, $operator)
{
    $result = 0;

    if ($operator === '+') {
        $result = $operand1 + $operand2;
    } elseif ($operator === '-') {
        $result = $operand1 - $operand2;
    } elseif ($operator === '*') {
        $result = $operand1 * $operand2;
    }

    return (string) $result;
}

function greeting()
{
    line('Welcome to the Brain Game!');
    $name = prompt('May I have your name?');
    line("Hello, %s!", $name);

    return $name;
}

function compareAnswers($correctAnswer, $userAnswer, $userName)
{
    if ($correctAnswer === $userAnswer) {
        line("Your answer: {$userAnswer}");
        line("Correct!");
    } else {
        line("Your answer: {$userAnswer}");
        line("'{$userAnswer}' is wrong answer ;(. Correct answer was '{$correctAnswer}'");
        line("Let's try again, {$userName}!");
    }
}



function cycle($userName, $gameName)
{
    $operatorsList = ['+', '-', '*'];

    for ($i = 0; $i < 3; $i++) {
        //brain-even
        $randomNumber = rand(1, 20);
        //brain-gcd
        $randomNumber1 = rand(1, 20);
        $randomNumber2 = rand(1, 20);
        //brain-calc
        $divisibleNumber1 = rand(4, 200);
        $divisibleNumber2 = rand(4, 200);
        $operator = $operatorsList[rand(0, 2)];
        //brain-progression
        $result = [];
        $start = rand(2, 10);
        $step = rand(2, 5);
        $randomIndex = rand(0, 9);

        //Переменных с ответом пользователя ($userAnswer) и правильного ответа ($correctAnswer) в зависимости от игры
        if ($gameName === 'brain-even') {
            $correctAnswer = $randomNumber % 2 === 0 ? 'yes' : 'no';
            $userAnswer = prompt("Question: {$randomNumber}");
        } elseif ($gameName === 'brain-calc') {
            $correctAnswer = calculate($randomNumber1, $randomNumber2, $operator);
            $userAnswer = prompt("Question: {$randomNumber1} {$operator} {$randomNumber2}");
        } elseif ($gameName === 'brain-gcd') {
            $maxNum = max($divisibleNumber1, $divisibleNumber2);
            for ($y = 1; $y <= $maxNum; $y++) {
                if ($divisibleNumber1 % $y === 0 && $divisibleNumber2 % $y === 0) {
                    $correctAnswer = (string) $y;
                }
            }
            $userAnswer = prompt("Question: {$divisibleNumber1} {$divisibleNumber2}");
        } elseif ($gameName === 'brain-progression') {
            for ($z = 0, $x = $start; $z < 10; $z++, $x += $step) {
                $result[] = $x;
            }
            $correctAnswer = (string) $result[$randomIndex];
            $result[$randomIndex] = '..';
            $string = implode(' ', $result);
            $userAnswer = prompt("Question: {$string}");
        }

        //Вычисление правильный ли ответ, и вывод соответствующих сообщений в консоль
        compareAnswers($correctAnswer, $userAnswer, $userName);

        if ($correctAnswer !== $userAnswer) {
            break;
        }

        if ($i === 2) {
            line("Congratulations, {$userName}!");
        }
    }
}
