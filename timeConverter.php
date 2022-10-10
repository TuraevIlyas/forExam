<?php
//messages
$messageGreeting = "Hello, here you can find out time in your LOVELY cities!!!";
$messageInputName = "Enter city (starts with capital letter) from list and time (without ':') -> ";

//variables
$cityChooseArray = [["Helsinki", 1], ["Ufa", 3], ["Florida", -4]];//List of our cities and time zones depending on Greenwich
/*
    TODO: $array = [
        'Hes' => 1 ]
*/

//Checking correct value input
function checkInputCityNameAndTime($inputVariable): bool
{
    global $cityChooseArray; //get array from variable

    $inputVariable = explode(" ", $inputVariable); //inputVariable[0]=cityName, inputVariable[1]=timeNumber
    $inputVariable = array_diff($inputVariable, array('', NULL, false));

    if (empty($inputVariable)) {
        echo "It is empty";
        return false;
    }

    // TODO: $value = $another_value ? $another_another_value : $value;
    //Get names of cities for further checking
    foreach ($cityChooseArray as $city) {
        $cityNamesInDatabase[] = $city[0];
    }

    // TODO: different errors of different type of inputs
    if (!in_array($inputVariable[0], $cityNamesInDatabase)) {
        echo "There is no such city";
        return false;
    }

    if (!isset($inputVariable[0])) {
        echo "Did not enter city";
        return false;
    }

    if (count($inputVariable) == 2) {
        if($inputVariable[1][0] == "+" or $inputVariable[1][0]){
            echo "Wrong format input";
            return false;
        }

        if (!is_numeric($inputVariable[1])) {
            echo "You entered word instead time";
            return false;
        }
        if (strlen($inputVariable[1]) != 4) {
            echo "Time consist of 4 digits";
            return false;
        }

        if (!in_array(intval(($inputVariable[1] / 100)), range(0, 23)) or !in_array(($inputVariable[1] % 100), range(0, 59))) {
            echo "Wrong time format";
            return false;
        }
    } else {
        echo "Should be 2 words";
        return false;
    }

    return true;
}

//Changing time function
function convertTime($inputCityAndTime): bool
{
    global $cityChooseArray; //get array from variable

    if (!checkInputCityNameAndTime($inputCityAndTime)) {
        return false;
    }

    $inputCityAndTime = explode(" ", $inputCityAndTime); //inputVariable[0]=cityName, inputVariable[1]=timeNumber

    //Enter required city's time zone from array into variable
    foreach ($cityChooseArray as $city) {
        if ($city[0] == $inputCityAndTime[0]) {
            $ourCityTimeZone = $city[1];
        }
    }

    //Output cities and their times
    foreach ($cityChooseArray as $city) {
        if ($city[0] != $inputCityAndTime[0]) {
            $hoursInput = intval((($inputCityAndTime[1] - ($ourCityTimeZone - $city[1]) * 100) % 2400) / 100);
            if ($hoursInput < 0 and $inputCityAndTime[1] % 100 == 0) {
                echo $city[0] . " - " . (24 + $hoursInput) . ":";
            } elseif ($hoursInput < 0) {
                echo $city[0] . " - " . (23 + $hoursInput) . ":";
            } else {
                echo $city[0] . " - " . $hoursInput . ":";
            }
            echo substr($inputCityAndTime[1], 2) . PHP_EOL;
        }
    }
    return true;
}

//Output list of cities
echo $messageGreeting . PHP_EOL;
foreach ($cityChooseArray as $city) {
    echo "          * " . $city[0] . PHP_EOL;
}

do {
    do {
//Input city and time
        echo PHP_EOL . $messageInputName;
        $everythingGood = convertTime($inputCityAndTime = readline());
    } while (!$everythingGood);
} while (true);