Bienvenue dans webArena
<?php
echo "<br>";
for ($row = 0; $row < 15; $row++) {
    for ($col = 0; $col < 10; $col++) {
            echo "<div style=\"height: 40px;width: 40x; border-style: solid;float: left\">";
        if($mask[$row][$col] == "#"){
            echo $arena[$row][$col];
        }else {
            echo "#";
        }
            echo "</div>";
    }
    echo "<div style=\"clear: both\"></div>";
}
echo $this->Form->create();
$options = ['N' => 'North', 'W' => 'West', 'S' => 'South', 'E' => 'East'];
echo $this->Form->select('direction', $options);
echo $this->Form->button('GO!');
echo $this->Form->end();
?>