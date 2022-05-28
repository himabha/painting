<form action="/action_page.php" id="mirror_form">
<div class="form-group">
	<?php 
	$options = "<option value=''>Choose one</option>";
	$mirrors = $jsondata['categories']['mirrors'];	
	if(isset($mirrors) && !empty($mirrors))
	{
		?>
			<label for="mirror_type">Select mirror: </label>
			<select name="mirror_type" class="mirror_type" id="mirror_type">
		<?php
			foreach($mirrors as $index => $mirror){
				$mirror = str_replace("_", " ", ucfirst($index));
				$options .= '<option value="'.$index.'">'.$mirror.'</option>';
			}
			echo $options;
		?>
			</select>
	<?php
	}
	?>
  </div>

	<div class="form-group for_institutions_field">
		<label><input type="checkbox" onclick="enableInstitutions(this);" class="for_institutions" id="for_institutions" name="for_institutions"/> Mirror to institutions</label>
    </div>
	
	<div class="form-group customizable_field">
		<label><input type="checkbox" onclick="enableCustomization(this);" class="customizable" id="customizable" name="customizable"/> Customize sizes</label>
    </div>
	
	<div class="form-group" id="mirror_size_div"></div>
	
	
	<div class="form-group thickness_dropdown">
		<label for='mirror_thickness'>Select thickness: </label>
		<select id='mirror_thickness' class="mirror_thickness" onchange='javascript:onthicknesschange()' name='mirror_thickness'><option value=''>Choose one</option>
		</select>
	</div>
	
	<div class="form-group thickness_line">
		<label for="mirror_thickness">Thickness: <span id="thickness_content"></span></label><input type="hidden" name="mirror_thickness" class="mirror_thickness" id="mirror_thickness" value=""/>
	</div>	
	
	
	<div class="form-group thickness_width">
		<label for="mirror_width">Width: </label>
		<input name="mirror_width" class="mirror_size" id="mirror_width" type="text" min="0" max="120"/>cm
	</div>
	<div class="form-group thickness_height">
		<label for="mirror_height">Height:</label>
		<input name="mirror_height" class="mirror_size" id="mirror_height" type="text" min="0" max="140"/>cm
	</div>
	<div class="form-group">
		<span class="mirror_error" id="mirror_size_error"></span>
	</div>
	
	<div class="form-group finishing_dropdown">
		<label for='mirror_finishing'>Select finishing: </label>
		<select id='mirror_finishing' class="mirror_finishing" onchange='onfinishingchange(this);calc();' name='mirror_finishing'><option value=''>Choose one</option>
		</select>
	</div>
	
	<div class="form-group finishing_line">
		<label><input type="checkbox" name="mirror_finishing" class="mirror_finishing" id="mirror_finishing" onclick= "onfinishingclick(this)" value=""/> Finishing <span id="finishing_content"></span></label>
	</div>
	
	<div class="form-group hanging_type_dropdown">
		<label for='mirror_hanging_type'>Select hanging type: </label>
		<select id='mirror_hanging_type' class='mirror_hanging_type' onchange='calc()' name='mirror_hanging_type'><option value=''>Choose one</option>
		</select>
	</div>
	
	<div class="form-group hanging_type_line">
		<label for="mirror_hanging_type"><input type="checkbox" name="mirror_hanging_type" class="mirror_hanging_type" id="mirror_hanging_type" value=""/> Hanging type: <span id="hanging_type_content"></label>
	</div>	
	<!-- Frame starts here -->
	<div class="form-group chose_frame_field">
		<div class="form-group">
			<label for="frame_type">Select Frame Type: </label>
			<select name="frame_type" class="frame_type" id="frame_type">
			<?php 
			$options = "";
			$frames = $jsondata['categories']['frames']['types'];
			if(isset($frames) && !empty($frames))
			{
				foreach($frames as $key_frame => $frame){
					$newframe= ucfirst(str_replace("_", " ", $frame));
					$options .= '<option value="'.$frame.'">'.$newframe.'</option>';
				}
			}
			echo $options;
			?>
			</select>
		</div>
		
		<div class="form-group field_size_dropdown">
			<label for="frame_size">Select Size:</label>
			<select id="frame_size" onchange="onframesizechange(this);">
				<option value="">Choose one</option>
			</select>
		</div>
		
	<div class="form-group field_cover">
		<label for="frame_cover">Select Cover Type: </label>
		<select name="frame_cover" class="frame_cover" id="frame_cover">
		<?php 
		$options = "";
		$covers = $jsondata['categories']['frames']['sizes'][0]['covers'];
		if(isset($covers) && !empty($covers))
		{
			foreach($covers as $key_cover => $cover){
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
		if(isset($extras) && !empty($extras))
		{
			foreach($extras as $key_extra => $extra){
				$extra= ucfirst(str_replace("_", " ", $key_extra));
				$options .= '<option value="'.$key_extra.'">'.$extra.'</option>';
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
		if(isset($colors) && !empty($colors))
		{
			foreach($colors as $key_color => $color){
				$color= ucfirst(str_replace("_", " ", $color));
				$options .= '<option value="'.$key_color.'">'.$color.'</option>';
			}
		}
		echo $options;
		?>
		</select>
	  </div>
    </div>
	<!-- Frame ends here -->
	
	<div class="form-group field_quantity">
		<label for="mirror_quantity">Quantity:</label>
		<input id="mirror_quantity" min="1" value="1" type="number" name="mirror_quantity" onchange="onquantitychange(this)" onkeyup="onquantitychange(this)"/>
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

function onframesizechange(elem)
{
	var sizeindex = $(elem).val();
	var quantity = $("#mirror_quantity").val();
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
			$("#price").html(parseInt(window.mirror_price)+Math.round(quantity*price));
		}
		else{
			$("#price").html("");
		}
	});
}



function onquantitychange(elem)
{
	calc();		
}

function calc(){
	var page = $("#mirror_type").val();
	var mirror_width = $("#mirror_width").val();
	var mirror_height = $("#mirror_height").val();
	var thickness = $(".mirror_thickness.mirror_enabled").val();
	var mirror_finishing = $(".mirror_finishing.finishing_enabled").val();
	var mirror_view = $(".mirror_hanging_type.hanging_type_enabled").val();
	var quantity = $("#mirror_quantity").val();
	if((typeof mirror_width != 'undefined' && mirror_width > 0) && (typeof mirror_height != 'undefined' && mirror_height > 0))
	{
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
		if(typeof data.categories.mirrors[page] != 'undefined' && data.categories.mirrors[page].is_catalogue == false)
		{			
			$(data.categories.mirrors[page].sizes).each(function(index){
				var size = this;
				if(size.thickness_by_mm == thickness)
				{
					var max_dimensions = Math.max.apply(null, size.dimensions);
					var min_dimensions = Math.min.apply(null, size.dimensions);
					
					if(mirror_width > max_dimensions || mirror_height > max_dimensions)
					{
						$("#mirror_size_error").html("Size should be atleast "+size.dimensions[0]+"X"+size.dimensions[1]);
						$("#price").html("");
						return false;
					}
					else if(((mirror_height <= max_dimensions && mirror_height > min_dimensions ) && mirror_width > min_dimensions) || ((mirror_width <= max_dimensions && mirror_width > min_dimensions) && mirror_height > min_dimensions))
					{
						$("#mirror_size_error").html("Size should be atleast "+size.dimensions[0]+"X"+size.dimensions[1]);
						$("#price").html("");
						return false;
					}
					else{
						$("#mirror_size_error").html("");
					}
					
					var calc_price = size.price/10000*(mirror_width*mirror_height);
					if(calc_price < size.min_price)
					{
						calc_price = size.min_price;
					}
					
					if(typeof mirror_finishing != 'undefined')
					{
						var find = "_";
						var re = new RegExp(find, 'g');
						mirror_finishing = mirror_finishing.replace(re, " ");				
						$(data.categories.mirrors[page].finishing).each(function(index){
							var finishing = this;
							if(mirror_finishing == finishing.type)
							{
								calc_price += finishing.price_by_meter/100;
								return false;
							}
						});
					}
					
					if(typeof mirror_view != 'undefined')
					{
						var find = "_";
						var re = new RegExp(find, 'g');
						mirror_view = mirror_view.replace(re, " ");
						$(data.categories.mirrors[page].hanging_type).each(function(index){
							var types = this;
							if(mirror_view == types.name)
							{
								calc_price += types.price;
								return false;
							}
						});
					}
					$("#price").html(Math.round(calc_price)*quantity);
					window.mirror_price = Math.round(calc_price)*quantity;	
					if(typeof mirror_finishing != 'undefined')
					{
						var checked = $(".mirror_finishing.finishing_enabled").is(":checked");
						if(checked == true)
						{
							frame_calc();
						}
					}
				}
			});
		
		
		}
		else if(typeof data.categories.mirrors[page] != 'undefined' && data.categories.mirrors[page].is_catalogue == true)
		{
			$(data.categories.mirrors[page].catalogues[2].sizes).each(function(index){
				var size = this;
				var max_max_dimensions = Math.max.apply(null, size.max_dimensions);
				var min_max_dimensions = Math.min.apply(null, size.max_dimensions);
				var max_min_dimensions = Math.max.apply(null, size.min_dimensions);
				var min_min_dimensions = Math.min.apply(null, size.min_dimensions);
				
				//Checking for min width or height -> start here
				if(mirror_width < min_min_dimensions || mirror_height < min_min_dimensions || mirror_width > max_max_dimensions || mirror_height > max_max_dimensions)
				{
					$("#mirror_size_error").css("display", "block");
					$("#mirror_size_error").html("Size should be maximum "+size.min_dimensions[0]+"X"+size.min_dimensions[1]+" and atleast " +size.max_dimensions[0]+"X"+size.max_dimensions[1]);
					$("#price").html("");
					return false;
				}
				else if(((mirror_width >= min_min_dimensions && mirror_width < max_min_dimensions) && mirror_height < max_min_dimensions) || ((mirror_height >= min_min_dimensions && mirror_height < max_min_dimensions) && mirror_width < max_min_dimensions))
				{
					$("#mirror_size_error").css("display", "block");
					$("#mirror_size_error").html("Size should be maximum "+size.min_dimensions[0]+"X"+size.min_dimensions[1]+" and atleast " +size.max_dimensions[0]+"X"+size.max_dimensions[1]);
					$("#price").html("");
					return false;
				}
				else
				{
					$("#mirror_size_error").html("");						
				}
				var calc_price = size.price/10000*(mirror_width*mirror_height);
				if(calc_price < size.min_price)
				{
					calc_price = size.min_price;
				}
				
				$("#price").html(Math.round(calc_price)*quantity);	
			});
			
			
		}
	});
	}
}


