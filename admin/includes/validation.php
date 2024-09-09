<?php
function inputValidate($input){
    $input=trim($input);
    $input=strip_tags($input);
    $input=stripslashes($input);
    $input=strtolower($input);
    return $input;
}


// function checkMobNum($mobnum){
    // $monnumPattern='/^(011|010|015|012)[0-9]{7}$/';
    // $monnumPattern='/^(011|010|015|012)$/';
    // $monnumPattern='/a/';
    // return preg_match($mobnumPattern,$mobnum);
// }

function checkContactNumber($contactnumber){
    $contactnumberPattern='/^(011|010|015|012)[0-9]{8}$/';
    return preg_match($contactnumberPattern,$contactnumber);
}

function CheckPassword($password){
    // $passwordPattern= '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    // $passwordPattern='/1/';
    return preg_match($passwordPattern,$password);
}

function CheckPasswordMatch($password,$conf_pass){
    if ($conf_pass === $password) {
        return true;
    } else {
        return false;
    }
}

?>