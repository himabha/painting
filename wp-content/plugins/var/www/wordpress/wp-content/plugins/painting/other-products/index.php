<form action="/action_page.php" id="other_products_form">
	<div class="form-group">
	<?php
    $options = "<option value=''>".$helper->getHebrewText('choose_one')."</option>";
    $other_products = $jsondata['categories']['other_products'];
    if (isset($other_products) && !empty($other_products)) {
        ?>
			<label for="other_products_type"><?php echo $helper->getHebrewText('select_other_products'); ?>: </label>
			<select name="other_products_type" class="other_products_type" id="other_products_type">
		<?php
            foreach ($other_products as $index => $other_product) {
                $other_product = str_replace("_", " ", ucfirst($index));
                $options .= '<option value="'.$index.'">'.$other_product.'</option>';
            }
        echo $options; ?>
			</select>
	<?php
    }
    ?>
	</div>
  <div class="form-group thickness_dropdown">
	<label for='other_products_thickness'><?php echo $helper->getHebrewText('select_thickness'); ?>: </label>
	<select id='other_products_thickness' class="other_products_thickness" onchange='javascript:onthicknesschange()' name='other_products_thickness'>
	<option value=''><?php echo $helper->getHebrewText('choose_one'); ?></option>
	</select>
  </div>

  <div class="form-group thickness_range_dropdown">
	<label for='other_products_thickness_range'><?php echo $helper->getHebrewText('select_thickness'); ?>: </label>
  </div>

  <div class="form-group thickness_line">
	<label for="other_products_thickness"><?php echo $helper->getHebrewText('thickness'); ?>: <span id="thickness_content"></span></label><input type="hidden" name="other_products_thickness" class="other_products_thickness" id="other_products_thickness" value=""/>
  </div>

	<div class="form-group field_width">
		<label for="other_products_width"><?php echo $helper->getHebrewText('width'); ?>: </label>
		<input name="other_products_width" class="frame_size" id="other_products_width" type="text"/>cm
	</div>
	<div class="form-group field_height">
		<label for="other_products_height"><?php echo $helper->getHebrewText('height'); ?>:</label>
		<input name="other_products_height" class="frame_size" id="other_products_height" type="text"/>cm
	</div>
	<div class="form-group">
		<span class="other_products_error" id="other_products_size_error"></span>
	</div>

  <div class="form-group dimension_dropdown" >
	<label for='other_products_size'><?php echo $helper->getHebrewText('select_size'); ?>: </label>
	<select onchange='javascript:onsizechange()' name='other_products_size' class='other_products_size' id='other_products_size'><option value=''><?php echo $helper->getHebrewText('choose_one'); ?></option>
	</select>
  </div>

  <div class="form-group field_color">
    <label for="other_products_colors"><?php echo $helper->getHebrewText('select_color'); ?>: </label>
    <select name="other_products_colors" class="other_products_colors" id="other_products_colors" onchange="colorschange();">
		<option value=''><?php echo $helper->getHebrewText('choose_one'); ?></option>
	</select>
  </div>

  <div class="form-group glue_checkbox" >
	<label for='glue_enabled'><?php echo $helper->getHebrewText('with_glue'); ?>: <input onclick="javascript:checkGlue();" type="checkbox" name="glue_enabled" checked id="glue_enabled"/>
	</label>
  </div>
  <div class="form-group field_quantity">
		<label for="other_products_quantity"><?php echo $helper->getHebrewText('quantity'); ?>Quantity:</label>
		<input id="other_products_quantity" min="1" value="1" type="number" name="other_products_quantity" onchange="onquantitychange(this)" onkeyup="onquantitychange(this)"/>
	</div>
  <div class="form-group">
	<label><?php echo $helper->getHebrewText('price'); ?>: <span id="price"></span></label>
  </div>
</form>

<script>

function onquantitychange(elem)
{
	calc();
}

function colorschange()
{
	calc();
}