function frame_calc(){	
	var frame_type = $("#frame_type").val();	
	if(frame_type != "from_catalogue")
	{
		var frame_width = $("#mirror_width").val();
		var frame_height = $("#mirror_height").val();
		var frame_extra = $("#frame_extra").val();
		var frame_cover = $("#frame_cover").val();
		var frame_colors = $("#frame_colors").val();
		var quantity = $("#mirror_quantity").val();
		//$("#frame_size").val("");
		if(typeof frame_width != 'undefined' && frame_width > 0 && typeof frame_height != 'undefined' && frame_height > 0)
		{
			var price = 0;
			$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
				if(typeof data.categories.frames != 'undefined')
				{			
					//$("#frame_size_error").html("");
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
					$("#price").html(parseInt(window.mirror_price)+Math.round(quantity*price));
				}
				
			});
		}
	}
}

function onthicknesschange(){
	//$("#mirror_width").val("");
	//$("#mirror_height").val("");
	$("#price").html("");
	//$(".fieldsdisplay").css("display", "block");
	//$("#mirror_size").val("");
	//$("#mirror_size_div").css("display", "none");
	$("#chose_frame").val("");
	$(".chose_frame_field, #chose_frame").css("display", "none");
	calc();
}

function onsizechange(elem, catalogue_index){
	var val =$(elem).val();
	var page = $("#mirror_type").val();
	if(typeof val != 'undefined' && val != '')
	{
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
			if(typeof data.categories.mirrors[page] != 'undefined')
			{
				$("#price").html(data.categories.mirrors[page].catalogues[catalogue_index].prices[val]);
			}
			$("#thickness_content").html(data.categories.mirrors[page].catalogues[catalogue_index].thickness[val]+"mm");
			$(".mirror_thickness").removeClass("mirror_enabled");
			$(".mirror_thickness:eq(1)").addClass("mirror_enabled");
			$(".mirror_thickness:eq(1)").val(data.categories.mirrors[page].catalogues[catalogue_index].thickness[val]);
			$(".thickness_line").css("display", "block");
			$(".thickness_dropdown").css("display", "none");
			$(".mirror_thickness:eq(0)").val("");
			//$("#mirror_thickness_div").html('<label for="mirror_width">Thickness: '+data.categories.mirrors[page].catalogues[catalogue_index].thickness[val]+'mm</label>');
		});
		//$("#mirror_thickness_div").css("display", "block");
		$("#price").html("");
	}
}

