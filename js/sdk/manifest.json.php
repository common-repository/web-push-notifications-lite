<?php
header("Content-Type: application/json");
require_once("../../../../../wp-load.php");
$google_id = get_option( 'emdn_pushem_googleid' );
$domain = get_option( 'emdn_pushem_domain' );
if ($google_id != FALSE && $domain != FALSE) {
?>
{
  "name": "<?php echo $domain; ?>",
  "gcm_sender_id": "<?php echo $google_id; ?>"
}
<?php
}
?>