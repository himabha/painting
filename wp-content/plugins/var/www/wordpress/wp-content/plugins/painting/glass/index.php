<form action="/action_page.php" id="glass_form">
	<div class="form-group">
	<?php
    $options = "<option value=''>".$helper->getHebrewText('choose_one')."</option>";
    $glasses = $jsondata['categories']['glass'];
    if (isset($glasses) && !empty($glasses)) {
        ?>
			<label for="glass_width"><?php echo $helper->getHebrewText('select_glass'); ?>: </label>
			<select name="glass_type" class="glass_type" id="glass_type">
		<?php
            foreach ($glasses as $index => $glass) {
                $glass = str_replace("_", " ", ucfirst($index));
                $options .= '<option value="'.$index.'">'.$glass.'</option>';
            }
        echo $options; ?>
			</select>
	<?php
    }
    ?>
	</div>

	<!--<div class="form-group fieldsdisplay" id="glass_thickness_div"></div>-->

	<div class="form-group thickness_dropdown">
		<label for='glass_thickness'><?php echo $helper->getHebrewText('select_thickness');?>: </label>
		<select id='glass_thickness' class="glass_thickness" onchange='javascript:onthicknesschange()' name='glass_thickness'><option value=''><?php echo $helper->getHebrewText('choose_one');?></option>
		</select>
	</div>

	<div class="form-group thickness_line">
		<label for="glass_width"><?php echo $helper->getHebrewText('thickness');?>: <span id="thickness_content"></span></label><input type="hidden" name="glass_thickness" class="glass_thickness" id="glass_thickness" value=""/>
	</div>

	<div class="form-group">
		<label for="glass_width"><?php echo $helper->getHebrewText('width');?>: </label>
		<input name="glass_width" class="glass_size" id="glass_width" type="text"/><?php echo $helper->getHebrewText('cm');?>
	</div>
	<div class="form-group">
		<label for="glass_height"><?php echo $helper->getHebrewText('height');?>:</label>
		<input name="glass_height" class="glass_size" id="glass_height" type="text"/><?php echo $helper->getHebrewText('cm');?>
	</div>
	<div class="form-group">
		<span class="glass_error" id="glass_size_error"></span>
	</div>
	<div class="form-group field_quantity">
		<label for="glass_quantity"><?php echo $helper->getHebrewText('quantity');?>Quantity:</label>
		<input id="glass_quantity" min="1" value="1" type="number" name="glass_quantity" onchange="onquantitychange(this)" onkeyup="onquantitychange(this)"/>
	</div>
	<div class="form-group">
		<label><?php echo $helper->getHebrewText('price');?>Price: <span id="price"></span></label>
	</div>
</form>

<script>

function onquantitychange(elem)
{
	calc();
}

function calc(){
	var page = $("#glass_type").val();
	var glass_width = $("#glass_width").val();
	var glass_height = $("#glass_height").val();
	var thickness = $(".glass_thickness.glass_enabled").val();
	var quantity = $("#glass_quantity").val();
	if((typeof glass_width != 'undefined' && glass_width > 0) && (typeof glass_height != 'undefined' && glass_height > 0))
	{
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
		if(typeof data.categories.glass[page] != 'undefined')
		{
			$(data.categories.glass[page].sizes).each(function(index){
				var size = this;
				if(size.thickness_by_mm == thickness)
				{
					var max_max_dimensions = Math.max.apply(null, size.max_dimensions);
					var min_max_dimensions = Math.min.apply(null, size.max_dimensions);
					var max_min_dimensions = Math.max.apply(null, size.min_dimensions);
					var min_min_dimensions = Math.min.apply(null, size.min_dimensions);

					//Checking for min width or height -> start here
					if(glass_width < min_min_dimensions || glass_height < min_min_dimensions || glass_width > max_max_dimensions || glass_height > max_max_dimensions)
					{
						$("#glass_size_error").css("display", "block");
						$("#glass_size_error").html("Size should be maximum "+size.min_dimensions[0]+"X"+size.min_dimensions[1]+" and atleast " +size.max_dimensions[0]+"X"+size.max_dimensions[1]);
						$("#price").html("");
						return false;
					}
					else if(((glass_width >= min_min_dimensions && glass_width < max_min_dimensions) && glass_height < max_min_dimensions) || ((glass_height >= min_min_dimensions && glass_height < max_min_dimensions) && glass_width < max_min_dimensions))
					{
						$("#glass_size_error").css("display", "block");
						$("#glass_size_error").html("Size should be maximum "+size.min_dimensions[0]+"X"+size.min_dimensions[1]+" and atleast " +size.max_dimensions[0]+"X"+size.max_dimensions[1]);
						$("#price").html("");
						return false;
					}
					else
					{
						$("#glass_size_error").html("");
					}
					var calc_price = size.price/10000*(glass_width*glass_height);
					if(calc_price < size.min_price)
					{
						calc_price = size.min_price;
					}

					$("#price").html(Math.round(calc_price)*quantity);


				}
			});

		}
	});
	}
}