function onfinishingchange(elem){
	var page = $("#mirror_type").val();
	var value = $(elem).val();
	var find = "_";
	var re = new RegExp(find, 'g');
	value = value.replace(re, " ");
	$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
		if(typeof data.categories.mirrors[page] != 'undefined')
		{
			$(data.categories.mirrors[page].finishing).each(function(index){
				var finishing = this;
				if(finishing.type == value && finishing.chose_frame == true)
				{
					$(".chose_frame_field, #chose_frame").css("display", "block");
					return false;
				}
				else
				{
					$(".chose_frame_field #chose_frame").css("display", "none");
					$("#chose_frame").val("");
				}
			});
		}
	});
}

function onfinishingclick(elem)
{
	var page = $("#mirror_type").val();
	var value = $(elem).val();
	var checked = $(elem).is(":checked");
	var find = "_";
	var re = new RegExp(find, 'g');
	value = value.replace(re, " ");
	$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
		if(typeof data.categories.mirrors[page] != 'undefined')
		{
			$(data.categories.mirrors[page].finishing).each(function(index){
				var finishing = this;
				if(checked == true && finishing.type == value && finishing.chose_frame == true)
				{
					$(".chose_frame_field, #chose_frame").css("display", "block");
					return false;
				}
				else
				{
					$(".chose_frame_field, #chose_frame").css("display", "none");
					$("#chose_frame").val("");
				}
			});
		}
	});
	calc();

}

