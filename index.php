<pre>
<?php

//https://www.php.net/manual/en/book.imap.php

//https://stackoverflow.com/questions/11285430/imap-get-attached-file

/*
// To connect to an IMAP server running on port 143 on the local machine,
// do the following:
$mbox = imap_open("{localhost:143}INBOX", "user_id", "password");

// To connect to a POP3 server on port 110 on the local server, use:
$mbox = imap_open ("{localhost:110/pop3}INBOX", "user_id", "password");

// To connect to an SSL IMAP or POP3 server, add /ssl after the protocol
// specification:
$mbox = imap_open ("{localhost:993/imap/ssl}INBOX", "user_id", "password");

// To connect to an SSL IMAP or POP3 server with a self-signed certificate,
// add /ssl/novalidate-cert after the protocol specification:
$mbox = imap_open ("{localhost:995/pop3/ssl/novalidate-cert}", "user_id", "password");

// To connect to an NNTP server on port 119 on the local server, use:
$nntp = imap_open ("{localhost:119/nntp}comp.test", "", "");
// To connect to a remote server replace "localhost" with the name or the
// IP address of the server you want to connect to.
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo get_cfg_var('cfg_file_path');


// get the list of folders

$server ='imapmail.libero.it';
$porta='993';
$username=''; //email
$password=''; //password
$mbox = imap_open('{'.$server.':'.$porta.'/imap/ssl}INBOX', $username, $password)
      or die("can't connect: " . imap_last_error());


$list = imap_list($mbox, '{'.$server.'}', "*");
if (is_array($list)) {
    foreach ($list as $val) {
        echo imap_utf7_decode($val) . "\n";
    }
} else {
    echo "imap_list failed: " . imap_last_error() . "\n";
}


//retrieve the headers of the last 7 days
//more search option here:https://www.php.net/manual/en/function.imap-search.php
$date = date ( "d M Y", strToTime ( "-7 days" ) );
$search_criteria = "SINCE \"$date\""." UNSEEN";
$msg = imap_search( $mbox, $search_criteria);

print_r($msg);



echo imap_qprint(imap_body($mbox, 2030)); 



//segna messaggio come letto
foreach ($result as $mail) {
    $status = imap_setflag_full($mbox, $mail, "\\Seen \\Flagged", ST_UID);
}


imap_close($mbox);

?>
<pre>