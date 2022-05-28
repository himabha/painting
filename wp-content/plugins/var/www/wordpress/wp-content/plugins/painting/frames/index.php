<?php ?>
<div class="left_section">
<form action="/action_page.php" id="frame_form">
  <div class="form-group">
		<label for="frame_source"><?php echo $helper->getHebrewText('select_frame_source');?>: </label>
		<select name="frame_source" class="frame_source" id="frame_source">
		<option value=""><?php echo $helper->getHebrewText('choose_one');?></option>
		<option value="from_grid"><?php echo $helper->getHebrewText('from_grid');?></option>
		<option value="from_catalogue"><?php echo $helper->getHebrewText('from_catalogue');?></option>
		</select>
	</div>
	<div class="form-group field_width">
		<label for="frame_width"><?php echo $helper->getHebrewText('width');?>: </label>
		<input name="frame_width" class="frame_size" id="frame_width" type="text" min="0" max="120"/><?php echo $helper->getHebrewText('cm');?>
	</div>
	<div class="form-group field_height">
		<label for="frame_height"><?php echo $helper->getHebrewText('height');?>:</label>
		<input name="frame_height" class="frame_size" id="frame_height" type="text" min="0" max="140"/><?php echo $helper->getHebrewText('cm');?>
	</div>

	<div class="form-group">
		<span class="frame_error" id="frame_size_error"></span>
	</div>

	<div class="form-group field_size_dropdown">
		<label for="frame_size"><?php echo $helper->getHebrewText('select_size');?>:</label>
		<select id="frame_size" onchange="onsizechange(this);">
			<option value=""><?php echo $helper->getHebrewText('choose_one');?></option>
		</select>
	</div>




<div class="form-group field_cover">
    <label for="frame_cover"><?php echo $helper->getHebrewText('select_cover_type');?>: </label>
    <select name="frame_cover" class="frame_cover" id="frame_cover">
	<?php
    $options = "";
    $covers = $jsondata['categories']['frames']['sizes'][0]['covers'];
    if (isset($covers) && !empty($covers)) {
        foreach ($covers as $key_cover => $cover) {
            $cover = $helper->getHebrewText($key_cover);
            $options .= '<option value="'.$key_cover.'">'.$cover.'</option>';
        }
    }
    echo $options;
    ?>
	</select>
  </div>

  <div class="form-group field_extra">
    <label for="frame_extra"><?php echo $helper->getHebrewText('select_extras');?>: </label>
    <select name="frame_extra" class="frame_extra" id="frame_extra" onchange="onextrachange();">
	<?php
    $options = "";
    $extras = $jsondata['categories']['frames']['sizes'][0]['extras'];
    if (isset($extras) && !empty($extras)) {
        foreach ($extras as $key_extra => $extra) {
            $extra= ucfirst(str_replace("_", " ", $key_extra));
            $options .= '<option value="'.$key_extra.'">'.$extra.'</option>';
        }
    }
    echo $options;
    ?>
	</select>
  </div>

  <div class="form-group field_extra_thickness">
	<label for="frame_colors"><?php echo $helper->getHebrewText('select_extra_width');?>: </label>
		<input id="frame_extra_thickness" min="2" max="10" value="2" type="number" name="frame_extra_thickness" onchange="onquantitychange(this)" onkeyup="onextrathicknesschange()"/>cm
	</label>
  </div>

    <div class="form-group field_color">
    <label for="frame_colors"><?php echo $helper->getHebrewText('select_color');?>: </label>
    <select name="frame_colors" class="frame_colors" id="frame_colors">
	<?php
    $options = "<option selected='selected'>Choose one</option>";
    $colors = $jsondata['categories']['frames']['sizes'][0]['colors'];
    if (isset($colors) && !empty($colors)) {
        foreach ($colors as $key_color => $color) {
            $color= ucfirst(str_replace("_", " ", $color));
            $options .= '<option value="'.$key_color.'">'.$color.'</option>';
        }
    }
    echo $options;
    ?>
	</select>
  </div>
  <div class="form-group field_quantity">
		<label for="frame_quantity"><?php echo $helper->getHebrewText('quantity');?>:</label>
		<input id="frame_quantity" min="1" value="1" type="number" name="frame_quantity" onchange="onquantitychange(this)" onkeyup="onquantitychange(this)"/>
	</div>

	<div class="form-group">
  <label><?php echo $helper->getHebrewText('price');?>: <span id="price"></span></label>
  </div>
  	<input type="hidden" name="frame_selected" id="frame_selected" value="">