function enableInstitutions(elem)
{
	var page = $("#mirror_type").val();
	$(".thickness_width, .thickness_height").css("display", "none");
	$("#price").html("");
	$("#mirror_width, #mirror_height").val("");
	if($(elem).is(":checked") == false)
	{
		$(".customizable_field").css("display", "none");
		$("#customizable").val("");
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
				var content = data.categories.mirrors[page];
				if(typeof content.is_catalogue != "undefined" && content.is_catalogue == true)
				{
					$(content.catalogues).each(function(){
						if(this.is_for_institutions == false)
						{
							var size = "<label for='mirror_size'>Select catalogue size: </label><select id='mirror_size' onchange='javascript:onsizechange(this, 0)' name='mirror_size'><option value=''>Select size</option>";
							$(this.dimensions).each(function(index){
								size += "<option value='"+index+"'>"+this[0]+"x"+this[1]+"</option>";
							});
							
							size += "</select>"; 
							$("#mirror_size_div").html(size);
							//$(".fieldsdisplay").css("display", "none");
							$("#mirror_size_div").css("display", "block");
							return false;
						}						
					});
				}
			});
	}
	else{
		$(".customizable_field").css("display", "block");
		if($("#customizable").is(":checked") == false)
		{
			$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
				var content = data.categories.mirrors[page];
				if(typeof content.is_catalogue != "undefined" && content.is_catalogue == true)
				{
					$(content.catalogues).each(function(){
						if(this.is_for_institutions == true && this.customizable == false)
						{
							var size = "<label for='mirror_size'>Select catalogue size: </label><select id='mirror_size' onchange='javascript:onsizechange(this, 1)' name='mirror_size'><option value=''>Select size</option>";
							$(this.dimensions).each(function(index){
								size += "<option value='"+index+"'>"+this[0]+"x"+this[1]+"</option>";
							});
							
							size += "</select>"; 
							$("#mirror_size_div").html(size);
							//$(".fieldsdisplay").css("display", "none");
							$("#mirror_size_div").css("display", "block");
							return false;
						}						
					});
				}
			});
		}
		else{
			$("#mirror_size_div").html("");
			$("#mirror_size_div").css("display", "none");
			$(".mirror_thickness").removeClass("mirror_enabled");
			$(".mirror_thickness:eq(1)").val("");
			$(".thickness_line").css("display", "none");
			$(".thickness_width, .thickness_height").css("display", "block");
			calc();
		}
	}	
	
}

