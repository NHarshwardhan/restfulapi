<!-- Start Server 1 (Catalog) -->

<?php
$port = 8001;
$host = 'localhost';
$docroot = __DIR__;

echo "Starting Product Catalog Server on http://$host:$port\n";
exec(" php -S $host:$port -t $docroot catalog.php");



?>