function calc(){
	var page = $("#other_products_type").val();
	var quantity = $("#other_products_quantity").val();
	if(typeof $(".other_products_size.other_products_size_enabled").val() != 'undefined')
	{
		var other_products_size = $(".other_products_size.other_products_size_enabled").val();
	}
	if(typeof $(".other_products_thickness.other_products_thickness_enabled").val() != 'undefined')
	{
		var thickness =  $(".other_products_thickness.other_products_thickness_enabled").val();
	}
	else if(typeof $(".other_products_thickness_range.other_products_thickness_range_enabled").val() != 'undefined')
	{
		var thickness = $(".other_products_thickness_range.other_products_thickness_range_enabled").val();
	}
	if((typeof thickness == 'undefined' && typeof other_products_size != 'undefined') || (typeof thickness != 'undefined' && thickness !='') && (typeof other_products_size != 'undefined' && other_products_size !=''))
	{
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
			if(typeof data.categories.other_products[page] != 'undefined')
			{
				if(data.categories.other_products[page].sizes.length > 1)
				{
					var checkGlue = $("#glue_enabled").is(":checked");
					$(data.categories.other_products[page].sizes).each(function(index){
						var size = this;
						if(thickness == this.thickness_by_mm)
						{
							$(this.prices).each(function(index){
								if(checkGlue == this.with_glue)
								{
									var price = this.price_list[other_products_size];
									if(quantity < this.quantity_threshold[other_products_size])
									{
										var calc_price = (quantity * price) + (quantity * price) * this.low_quantity_percentage / 100;
									}
									else if(quantity > this.quantity_threshold[other_products_size])
									{
										var difference = quantity - this.quantity_threshold[other_products_size];
										var calc_price = (this.quantity_threshold[other_products_size] * price) + (difference * price) + (difference * price) * this.low_quantity_percentage / 100;
									}
									else
									{
										var calc_price = (this.quantity_threshold[other_products_size] * price);
									}
									console.log(calc_price);
									if(calc_price < size.min_price)
									{
										calc_price = size.min_price;
									}
									$("#price").html(Math.round(calc_price));
									return false;
								}
							});
						}
					});
				}
				else
				{
					$(data.categories.other_products[page].sizes).each(function(index){
						var size = this;
						var calc_price = size.prices[other_products_size];
						if(calc_price < size.min_price)
						{
							calc_price = size.min_price;
						}
						$("#price").html(Math.round(calc_price)*quantity);

					});
				}
			}
		});
	}
	else if((typeof thickness != 'undefined' && thickness !='') && typeof other_products_size == 'undefined')
	{
		var other_product_width = $("#other_products_width").val();
		var other_product_height = $("#other_products_height").val();
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
		if(typeof data.categories.other_products[page] != 'undefined')
		{
			if(data.categories.other_products[page].sizes.length == 1)
			{
				var size = data.categories.other_products[page].sizes[0];
				if((typeof other_product_width != 'undefined' && other_product_width > 0) && (typeof other_product_height != 'undefined' && other_product_height > 0))
				{
					var max_dimensions = Math.max.apply(null, data.categories.other_products[page].manual_dimensions.max_dimensions);
					var min_dimensions = Math.min.apply(null, data.categories.other_products[page].manual_dimensions.max_dimensions);
					if(other_product_width > max_dimensions || other_product_height > max_dimensions)
					{
						$("#other_products_size_error").html("Size should be atleast "+data.categories.other_products[page].manual_dimensions.max_dimensions[0]+"X"+data.categories.other_products[page].manual_dimensions.max_dimensions[1]);
						$("#price").html("");
						return false;
					}
					else if(((other_product_height <= max_dimensions && other_product_height > min_dimensions ) && other_product_width > min_dimensions) || ((other_product_width <= max_dimensions && other_product_width > min_dimensions) && other_product_height > min_dimensions))
					{
						$("#other_products_size_error").html("Size should be atleast "+data.categories.other_products[page].manual_dimensions.max_dimensions[0]+"X"+data.categories.other_products[page].manual_dimensions.max_dimensions[1]);
						$("#price").html("");
						return false;
					}
					else{
						$("#other_products_size_error").html("");
					}
					var calc_price = size.prices[0] * thickness * other_product_width/100 * other_product_height/100;
					if(calc_price < size.min_price)
					{
						calc_price = size.min_price;
					}
					$("#price").html(Math.round(calc_price)*quantity);
				}
			}
		}
	});
	}

}