function enableCustomization(elem)
{
	var page = $("#mirror_type").val();
	$(".thickness_width, .thickness_height").css("display", "none");
	$("#price").html("");
	$("#mirror_width, #mirror_height").val("");
	if($("#for_institutions").is(":checked") == true && $("#customizable").is(":checked") == false)
	{
		$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
			var content = data.categories.mirrors[page];
			if(typeof content.is_catalogue != "undefined" && content.is_catalogue == true)
			{
				$(content.catalogues).each(function(){
					if(this.is_for_institutions == true && this.customizable == false)
					{
						var size = "<label for='mirror_size'>Select catalogue size: </label><select id='mirror_size' onchange='javascript:onsizechange(this, 1)' name='mirror_size'><option value=''>Select size</option>";
						$(this.dimensions).each(function(index){
							size += "<option value='"+index+"'>"+this[0]+"x"+this[1]+"</option>";
						});
						
						size += "</select>"; 
						$("#mirror_size_div").html(size);
						//$(".fieldsdisplay").css("display", "none");
						$("#mirror_size_div").css("display", "block");
						return false;
					}						
				});
			}
		});
	}else if($("#for_institutions").is(":checked") == true && $("#customizable").is(":checked") == true)
	{
		$("#mirror_size_div").html("");
		$("#mirror_size_div").css("display", "none");
		$(".mirror_thickness").removeClass("mirror_enabled");
		$(".mirror_thickness:eq(1)").val("");
		$(".thickness_line").css("display", "none");
		$(".thickness_width, .thickness_height").css("display", "block");
		calc();
	}
}


