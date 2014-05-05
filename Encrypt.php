<?php

header('Content-Type: text/plain; charset=utf-8');
session_start();
   include('Crypt/AES.php');
   $aes = new Crypt_AES();
   $aes->setKey('abcdefghijklmnop');
   if(isset($_POST["passphrase"]))
   {
   $plaintext = $_POST["passphrase"];
   }
   else
   {
   $plaintext='stegany';
   echo 'unset passphrase';
   }
   $ciphertext=$aes->encrypt($plaintext);
 try {
    
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (
        !isset($_FILES['userfile']['error']) ||
        is_array($_FILES['userfile']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['userfile']['error'] value.
    switch ($_FILES['userfile']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here. 
    if ($_FILES['userfile']['size'] > 10000000) {
        throw new RuntimeException('Exceeded filesize limit.');
    }

    // DO NOT TRUST $_FILES['userfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES['userfile']['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Invalid file format.');
    }
	$test= sha1_file($_FILES['userfile']['tmp_name']).'.'.$ext;
    // You should name it uniquely.
    // DO NOT USE $_FILES['userfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    if (!move_uploaded_file(
        $_FILES['userfile']['tmp_name'],
        sprintf('./images/%s.%s',
            sha1_file($_FILES['userfile']['tmp_name']),
            $ext
        )
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    echo 'File is uploaded successfully.';
	$_SESSION['text']=$ciphertext;
	$_SESSION['image']=$test;
	header("location: steg.php");
} catch (RuntimeException $e) {

    echo $e->getMessage();

}

?>