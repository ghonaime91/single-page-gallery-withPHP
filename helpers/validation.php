<?php

function clean($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    
    return $input;
}

function clear_input($input)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $input;
}

// validation rules for the regular data
function validate($input,$flag,$length=6)
{
    $status = false;
    switch($flag)
    {
        case "is_empty":
            if(empty($input)) {
                $status = true;
            }
            break;

        case "is_string":
           if(preg_match ("/^[a-zA-z ]*$/", $input)) {
                $status = true;
            }
            break;

        case "is_email":
            if(filter_var($input,FILTER_VALIDATE_EMAIL)) {
                $status = true;
            }
            break;
        
        case "is_url":
            if(filter_var($input,FILTER_VALIDATE_URL)) {
                $status = true;
            }
            break;

        case "is_number":
            if(is_numeric($input)) {
                $status = true;
            }
            break;
        case "is_int":
            if(filter_var($input,FILTER_VALIDATE_INT)) {
                $status = true;
            }
            break;

        case "is_short":
            if(strlen($input)<$length) {
                $status = true;
            }
            break;    
        case "is_long":
            if(strlen($input)>$length) {
                $status = true;
            }
            break;           

    }

    return $status; 
}


?>