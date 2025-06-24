
<?php
function mailer($umsg,$to,$sub)
{
$message=$umsg;
$to = $to;
$subject = $sub;
// $message = "<b>This is HTML message.</b>";
// $message .= "<h1>This is headline.</h1>";

$header = "From:test@mmiit.in \r\n";
// $header = "Cc:afgh@somedomain.com \r\n";
$header .= "MIME-Version: 1.0 \r\n";
$header .= "Content-type: text/html \r\n";
$retval = mail ($to,$subject,$message,$header);
return $retval;
}
?>
