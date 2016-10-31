Bienvenue dans webArena
<?php
echo "<br>";
for ($row = 0; $row < 15; $row++) {
    for ($col = 0; $col < 10; $col++) {
            echo "<section style=\"text-align: center; height: 45px;width: 45px; border-style: solid;float: left;";
        if($mask[$row][$col] == "#"){
            echo "background-color: #890000;\">";
            if($arena[$row][$col] == "_")
                echo " ";
            else
                echo $arena[$row][$col];
        }else {
            echo "background-color: #000000;\">";
        }
            echo "</section>";
    }
    echo "<div style=\"clear: both\"></div>";
}
echo $this->Form->create();
$options = ['N' => 'North', 'W' => 'West', 'S' => 'South', 'E' => 'East'];
echo $this->Form->select('direction', $options);
echo $this->Form->button('GO!');
echo $this->Form->end();

?>