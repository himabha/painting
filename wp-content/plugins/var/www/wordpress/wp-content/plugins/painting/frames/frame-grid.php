<?php
include_once(dirname(__FILE__).'/../config.php');
global $wpdb;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
    $http = "https://";
} else {
    $http = "http://";
}
// prepare and bind
$results = $wpdb->get_results("SELECT * from frames where active = 1 order by sort asc");
if (empty($results)) {
    exit('No rows');
}
?>
<!-- Frame starts here -->
	<div class="form-group chose_frame_field">
		<div class="form-group">
			<label for="filter_frame_type"><?php echo $helper->getHebrewText('select_frame_type');?>: </label>
			<select name="filter_frame_type" class="filter_frame_type" id="filter_frame_type">
			<?php
            $options = "<option value=''>".$helper->getHebrewText('choose_one')."</option>";
            $frames = $jsondata['categories']['frames']['types'];
            if (isset($frames) && !empty($frames)) {
                foreach ($frames as $key_frame => $frame) {
                    if ($frame != 'from_catalogue') {
                        $newframe= ucfirst(str_replace("_", " ", $frame));
                        $options .= '<option value="'.$frame.'">'.$newframe.'</option>';
                    }
                }
            }
            echo $options;
            ?>
			</select>
		</div>
		<div class="form-group field_color">
			<label for="filter_frame_colors"><?php echo $helper->getHebrewText('select_color');?>: </label>
			<select name="filter_frame_colors" class="filter_frame_colors" id="filter_frame_colors">
			<?php
            $options = "<option selected='selected' value=''>".$helper->getHebrewText('choose_one')."</option>";
            $colors = $jsondata['categories']['frames']['sizes'][0]['colors'];
            if (isset($colors) && !empty($colors)) {
                foreach ($colors as $key_color => $color) {
                    $color= ucfirst(str_replace("_", " ", $color));
                    $options .= '<option value="'.strtolower($color).'">'.$color.'</option>';
                }
            }
            echo $options;
            ?>
			</select>
		  </div>


</div>
<div id="table">
	<?php
    $i = 0;
    foreach ($results as $row) {
        $data = json_encode($row);
        $row = (array)$row;
        if ($i % 3 == 0) {
            ?>
		<div class="tr">
	<?php
        } ?>
	<div class="td">
		<img onclick="javascript:onframechose(this)" width="150px" height="150px" class="frame_img" src="<?php echo plugins_url($row['img_path'], dirname(__FILE__)); ?>"/>
		<input type="hidden" class="frame_data" name="frame_data_<?php echo $i; ?>" id="frame_data_<?php echo $i; ?>" value='<?php echo $data; ?>'/>
	</div>
	<?php
        if ($i > 0 && ($i+1) % 3 == 0) {
            ?>
		</div>
	<?php
        }
        $i++;
    }
    ?>
</div>

<div align="center" class="headline">
	<p>
		<b><?php echo $helper->getHebrewText('selected_frame_detail');?></b>
	</p>
</div>

<div id="table" class="selected_frame_detail">
<div class="tr">
<div class="td"><label><?php echo $helper->getHebrewText('frame_name');?>: </label></div>
<div id="selected_frame_name" class="td"></div>
</div>
<div class="tr">
<div class="td"><label><?php echo $helper->getHebrewText('frame_description');?>: </label></div>
<div id="selected_frame_description" class="td"></div>
</div>
<div class="tr">
<div class="td"><label><?php echo $helper->getHebrewText('frame_color');?>: </label></div>
<div id="selected_frame_color" class="td"></div>
</div>
<div class="tr">
<div class="td"><label><?php echo $helper->getHebrewText('frame_type');?>: </label></div>
<div id="selected_frame_type" class="td"></div>
</div>
<div class="tr">
<div class="td"><label><?php echo $helper->getHebrewText('frame_price');?>: </label></div>
<div id="selected_frame_price" class="td"></div>
</div>
</div>
<style>
#table{
    display: table;
	float:left;
	clear:both;
}
.tr{
    display: table-row;
}
.td{
    display: table-cell;
}
.td img
{
	padding:15px;
}
.frame_chosen
{
	color:green;
}
.selected_frame_detail
{
	width:100%;
	margin-top:15px;
}
.td p
{
	text-align:center;
}
.chose_frame_field .form-group
{
	display:inline-block;
	float: left;
    margin-left: 15px;
}
.headline
{
	margin-top:15px;
	clear:both;
}
</style>

<script>
	function onframechose(elem){
		var frame_data = ($("#frame_data_"+$(".frame_img").index(elem)).val());
		$("#frame_selected").val(frame_data);
		$(".frame_img").removeClass("selected");
		$(elem).addClass("selected");
		$(".frame_chosen").remove();
		var parseJson = JSON.parse(frame_data);
		$("#selected_frame_name").html(parseJson.name);
		$("#selected_frame_description").html(parseJson.description);
		$("#selected_frame_color").html(parseJson.color);
		$("#selected_frame_type").html(parseJson.type);
		$("#selected_frame_price").html(parseJson.price);
		calc();
	}

$(document).ready(function(){
	onframechose($(".frame_img:eq(0)"));
	$("#filter_frame_type, #filter_frame_colors").on("change", function(){
		$("#frame_selected").val("");
		var type = $("#filter_frame_type").val();
		var color = $("#filter_frame_colors").val();
		$.ajax({
			url: "<?php echo plugins_url('getFrames.php', __FILE__); ?>",
			data:{type: type, color: color},
			type:'POST',
			success:function(result)
			{

				$("#selected_frame_name").html("");
				$("#selected_frame_description").html("");
				$("#selected_frame_color").html("");
				$("#selected_frame_type").html("");
				$("#selected_frame_price").html("");
				if(result != "")
				{
					$("#table").html(result);
					onframechose($(".frame_img:eq(0)"));
				}
				else
				{
					$("#table").html("No rows");
					$("#frame_selected").val("");
				}
				calc();
			},
			error: function(error)
			{

			}
		}
		);
	})
})
</script>
