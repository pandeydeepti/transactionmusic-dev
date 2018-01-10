<?php
$api_key = '9192ff7b241dd6e991c8dd4c5f15e40c-us14';
$list_id = '4481ecc415';


require( dirname(__DIR__) . '/comingsoon/mailchimp-api-master/src/MailChimp.php');
use DrewM\MailChimp\MailChimp;

$MailChimp = new MailChimp($api_key);

$result = $MailChimp->post("lists/$list_id/members", [
    'email_address' => $_POST['email'],
    'Name' => $_POST['email'],
    'status'        => 'subscribed',
]);

if ($MailChimp->success()) {
    echo json_encode(array( 'result' => 'success' ));
} else {
    echo json_encode(array( 'result' => $MailChimp->getLastError() ));
}
die();
?>