</form>
</div>
<div class="right_section">
	<?php include(plugin_dir_path(__FILE__).'frame-grid.php'); ?>
</div>
<script>
function getMul(total, num)
{
	return total*num;
}

function onextrathicknesschange()
{
	calc();
}
function onextrachange()
{
	calc();
}

function onsizechange(elem)
{
	var sizeindex = $(elem).val();
	var quantity = $("#frame_quantity").val();
	$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
		if(sizeindex != "")
		{
			var discount = 0;
			var maxArray = [];
			$(data.categories.frames.sizes[1].discount_list).each(function(index){
				maxArray = $.merge(maxArray, this.quantity);
			});
			maxQuantity = Math.max.apply(null, maxArray);
			if(quantity >= maxQuantity)
			{
				$(data.categories.frames.sizes[1].discount_list).each(function(){
					if($.inArray(maxQuantity, this.quantity) != -1)
					{
						discount = this.discount;
						return false;
					}
				});
			}
			else
			{
				$(data.categories.frames.sizes[1].discount_list).each(function(){
					var max_quantity = Math.max.apply(null, this.quantity);
					var min_quantity = Math.min.apply(null, this.quantity);
					if(min_quantity != 0 && quantity >= min_quantity && quantity <= max_quantity)
					{
						discount = this.discount;
						return false;
					}
				});
			}
			var price = data.categories.frames.sizes[1].price_list[sizeindex] - data.categories.frames.sizes[1].price_list[sizeindex]*discount/100;
			$("#price").html(Math.round(quantity*price));
		}
		else{
			$("#price").html("");
		}
	});
}

function onquantitychange(elem)
{
	var frame_source = $("#frame_source").val();
	if(frame_source == "from_catalogue")
	{
		var sizeindex = $("#frame_size").val();
		var quantity = $(elem).val();
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
			if(sizeindex != "")
			{
				var discount = 0;
				var maxArray = [];
				$(data.categories.frames.sizes[1].discount_list).each(function(index){
					maxArray = $.merge(maxArray, this.quantity);
				});
				maxQuantity = Math.max.apply(null, maxArray);
				if(quantity >= maxQuantity)
				{
					$(data.categories.frames.sizes[1].discount_list).each(function(){
						if($.inArray(maxQuantity, this.quantity) != -1)
						{
							discount = this.discount;
							return false;
						}
					});
				}
				else
				{
					$(data.categories.frames.sizes[1].discount_list).each(function(){
						var max_quantity = Math.max.apply(null, this.quantity);
						var min_quantity = Math.min.apply(null, this.quantity);
						if(min_quantity != 0 && quantity >= min_quantity && quantity <= max_quantity)
						{
							discount = this.discount;
							return false;
						}
					});
				}


				var price = data.categories.frames.sizes[1].price_list[sizeindex] - data.categories.frames.sizes[1].price_list[sizeindex]*discount/100;
				$("#price").html(Math.round(quantity*price));
			}
			else{
				$("#price").html("");
			}
		});
	}
	else
	{
		calc();
	}
}

