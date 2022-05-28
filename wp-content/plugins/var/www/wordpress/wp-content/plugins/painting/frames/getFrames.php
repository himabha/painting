<?php
include_once(dirname(__FILE__).'/../config.php');
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
    $http = "https://";
} else {
    $http = "http://";
}
$db = new DbConnection;
$conn = $db->getConnection(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$cond = "";
if (isset($_POST['type']) && $_POST['type'] != "") {
    $cond = 'and type = "'.addslashes($_POST['type']).'"';
}
if (isset($_POST['color']) && $_POST['color'] != "") {
    $cond .= ' and color = "'.addslashes($_POST['color']).'"';
}

// prepare and bind
$stmt = mysqli_query($conn, "SELECT * from frames where active = 1 ".$cond." order by sort asc");
if (mysqli_num_rows($stmt) === 0) {
    exit('');
}
    $i = 0;
    $html = "";
    while ($row = $stmt->fetch_assoc()) {
        $data = json_encode($row);
        if ($i % 3 == 0) {
            $html.= '<div class="tr">';
        }
        $html .= '<div class="td">
		<img onclick="onframechose(this)" width="150px" height="150px" class="frame_img" src="'.plugins_url($row['img_path'], dirname(__FILE__)).'"/><input type="hidden" class="frame_data" name="frame_data_<?php echo $i;?>" id="frame_data_'.$i.'" value=\''.$data.'\'/></div>';
        if ($i > 0 && ($i+1) % 3 == 0) {
            $html.= '</div>';
        }
        $i++;
    }
    $stmt->close();
    $conn->close();
    echo $html;
