<?php

// configure
$from = 'FormatFerrara';
$sendTo = 'dimagrubii@gmail.com';
$subject = 'Nuovo messaggio da "Scrivici"';
$fields = array('name' => 'Nome', 'email' => 'Email', 'message' => 'Messaggio'); // array variable name => Text to appear in email
$okMessage = 'Il messaggio è stato invito con successo, Grazie! Risponderemo al più presto.';
$errorMessage = 'Errore, si prega di fare un nuovo tentativo, controllando di aver inserito bene i dati.';

// let's do the sending

try
{
    $emailText = "C'è un nuovo messaggio\n=============================\n";

    foreach ($_POST as $key => $value) {

        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    mail($sendTo, $subject, $emailText, "From: " . $from);

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