function calc(){
	var frame_source = $("#frame_source").val();
	if(frame_source != "from_catalogue")
	{
		var frame_width = parseInt($("#frame_width").val());
		var frame_height = parseInt($("#frame_height").val());
		var frame_extra = $("#frame_extra").val();
		var frame_cover = $("#frame_cover").val();
		var frame_colors = $("#frame_colors").val();
		var quantity = $("#frame_quantity").val();
		var frame_selected = $("#frame_selected").val();
		var frame_extra_thickness = parseInt((typeof $("#frame_extra_thickness.field_extra_thickness_enabled").val() != "undefined") ? $("#frame_extra_thickness.field_extra_thickness_enabled").val() : 0);
		if(typeof frame_selected != "undefined" && frame_selected != "" )
		{
		if(typeof frame_width != 'undefined' && frame_width > 0 && typeof frame_height != 'undefined' && frame_height > 0)
		{
			var frame_selected = JSON.parse(frame_selected);
			var price = frame_selected.price;
			price = parseInt((frame_width + frame_height + (frame_extra_thickness * 2)) * 2 / 100 * price);
			$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
				if(typeof data.categories.frames != 'undefined')
				{
					$("#frame_size_error").html("");
					if(typeof frame_cover != 'undefined')
					{
						$(data.categories.frames.sizes[0].covers).each(function(index){
							if(typeof this[frame_cover].price != 'undefined')
							{
								price += parseInt(this[frame_cover].price)*(frame_width * frame_height)/10000;
								return false;
							}
						});
					}
					if(price < data.categories.frames.sizes[0].min_price)
					{
						price = data.categories.frames.sizes[0].min_price;
					}
					var maxdimension = Math.max.apply(null, [frame_width, frame_height]);
					var mindimension = Math.min.apply(null, [frame_width, frame_height]);
					$(data.categories.frames.sizes[0].extras).each(function(index){
						if(this[frame_extra].length > 0 && maxdimension <= Math.max.apply(null, [this[frame_extra][0].max_dimensions[0], this[frame_extra][0].max_dimensions[1]]) && mindimension <= Math.min.apply(null, [this[frame_extra][0].max_dimensions[0], this[frame_extra][0].max_dimensions[1]]))
						{
							if(typeof this[frame_extra][0].price != 'undefined')
							{
								price += parseInt(this[frame_extra][0].price);
								return false;
							}
						}
						else if(this[frame_extra].length > 0){
							price = 0;
							$("#frame_size_error").html("Size should be maximum "+this[frame_extra][0].max_dimensions[0]+"x"+this[frame_extra][0].max_dimensions[1]);
							return false;
						}
					});
					$("#price").html(Math.round(price)*quantity);
				}

			});
		}
	}
	else{
		$("#price").html("");
	}
	}
}
$(document).ready(function(){
	$(".frame_size").on("blur keyup", function(){
		calc();
	});
	$("#frame_source").on("change", function(){
		var frame_source = $(this).val();
		$("#frame_size").val("");
		if(frame_source == "from_catalogue")
		{
			$("#frame_selected").val("");
			$("#price").html("");
			$(".field_extra, .field_cover, .field_color, .frame_error, .field_width, .field_height, .field_extra_thickness, .right_section").css("display", "none");
			$(".field_size_dropdown").css("display", "block");
			$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
				var dimension = "";
				$(data.categories.frames.sizes[1].dimensions).each(function(index){
					dimension += '<option value="'+index+'">'+this[0]+'x'+this[1]+'</option>';
				});
				$("#frame_size option").not($("#frame_size option:eq(0)")).remove();
				$("#frame_size").append(dimension);
			});
		}
		else
		{
			$(".field_extra, .field_cover, .field_color, .frame_error, .field_width, .field_height, .right_section").css("display", "block");
			$(".field_size_dropdown").css("display", "none");
		}
		calc();
	});

	$("#frame_cover").on("change", function(){
		calc();
	});
	$("#frame_extra").on("change", function(){
		if($(this).val() != "without")
		{
			$(".field_extra_thickness").css("display", "block");
			$("#frame_extra_thickness").addClass("field_extra_thickness_enabled");
		}
		else{
			$(".field_extra_thickness").css("display", "none");
			$("#frame_extra_thickness").removeClass("field_extra_thickness_enabled");
		}
		calc();
	});
});

</script>
<style>
.field_size_dropdown, .field_extra_thickness
{
	display:none;
}
.frame_error{
    display: block;
    color: red;
}
.left_section
{
	float:left;
	width: 45%;
}
.right_section
{
	display:none;
	float:left;
	width: 45%;
}
img.frame_img.selected {
    border: 2px solid #ccc;
}
</style>
