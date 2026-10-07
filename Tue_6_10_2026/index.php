<?php //1

$colors = array("red", "green", "blue", "yellow");

echo "<ul>";
echo "<li style='color: $colors[0]'>$colors[0]</li>";
echo "<li style='color: $colors[1]'>$colors[1]</li>";
echo "<li style='color: $colors[2]'>$colors[2]</li>";
echo "<li style='color: $colors[3]'>$colors[3]</li>";
echo "</ul>";

?>

<?php //2

$cities = array(
    "Italy" => "Rome",
    "Luxembourg" => "Luxembourg",
    "Belgium" => "Brussels",
    "Denmark" => "Copenhagen",
    "Finland" => "Helsinki",
    "France" => "Paris",
    "Slovakia" => "Bratislava",
    "Slovenia" => "Ljubljana",
    "Germany" => "Berlin",
    "Greece" => "Athens",
    "Ireland" => "Dublin",
    "Netherlands" => "Amsterdam",
    "Portugal" => "Lisbon",
    "Spain" => "Madrid"
);

echo "the capital of Netherlands is " . $cities['Netherlands'] . "<br>";
echo "the capital of Greece is " . $cities['Greece'] . "<br>";
echo "the capital of Germany is " . $cities['Germany'] . "<br>";

?>

<?php //3

$color = array(
    4 => 'white',
    6 => 'green',
    11 => 'red'
);

echo "{$color[4]} <br>";

?>

<?php //4

$numbers = [1, 2, 3, 4, 5];
$position = 2;

echo "{$numbers[$position]}<br>";

$input = 13;

array_splice($numbers, $position, 0, $input);

echo "{$numbers[$position]}<br>";

?>

<?php //5

$fruits = array(
    "d" => "lemon",
    "a" => "orange",
    "b" => "banana",
    "c" => "apple"
);

if (asort($fruits)) {
    echo "The array is sorted in ascending order.<br>";
}

?>

<?php //6

$temperatures = [
    78, 60, 62, 68, 71, 68, 73, 85, 66, 64,
    76, 63, 75, 76, 73, 68, 62, 73, 72, 65,
    74, 62, 62, 65, 64, 68, 73, 75, 79, 73
];

$average = array_sum($temperatures) / count($temperatures);

sort($temperatures);

$lowest = array_slice($temperatures, 0, 5);
$highest = array_slice($temperatures, -5);

echo "Average Temperature is: " . round($average, 2) . "<br>";

echo "List of five lowest temperatures: ";
echo implode(", ", $lowest);

echo "<br>";

echo "List of five highest temperatures: ";
echo implode(", ", $highest);

?>

<?php //7

$array1 = array(
    "color" => "red",
    2,
    4
);

$array2 = array(
    "a",
    "b",
    "color" => "green",
    "shape" => "trapezoid",
    4
);

echo "<br>";

$result = array_merge($array1, $array2);

print_r($result);

?>

<?php //8

echo "<br>";

function ConvertToUpperCase($colors)
{
    foreach ($colors as $color) {
        $color = strtoupper($color);
    }

    return $colors;
}

$colors = array("red", "blue", "white", "yellow");

$result = ConvertToUpperCase($colors);

print_r($result);

?>

<?php //9

echo "<br>";

function IsPrime($number)
{
    for ($i = 2; $i < $number; $i++) {

        if ($number % $i == 0 || $number == 2) {

            echo "$number is not a prime number.<br>";
            return false;
        }
    }

    echo "$number is a prime number.<br>";
    return true;
}

IsPrime(1);

?>

<?php //10

echo "<br>";

$string = "Anas";

echo strrev($string);

?>

<?php //11

echo "<br>";

function Swap(&$x, &$y)
{
    $x = $x + $y;
    $y = $x - $y;
    $x = $x - $y;
}

$a = 5;
$b = 10;

Swap($a, $b);

echo "After swapping: a = $a, b = $b";

?>

<?php //12

echo "<br>";

function Armstrong($number)
{
    $sum = 0;

    for ($i = 1; $i < strlen($number); $i++) {

        $digit = (int)$number[$i];

        $sum += pow($digit, strlen($number));
    }

    if ($sum == $number) {

        echo "$number is an Armstrong number.<br>";

    } else {

        echo "$number is not an Armstrong number.<br>";
    }
}

?>

<?php //13

echo "<br>";

function palindrome($string)
{
    $string = strtolower($string);

    $string = preg_replace('/[^0-9a-z]/', "", $string);

    $revearse = strrev($string);

    if ($string == $revearse) {

        echo "$string is a palindrome.<br>";

    } else {

        echo "$string is not a palindrome.<br>";
    }
}

palindrome("Ana");

?>

<?php //14

echo "<br>";

function removeDuplicates($array)
{
    return array_unique($array);
}

$array1 = array(2, 4, 7, 4, 8, 4);