function onthicknesschange(){
	//$("#glass_width").val("");
	//$("#glass_height").val("");
	$("#price").html("");
	//$(".fieldsdisplay").css("display", "block");
	calc();
}
$(document).ready(function(){

	$("#glass_type").on("change", function(){
		var val = $(this).val();
		if(val != '')
		{
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
			var content = data.categories.glass[val];
			if(typeof content.sizes != "undefined")
			{
				/*if(content.sizes.length > 1)
				{
					var thickness = "<label for='glass_thickness'>Select thickness: </label><select id='glass_thickness' onchange='javascript:onthicknesschange()' name='glass_thickness'><option value=''>Select thickness</option>";
					$(content.sizes).each(function(index){
						thickness += "<option value="+this.thickness_by_mm+">"+this.thickness_by_mm+"mm</option>";
					});
					thickness += "</select>";
					$("#glass_thickness_div").html(thickness);
					$(".fieldsdisplay").css("display", "none");
					$("#glass_thickness_div").css("display", "block");
				}
				else{
					$("#glass_thickness_div").html('<label for="glass_width">Thickness: '+content.sizes[0].thickness_by_mm+'mm</label><input type="hidden" name="glass_thickness" class="glass_thickness" id="glass_thickness" value="'+content.sizes[0].thickness_by_mm+'"/>');
					$(".fieldsdisplay").css("display", "block");
				}*/
				if(content.sizes.length > 1)
				{
					var thickness = "";
					$(content.sizes).each(function(index){
						thickness += "<option value="+this.thickness_by_mm+">"+this.thickness_by_mm+"mm</option>";
					});
					thickness += "</select>";
					$(".glass_thickness").removeClass("glass_enabled");
					$(".glass_thickness:eq(0)").addClass("glass_enabled");
					$(".glass_thickness:eq(0) option").not($(".glass_thickness:eq(0) option:eq(0)")).remove();
					$(".glass_thickness:eq(0)").append(thickness);
					$(".thickness_line").css("display", "none");
					$(".thickness_dropdown").css("display", "block");
					//$(".fieldsdisplay").css("display", "none");
					//$("#glass_thickness_div").css("display", "block");
				}
				else{
					$("#thickness_content").html(content.sizes[0].thickness_by_mm+"mm");
					$(".glass_thickness").removeClass("glass_enabled");
					$(".glass_thickness:eq(1)").addClass("glass_enabled");
					$(".glass_thickness:eq(1)").val(content.sizes[0].thickness_by_mm);
					$(".thickness_line").css("display", "block");
					$(".thickness_dropdown").css("display", "none");
					/* $(".fieldsdisplay").css("display", "block");
					$("#glass_finishing").val("");
					$("#chose_frame").val("");
					$("#chose_frame").css("display", "none");
					$("#glass_size").val("");
					$("#glass_size_div").css("display", "none"); */
				}
				calc();
			}
			});
			//$("#glass_width").val("");
			//$("#glass_height").val("");
			$("#price").html("");
			//calc();
	}
	else{
		$("#glass_width").val("");
		$("#glass_height").val("");
		$("#price").html("");
		$(".fieldsdisplay").css("display", "none");
	}

	});

	$(".glass_size").on("focus", function(){
		$("#price").html("");
	});

	$(".glass_size").on("keyup blur", calc);
});
</script>
<style>
.glass_error{
    display: block;
    color: red;
}
.thickness_line
{
	display:none;
}
</style>
