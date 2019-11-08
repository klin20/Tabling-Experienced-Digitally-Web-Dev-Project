
<?php
require_once('/init.php');

$stripe = array(
  "secret_key"      => "sk_test_wy9Hjqr8DSvScf98xJTDHC1n",
  "publishable_key" => "pk_test_FaAZTaQwnYJql0r9aHngoyUb"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>