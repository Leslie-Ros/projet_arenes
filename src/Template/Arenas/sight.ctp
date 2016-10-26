Bienvenue dans webArena
<?php
echo "<br>";
for ($row = 0; $row < 15; $row++) {
    for ($col = 0; $col < 10; $col++) {
        echo $arena[$row][$col];
    }
    echo "<br>";
}
?>