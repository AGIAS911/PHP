
<?php
$str = "Twinkle, twinkle, little star.";

$arr = explode(",", $str);
var_dump($arr);
?>



<?php
$char = 'a';

if ($char == 'z') {
    echo 'a';
} elseif ($char == 'Z') {
    echo 'A';
} else {
    echo chr(ord($char) + 1);
}
?>


<?php
$original = 'The brown fox';
$insert = 'quick ';
$position = 4;   

echo substr_replace($original, $insert, $position, 0);
?>


<?php
$sentence = 'The quick brown fox';

echo strtok($sentence, ' ');   
?>

<?php
$str = '0000657022.24';

echo ltrim($str, '0');   
?>



<?php
$str = 'The quick brown fox jumps over the lazy dog---';

echo rtrim($str, '-');
?>



<?php
$str = 'The quick brown fox jumps over the lazy dog';

$words = explode(" ", $str);
$first5 = array_slice($words, 0, 5);

echo implode(" ", $first5); 
?>


<?php
$str = '2,543.12';

echo str_replace(',', '', $str); 
?>



<?php
$n = 10;         
$a = 0;
$b = 1;

for ($i = 0; $i < $n; $i++) {
    echo $a;
    if ($i < $n - 1) echo ", ";

    $next = $a + $b;
    $a = $b;
    $b = $next;
}
?>



<?php
$n = 5;           
$num = 1;

for ($i = 1; $i <= $n; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo $num . " ";
        $num++;
    }
    echo "<br>";
}
?>


<?php
$n = 5;

for ($i = 1; $i <= $n; $i++) {
    echo str_repeat("&nbsp;&nbsp;", $n - $i);   
    for ($j = 0; $j < $i; $j++) {
        echo chr(65 + $j) . "&nbsp;";
    }
    echo "<br>";
}


for ($i = $n - 1; $i >= 1; $i--) {
    echo str_repeat("&nbsp;&nbsp;", $n - $i);
    for ($j = 0; $j < $i; $j++) {
        echo chr(65 + $j) . "&nbsp;";
    }
    echo "<br>";
}
?>



<?php
$year = 2013;

if (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) {
    echo "This year is a leap year";
} else {
    echo "This year is not a leap year";
}
?>



<?php
$temp = 27;

if ($temp < 20) {
    echo "It is wintertime!";
} else {
    echo "It is summertime!";
}
?>



<?php
$firstInteger = 2;
$secondInteger = 2;

$sum = $firstInteger + $secondInteger;

if ($firstInteger == $secondInteger) {
    echo "( $firstInteger + $secondInteger ) * 3 = " . ($sum * 3);
} else {
    echo "$firstInteger + $secondInteger = $sum";
}
?>



<?php
$result = [];

for ($i = 200; $i <= 250; $i++) {
    if ($i % 4 == 0) {
        $result[] = $i;
    }
}

echo implode(",", $result);


?>



<?php
$min = 11;
$max = 20;

$numbers = range($min, $max);   
shuffle($numbers);            

echo implode(" ", array_slice($numbers, 0, 10));
?>