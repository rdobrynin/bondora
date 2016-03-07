<?php

/**
 * function test_function
 * @author Joe Shmoe
 */

if (is_ajax()) {
    if (isset($_POST["action"]) && !empty($_POST["action"])) {
        $action = $_POST["action"];
        switch($action) {
            case "test": test_function(); break;
        }
    }
}

/**
 * Function to check if the request is an AJAX request
 * @return bool
 */
function is_ajax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

/**
 * Base function
 * @author Roman Dobrynin
 */


function test_function(){
    $emailError = $loanError = '';
    $email = trim($_POST["email"]);
    $loan = trim(intval($_POST["loan"]));

    if (!empty($email)) {
        if (!validate_email_address($email)) {
            $email = 'Email address is not valid';
        }
    } else {
        $email = false;
        $emailError = 'Email address must not be empty';
    }

    if ($loan < 1) {
      $loan = false;
        $loanError = 'Loan must be more than 0';
    }


    $return["email"] = $email;
    $return["emailError"] = $emailError;
    $return["loan"] =  $loan;
    $return["loanError"] =  $loanError;
    echo json_encode($return);
}

/**
 * Validate email address
 * @param $email
 * @return bool
 */


function validate_email_address($email) {
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
            return false;
        }
    }
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                return false;
            }
        }
    }

    return true;
}