$(document).ready(function(){	
	$("#mirror_type").on("change", function(){
		var val = $(this).val();
		if(val != '')
		{
			$.getJSON('<?php echo plugins_url('types.json', dirname(__FILE__));?>', function(data){
				var content = data.categories.mirrors[val];
				if(typeof content.is_catalogue != "undefined" && content.is_catalogue == false)
				{		
					//$(".thickness_dropdown, .thickness_line").css("display", "none");
					$("#mirror_size_div").html("");
					$("#mirror_size_div").css("display", "none");
					$(".thickness_width, .thickness_height").css("display", "block");
					$("#for_institutions, #customizable").val("");
					$("#for_institutions, #customizable").removeAttr("checked");
					$(".for_institutions_field, .customizable_field").css("display", "none");
					$(".mirror_finishing").attr("checked", false);
					if(typeof content.sizes != "undefined")
					{
						if(content.sizes.length > 1)
						{				
							var thickness = "";
							$(content.sizes).each(function(index){
								thickness += "<option value="+this.thickness_by_mm+">"+this.thickness_by_mm+"mm</option>";
							});
							thickness += "</select>"; 
							$(".mirror_thickness").removeClass("mirror_enabled");
							$(".mirror_thickness:eq(0)").addClass("mirror_enabled");
							$(".mirror_thickness:eq(0) option").not($(".mirror_thickness:eq(0) option:eq(0)")).remove();
							$(".mirror_thickness:eq(0)").append(thickness);
							$(".mirror_thickness:eq(1)").val("");
							$(".thickness_line").css("display", "none");
							$(".thickness_dropdown").css("display", "block");
							$("#chose_frame").val("");
							$(".chose_frame_field, #chose_frame").css("display", "none");
							//$(".fieldsdisplay").css("display", "none");
							//$("#mirror_thickness_div").css("display", "block");
						}
						else{
							$("#thickness_content").html(content.sizes[0].thickness_by_mm+"mm");
							$(".mirror_thickness").removeClass("mirror_enabled");
							$(".mirror_thickness:eq(1)").addClass("mirror_enabled");
							$(".mirror_thickness:eq(1)").val(content.sizes[0].thickness_by_mm);
							$(".thickness_line").css("display", "block");
							$(".thickness_dropdown").css("display", "none");
							$(".mirror_thickness:eq(0)").val("");
							/* $(".fieldsdisplay").css("display", "block");
							$("#mirror_finishing").val("");
							$("#chose_frame").val("");
							$("#chose_frame").css("display", "none");
							$("#mirror_size").val("");
							$("#mirror_size_div").css("display", "none"); */
						}
					}
					
					if(typeof content.finishing != "undefined")
					{
						if(content.finishing.length > 1)
						{						
							$(".finishing_dropdown").css("display", "block");
							var finishing = "";
							$(content.finishing).each(function(index){
								var find = " ";
								var re = new RegExp(find, 'g');
								var type = this.type.replace(re, "_");
								finishing += "<option value="+type+">"+this.type+"</option>";
							});
							$(".finishing_line").css("display", "none");
							$(".mirror_finishing").removeClass("finishing_enabled");
							$(".mirror_finishing:eq(0)").addClass("finishing_enabled");
							$(".mirror_finishing:eq(0) option").not($(".mirror_finishing:eq(0) option:eq(0)")).remove();
							$(".mirror_finishing").append(finishing);
						}
						else{
							$(".finishing_line").css("display", "block");
							$(".finishing_dropdown").css("display", "none");
							$(".mirror_finishing").removeClass("finishing_enabled");
							$(".mirror_finishing:eq(1)").addClass("finishing_enabled");
							$(".mirror_finishing:eq(1)").val(content.finishing[0].type);
							$("#finishing_content").html(content.finishing[0].type);
						}
					}
					else{
						$(".finishing_dropdown, .finishing_line, .chose_frame_field, #chose_frame").css("display", "none");
						//$("#mirror_finishing_div").html("");
						$("#chose_frame").val("");
					}

					if(typeof content.hanging_type != "undefined")
					{
						if(content.hanging_type.length > 1)
						{			
							$(".hanging_type_dropdown").css("display", "block");
							var hanging_type = "";
							$(content.hanging_type).each(function(index){
								var find = " ";
								var re = new RegExp(find, 'g');
								var name = this.name.replace(re, "_");
								hanging_type += "<option value="+name+">"+this.name+"</option>";
							});
							$(".mirror_hanging_type").removeClass("hanging_type_enabled");
							$(".mirror_hanging_type:eq(0)").addClass("hanging_type_enabled");
							$(".mirror_hanging_type:eq(0) option").not($(".mirror_hanging_type:eq(0) option:eq(0)")).remove();
							$(".mirror_hanging_type").append(hanging_type);
						}
						else{
							$(".hanging_type_line").css("display", "block");
							$(".mirror_hanging_type").removeClass("hanging_type_enabled");
							$(".mirror_hanging_type:eq(1)").addClass("hanging_type_enabled");
							$(".mirror_hanging_type:eq(1)").val(content.hanging_type[0].name);
							$("#hanging_type_content").html(content.hanging_type[0].name);
						}
					}
					else{
						$(".hanging_type_dropdown, .hanging_type_line").css("display", "none");
					}
					calc();
				}
				else{
					$(".thickness_dropdown, .thickness_width, .thickness_height, .finishing_dropdown, .finishing_line, .hanging_type_dropdown, .hanging_type_line, .mirror_error, .chose_frame_field, .thickness_line").css("display", "none");
					$("#mirror_thickness").val("");
					$(".for_institutions_field").css("display", "block");
					$(".chose_frame").val("");	

					if($("#for_institutions").is(":checked") == false)
					{
						$(content.catalogues).each(function(){
							if(this.is_for_institutions == false)
							{
								var size = "<label for='mirror_size'>Select catalogue size: </label><select id='mirror_size' onchange='javascript:onsizechange(this, 0)' name='mirror_size'><option value=''>Select size</option>";
								$(this.dimensions).each(function(index){
									size += "<option value='"+index+"'>"+this[0]+"x"+this[1]+"</option>";
								});
								
								size += "</select>"; 
								$("#mirror_size_div").html(size);
								//$(".fieldsdisplay").css("display", "none");
								$("#mirror_size_div").css("display", "block");
								return false;
							}						
						})
						
					}
					//calc();
				}
			});
			//$("#mirror_width").val("");
			//$("#mirror_height").val("");
		$("#price").html("");
		//calc();
	}
	else{
		$("#mirror_width").val("");
		$("#mirror_height").val("");
		$("#price").html("");
		$(".fieldsdisplay").css("display", "none");
	}
	
	});
	
	$(".mirror_size").on("focus", function(){
		$("#price").html("");		
	});
	
	$(".mirror_size").on("keyup blur", calc);
});

$(document).ready(function(){
	$(".frame_size").on("blur keyup", function(){
		calc();		
	});
	$("#frame_type").on("change", function(){		
		var frame_type = $(this).val();
		$("#frame_size").val("");	
		if(frame_type == "from_catalogue")
		{
			$(".field_extra, .field_cover, .field_color, .frame_error").css("display", "none");
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
			$(".field_extra, .field_cover, .field_color, .frame_error").css("display", "block");
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
});
</script>
<style>
.mirror_error{
    display: block;
    color: red;
}

.thickness_line, .finishing_line, .hanging_type_line, .chose_frame_field, .for_institutions_field, .customizable_field, .mirror_size_div
{
	display:none;
}

.field_size_dropdown
{
	display:none;
}
.frame_error{
    display: block;
    color: red;
}
</style>

