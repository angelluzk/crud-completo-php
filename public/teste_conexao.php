<?php
require_once '../config/Database.php';

$db = new Database();
$conn = $db->getConnection();

if($conn) {
    echo "Conexão com PostgreSQL realizada com sucesso!";
} else {
    echo "Erro na conexão!";
}
?>