function onthicknesschange(){
	$("#price").html("");
	var val = $("#other_products_type").val();
	var thickness = $("#other_products_thickness").val();
	$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
		if(typeof val != 'undefined')
		{
			var content = data.categories.other_products[val];
			if(typeof content.sizes != "undefined")
			{
				if(content.sizes.length > 1)
				{
					var sizes = "";
					$(content.sizes).each(function(index){
						if(typeof this.thickness_by_mm != "undefined" && (this.thickness_by_mm == thickness))
						{
							var dimension = "";
							$(this.dimensions).each(function(index){
								dimension += '<option value="'+index+'">'+this[0]+'x'+this[1]+'</option>';
							});
							$(".other_products_size").removeClass("other_products_size_enabled");
							$(".other_products_size:eq(0)").addClass("other_products_size_enabled");
							$(".other_products_size:eq(0) option").not($(".other_products_size:eq(0) option:eq(0)")).remove();
							$(".other_products_size:eq(0)").append(dimension);
							$(".dimension_dropdown").css("display", "block");
						}
					});
					calc();
				}
			}
		}
	});
}

function onsizechange(){
	calc();
}

function checkGlue()
{
	calc();
}

$(document).ready(function(){

	$("#other_products_type").on("change", function(){
		var val = $(this).val();
		if(val != '')
		{
			$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
				var content = data.categories.other_products[val];
				if(typeof content.sizes != "undefined")
				{
					if(content.sizes.length > 1)
					{
						var thickness = "";
						$(content.sizes).each(function(index){
							if(typeof this.thickness_by_mm != "undefined"){
								thickness += "<option value="+this.thickness_by_mm+">"+this.thickness_by_mm+"mm</option>";
							}
						});
						$(".thickness_range_dropdown, .thickness_line").css("display", "none");
						$(".thickness_dropdown, .glue_checkbox, .dimension_dropdown").css("display", "block");
						$(".other_products_thickness_range").removeClass("other_products_thickness_enabled");
						$(".other_products_thickness_range").val("");
						$(".other_products_thickness").removeClass("other_products_thickness_enabled");
						$(".other_products_thickness:eq(0)").addClass("other_products_thickness_enabled");
						$(".other_products_thickness:eq(0) option").not($(".other_products_thickness:eq(0) option:eq(0)")).remove();
						$(".other_products_thickness:eq(0)").append(thickness);
						$(".other_products_size:eq(0) option").not($(".other_products_size:eq(0) option:eq(0)")).remove();
						if(typeof content.dimensions_enabled != "undefined" && content.dimensions_enabled == false)
						{
							$(".dimension_dropdown, .field_width, .field_height").css("display", "none");
							$("#other_products_width, #other_products_width").val("");
						}
					}
					else{
						if(typeof content.sizes[0].thickness_by_mm != "undefined"){
							$(".thickness_range_dropdown, .thickness_dropdown").css("display", "none");
							$(".thickness_line").css("display", "block");
							$(".other_products_thickness_range").removeClass("other_products_thickness_range_enabled");
							$("#thickness_content").html(content.sizes[0].thickness_by_mm+"mm");
							$(".other_products_thickness:eq(0)").val("");
							$(".other_products_thickness_range").val("");
							$(".other_products_thickness:eq(1)").val(content.sizes[0].thickness_by_mm);
							//$("other_products_colors")
						}
						else if(typeof content.sizes[0].thickness_range_by_mm != "undefined")
						{
							var max_thickness = Math.max.apply(null, content.sizes[0].thickness_range_by_mm);
							var min_thickness = Math.min.apply(null, content.sizes[0].thickness_range_by_mm);
							var thickness = "";
							for(var i = Math.min(min_thickness); i <= max_thickness; i++)
							{
								thickness += "<option value="+i+">"+i+"mm</option>";
							}
							$(".other_products_thickness").removeClass("other_products_thickness_enabled");
							$(".thickness_dropdown, .glue_checkbox").css("display", "none");
							$(".thickness_range_dropdown").css("display", "block");
							$(".other_products_thickness_range_div").remove();
							$(".thickness_range_dropdown").append("<span class='other_products_thickness_range_div'><input  type='number' id='other_products_thickness_range' min='"+min_thickness+"'  max='"+max_thickness+"' class='other_products_thickness_range' onkeyup='javascript:calc();' onchange='javascript:calc();' name='other_products_thickness_range'>mm</span>");
							$(".other_products_thickness_range").removeClass("other_products_thickness_range_enabled");
							$(".other_products_thickness_range:eq(0)").addClass("other_products_thickness_range_enabled");
							$(".other_products_thickness_range:eq(0) option").not($(".other_products_thickness_range:eq(0) option:eq(0)")).remove();
							$(".other_products_thickness_range:eq(0)").append(thickness);
						}
						else
						{
							$(".other_products_thickness").removeClass("other_products_thickness_enabled");
							$(".other_products_thickness_range").removeClass("other_products_thickness_range_enabled");
							$(".thickness_range_dropdown, .thickness_dropdown, .glue_checkbox").css("display", "none");
							$(".other_products_thickness:eq(0)").val("");
							$(".other_products_thickness_range").val("");
						}

						if(typeof content.dimensions_enabled != "undefined" && content.dimensions_enabled == true)
						{
							if(typeof content.manual_dimensions != "undefined" && typeof content.manual_dimensions.max_dimensions != "undefined" && content.manual_dimensions.max_dimensions.length > 0)
							{
								$(".dimension_dropdown").css("display", "none");
								$(".field_width, .field_height").css("display", "block");
							}
							else
							{
								$(".field_width, .field_height").css("display", "none");
								$("#other_products_width, #other_products_width").val("");
								var dimension = "";
								$(content.sizes[0].dimensions).each(function(index){
									dimension += '<option value="'+index+'">'+this[0]+'x'+this[1]+'</option>';
								});
								$(".other_products_size").removeClass("other_products_size_enabled");
								$(".other_products_size:eq(0)").addClass("other_products_size_enabled");
								$(".other_products_size:eq(0) option").not($(".other_products_size:eq(0) option:eq(0)")).remove();
								$(".other_products_size:eq(0)").append(dimension);
								$(".dimension_dropdown").css("display", "block");
							}
						}
						else{
							$(".dimension_dropdown, .field_width, .field_height").css("display", "none");
							$("#other_products_width, #other_products_width").val("");
							$("#other_products_size").val("");
							$(".other_products_size:eq(0)").removeClass("other_products_size_enabled");
						}
					}
					if(typeof content.sizes[0].colors != "undefined")
					{
						var colors = "";
						$(content.sizes[0].colors).each(function(index){
							colors += '<option value="'+index+'">'+this+'</option>';
						});
						$(".other_products_colors option").not($(".other_products_colors option:eq(0)")).remove();
						$(".other_products_colors").append(colors);
						$(".field_color").css("display", "block");
					}
					else{
						$(".field_color").css("display", "none");
						$("#other_products_colors").val("");
					}
				calc();
				}

			});
			$("#price").html("");
		}
		else{
			$("#price").html("");
			$(".fieldsdisplay").css("display", "none");
		}
	});

	$(".other_products_size").on("change", function(){
		$("#price").html("");
	});

	$(".other_products_size").on("change", calc);
	$("#other_products_width, #other_products_height").on("keyup blur", calc);
});
</script>
<style>

label[for='other_products_type']{
    width:100%;
    position: absolute;
    left: 20%;
}
.other_products_error{
    display: block;
    color: red;
}
.thickness_line, .thickness_range_dropdown, .glue_checkbox, .field_color, .field_width, .field_height
{
	display: none;
}
</style>
