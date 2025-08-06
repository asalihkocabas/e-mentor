<?php

$sifre = '123456';
$hashlenmis_sifre = password_hash($sifre, PASSWORD_DEFAULT);

echo "Şifrenizin güvenli hali (hash): <br><br>";
echo $hashlenmis_sifre;
echo "<br><br>Bu uzun kodu kopyalayıp veritabanındaki password alanına yapıştırın.";

?>