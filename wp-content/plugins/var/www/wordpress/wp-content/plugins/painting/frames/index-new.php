<form action="/action_page.php" id="frame_form">
  <div class="form-group">
		<label for="frame_type">Select Frame Type: </label>
		<select name="frame_type" class="frame_type" id="frame_type">
		<?php
        $options = "";
        $frames = $jsondata['categories']['frames']['types'];
        if (isset($frames) && !empty($frames)) {
            foreach ($frames as $key_frame => $frame) {
                $newframe= ucfirst(str_replace("_", " ", $frame));
                $options .= '<option value="'.$frame.'">'.$newframe.'</option>';
            }
        }
        echo $options;
        ?>
		</select>
	</div>
	<div class="form-group field_width">
		<label for="frame_width">Width: </label>
		<input name="frame_width" class="frame_size" id="frame_width" type="text" min="0" max="120"/>cm
	</div>
	<div class="form-group field_height">
		<label for="frame_height">Height:</label>
		<input name="frame_height" class="frame_size" id="frame_height" type="text" min="0" max="140"/>cm
	</div>

	<div class="form-group">
		<span class="frame_error" id="frame_size_error"></span>
	</div>

	<div class="form-group field_size_dropdown">
		<label for="frame_size">Select Size:</label>
		<select id="frame_size" onchange="onsizechange(this);">
			<option value="">Choose one</option>
		</select>
	</div>
<div class="form-group field_cover">
    <label for="frame_cover">Select Cover Type: </label>
    <select name="frame_cover" class="frame_cover" id="frame_cover">
	<?php
    $options = "";
    $covers = $jsondata['categories']['frames']['sizes'][0]['covers'];
    if (isset($covers) && !empty($covers)) {
        foreach ($covers as $key_cover => $cover) {
            $cover= ucfirst(str_replace("_", " ", $key_cover));
            $options .= '<option value="'.$key_cover.'">'.$cover.'</option>';
        }
    }
    echo $options;
    ?>
	</select>
  </div>

  <div class="form-group field_extra">
    <label for="frame_extra">Select Extras: </label>
    <select name="frame_extra" class="frame_extra" id="frame_extra">
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

  <div class="form-group field_coating">
    <label for="frame_coating">Select Coating: </label>
    <select name="frame_coating" class="frame_coating" id="frame_coating">
	<?php
    $options = "";
    $coatings = $jsondata['categories']['frames']['sizes'][0]['coating'];
    if (isset($coatings) && !empty($coatings)) {
        foreach ($coatings as $key_extra => $coating) {
            $coating= ucfirst(str_replace("_", " ", $key_coating));
            $options .= '<option value="'.$key_coating.'">'.$coating.'</option>';
        }
    }
    echo $options;
    ?>
	</select>
  </div>

    <div class="form-group field_color">
    <label for="frame_colors">Select Color: </label>
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
		<label for="frame_quantity">Quantity:</label>
		<input id="frame_quantity" min="1" value="1" type="number" name="frame_quantity" onchange="onquantitychange(this)" onkeyup="onquantitychange(this)"/>
	</div>

	<div class="form-group">
  <label>Price: <span id="price"></span></label>
  </div>
</form>
<script>
function getMul(total, num)
{
	return total*num;
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
	var frame_type = $("#frame_type").val();
	if(frame_type == "from_catalogue")
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
	var frame_type = $("#frame_type").val();
	if(frame_type != "from_catalogue")
	{
		var frame_width = $("#frame_width").val();
		var frame_height = $("#frame_height").val();
		var frame_extra = $("#frame_extra").val();
		var frame_cover = $("#frame_cover").val();
		var frame_coating = $("#frame_coating").val();
		var frame_colors = $("#frame_colors").val();
		var quantity = $("#frame_quantity").val();
		if(typeof frame_width != 'undefined' && frame_width > 0 && typeof frame_height != 'undefined' && frame_height > 0)
		{
			var price = 0;
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

					if(typeof frame_coating != 'undefined')
					{
						$(data.categories.frames.sizes[0].covers).each(function(index){
							if(typeof this[frame_coating].price != 'undefined')
							{
								price += parseInt(this[frame_coating].price)*(frame_width * frame_height)/10000;
								return false;
							}
						});
					}

					if(price < data.categories.frames.sizes[0].min_price)
					{
						price = data.categories.frames.sizes[0].min_price;
					}
					$(data.categories.frames.sizes[0].extras).each(function(index){
						if(this[frame_extra].length > 0 && (frame_width * frame_height) <= this[frame_extra][0].max_dimensions.reduce(getMul))
						{
							if(typeof this[frame_extra][0].price != 'undefined')
							{
								price += parseInt(this[frame_extra][0].price);
								return false;
							}
						}
						else if(this[frame_extra].length > 0 && (frame_width * frame_height) >= this[frame_extra][0].max_dimensions.reduce(getMul) && (frame_width * frame_height) <= this[frame_extra][1].max_dimensions.reduce(getMul))
						{
							if(typeof this[frame_extra][1].price != 'undefined')
							{
								price += parseInt(this[frame_extra][1].price);
							return false;
							}
						}
						else if(this[frame_extra].length > 0){
							price = 0;
							$("#frame_size_error").html("Size should be maximum "+this[frame_extra][1].max_dimensions[0]+"x"+this[frame_extra][1].max_dimensions[1]);
							return false;
						}
					});



					$("#price").html(Math.round(price)*quantity);
				}

			});
		}
	}
}
$(document).ready(function(){
	$(".frame_size").on("blur keyup", function(){
		calc();
	});
	$("#frame_type").on("change", function(){
		var frame_type = $(this).val();
		$("#frame_size").val("");
		if(frame_type == "from_catalogue")
		{
			$(".field_extra, .field_cover, .field_color, .frame_error, .field_width, .field_height, .field_coating").css("display", "none");
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
			$(".field_extra, .field_cover, .field_color, .frame_error, .field_width, .field_height, .field_coating").css("display", "block");
			$(".field_size_dropdown").css("display", "none");
		}
		calc();
	});

	$("#frame_cover").on("change", function(){
		calc();
	});
	$("#frame_extra").on("change", function(){
		calc();
	});
	$("#frame_coating").on("change", function(){
		calc();
	});
});

</script>
<style>
.field_size_dropdown
{
	display:none;
}
.frame_error{
    display: block;
    color: red;
}
</style>
