<?php
global $global_params;
global $page_params;

$pageArgs = $global_params['page_arguments'];

if( $pageArgs['aj'] == 1 && $pageArgs['action'] == "contactMe" ) {
    $subject = "ManageMyResto - Inquiry from ".$pageArgs['name'];
    $message = $pageArgs['message'];
    $emailMsg = "Query from <br />Name: {$pageArgs['name']}<br />Email: {$pageArgs['email']}<br />Number: {$pageArgs['phone']}<br />Message:<br />".$message;
    $header = "";
    $header .= "From:{$pageArgs['email']} \r\n";
    $header .= "Reply-to: ".$pageArgs['email']." \r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    $sendMail = mail(CONTACT_US_EMAIL,$subject,$emailMsg,$header);
    echo json_encode($sendMail);
    exit;
}
?>