$array1 = removeDuplicates($array1);

print_r($array1);

?>

<?php //15

echo "<br>";

function checkSum($firstInteger, $secondInteger)
{
    $sum = $firstInteger + $secondInteger;

    if ($sum == 30) {
        return $sum;
    } else {
        return false;
    }
}

$result = checkSum(10, 10);

var_dump($result);

?>

<?php //16

echo "<br>";

function isMultipleOfThree($number)
{
    if ($number % 3 == 0) {
        return true;
    } else {
        return false;
    }
}

var_dump(isMultipleOfThree(20));

?>

<?php //17

echo "<br>";

function checkRange($number)
{
    if ($number >= 20 && $number <= 50) {
        return true;
    } else {
        return false;
    }
}

var_dump(checkRange(50));

?>

<?php //18

echo "<br>";

$numbers = array(1, 5, 9);

$largest = max($numbers);

echo $largest;

?>

<?php //19

echo "<br>";

function calculateBill($units)
{
    if ($units <= 50) {

        $bill = $units * 2.50;

    } elseif ($units <= 150) {

        $bill = (50 * 2.50) + (($units - 50) * 5.00);

    } elseif ($units <= 250) {

        $bill = (50 * 2.50)
              + (100 * 5.00)
              + (($units - 150) * 6.20);

    } else {

        $bill = (50 * 2.50)
              + (100 * 5.00)
              + (100 * 6.20)
              + (($units - 250) * 7.50);
    }

    return $bill;
}

echo calculateBill(200);

?>




<?php //20
echo "</br>";

function calculator($num1, $num2, $operator)
{
    switch ($operator) {

        case "+":
            return $num1 + $num2;

        case "-":
            return $num1 - $num2;

        case "*":
            return $num1 * $num2;

        case "/":
            if ($num2 != 0) {
                return $num1 / $num2;
            } else {
                return "Cannot divide by zero";
            }

        default:
            return "Invalid operator";
    }
}

echo calculator(10, 5, "+");

?>


<?php //21
echo "</br>";

function checkVotingEligibility($age)
{
    if ($age >= 18) {
        return "is eligible to vote";
    } else {
        return "is not eligible to vote";
    }
}

echo checkVotingEligibility(15);

?>



<?php //22
echo "</br>";

function checkNumber($number)
{
    if ($number > 0) {
        return "Positive";
    } elseif ($number < 0) {
        return "Negative";
    } else {
        return "Zero";
    }
}

echo checkNumber(-60);

?>


<?php//23
echo "</br>";

for ($i = 1; $i <= 10; $i++) {

    echo $i;

    if ($i < 10) {
        echo "-";
    }
}

?>


<?php//24
echo "</br>";

$total = 0;

for ($i = 0; $i <= 30; $i++) {
    $total += $i;
}

echo $total;

?>


<?php//25
    echo "</br>";
for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 5; $j++) {
        if ($j < 4 - $i) {
            echo "A ";
        } else {
            echo chr(65 + $i) . " ";   // A, B, C, D, E
        }
    }
    echo "<br>";
}
?>


<?php //26

for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 5; $j++) {
        if ($j < 4 - $i) {
            echo "1 ";
        } else {
            echo ($i + 1) . " ";
        }
    }
    echo "<br>";
}
?>



<?php //27
for ($i = 0; $i < 5; $i++) {
    for ($j = 0; $j < 5; $j++) {
        if ($i == $j) {
            echo ($i + 1) . " ";
        } else {
            echo "0 ";
        }
    }
    echo "<br>";
}
?>

<?php //28
$number = 5;         
$factorial = 1;

for ($i = 1; $i <= $number; $i++) {
    $factorial *= $i;
}

echo "Factorial of $number = $factorial";   

  echo "<br>";
?>


<?php
$str = "hello world from php";

echo strtoupper($str) . "<br>";   
echo strtolower($str) . "<br>";   
echo ucfirst($str) . "<br>";      
echo ucwords($str) . "<br>";    

  echo "<br>";
?>


<?php
echo implode(":", str_split('085119', 2));
  echo "<br>";
?>



<?php
$sentence = 'I am a full stack developer at orange coding academy';
$word = 'Orange';

if (stripos($sentence, $word) !== false) {
    echo "Word Found!";
} else {
    echo "Word Not Found!";
}
  echo "<br>";
?>


<?php
$url = 'www.orange.com/index.php';

echo basename($url);   
  echo "<br>";
?>


<?php
$email = 'info@orange.com';

echo strstr($email, '@', true);  
?>

<?php
$email = 'info@orange.com';

echo substr($email, -3);   
?>


<?php
$sentence = 'That new trainee is so genius.';
$newWord = 'Our';

$words = explode(" ", $sentence);
$words[0] = $newWord;

echo implode(" ", $words);   
?>