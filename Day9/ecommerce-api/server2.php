<!-- Start Server 2 (Orders) -->

<?php
$port = 8002;
$host = 'localhost';
$docroot = __DIR__;

echo "Starting Product Catalog Server on http://$host:$port\n";
exec(" php -S $host:$port -t $docroot order.php");



?>