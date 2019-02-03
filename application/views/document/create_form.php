<?php
$js_path=$this->logik->setting("default_url")."assets/form/";

if(!empty($document_id))
{
	$document=$document[0];
?>
<div class="row"style=" background-color:white!important;">
  <?php  $this->load->view("admin/admin-menu");?>
<div class="span10" style="width:auto;">
<div id="form_builder" style=" background-color:white!important;">

<div id="statusBar">
<div style="display: block;" id="statusPanel">
<div id="statusText"><?=$this->lang->line("ld");?></div>
</div>
</div>
<div id="container">
<!--start panel-->
<div id="panel">

<div id="main">
<form id="form_result" action="">
<ul id="form_elements"></ul>
<div class="notification"  id="nofields" onclick="display_fields(0)">
<h2><?=$this->lang->line("yh");?></h2>
<p><?=$this->lang->line("ct");?></p>
</div>

<div id="div_button" class="buttons ">
<a href="#" id="form_save_button" class="positive" style="margin-left:10px;">
<img src="<?=$js_path?>images/icons/filesave.gif" alt=""> <?=$this->lang->line("sf");?></a>
</div>
</form>
<div id="debug_box"></div>
</div>
<div id="sidebar">
<ul id="tabs" class="add_field_tab">
<li id="add_field_tab"><a href="javascript:display_fields(0);" title="<?=$this->lang->line("add_a_field")?>"><?=$this->lang->line("form_aa");?></a></li>
<li id="field_prop_tab"><a href="javascript:display_field_properties();" title="<?=$this->lang->line("field_property")?>"><?=$this->lang->line("fp");?></a></li>
<li id="form_prop_tab"><a href="javascript:display_form_properties();" title="<?=$this->lang->line("form_property")?>"><?=$this->lang->line("fp1");?></a></li>
</ul>
<div style="display: block;" id="add_elements">
<div style="padding-bottom: 5px; text-align: center"><img src="<?=$js_path?>images/click_to_add1.png" /></div>
<div id="element_buttons">
<ul id="first_column">
<li><a  style="background-color:#4B75B3; height:30px;" href="javascript:insert_element('text')"><p style="text-align:center; padding-top:5px; color:white; font-size:16px;"> <?=$this->lang->line("create_document_text");?></p></a></li>
<li><a  style="background-color:#4B75B3; height:30px;" href="javascript:insert_element('textarea');"><p style="text-align:center; padding-top:5px; color:white; font-size:16px;"> <?=$this->lang->line("create_document_paragraph");?></p></a></li>
<!--<li><a style="background-color:#4B75B3; height:30px;" href="javascript:insert_element('radio');"><p style="text-align:center; padding-top:5px; color:white; font-size:16px;"> opción múltiple </p></a></li>-->
<!--<li><a id="name_text" href="javascript:insert_element('simple_name');"><img src="<?=$js_path?>images/button_text/name.gif" /></a></li>
<li><a id="time" href="javascript:insert_element('time');"><img src="<?=$js_path?>images/button_text/time.gif" /></a></li>
<li><a id="address" href="javascript:insert_element('address');"><img src="<?=$js_path?>images/button_text/address.gif" /></a></li>
<li><a id="price" href="javascript:insert_element('currency');"><img src="<?=$js_path?>images/button_text/price.gif" /></a></li>
<li><a id="section_break" href="javascript:insert_element('section');" title="<?=$this->lang->line("orgnize_form")?>"><img src="<?=$js_path?>images/button_text/section_break.gif" /></a></li>-->
</ul>

<ul id="second_column">
<!--<li><a id="number" href="javascript:insert_element('number');"><img src="<?=$js_path?>images/button_text/number.gif" /></a></li>-->
<!--<li><a style="background-color:#4B75B3; height:30px;"  href="javascript:insert_element('checkbox');"><p style="text-align:center; padding-top:5px; color:white; font-size:16px;"> Casilla </p></a></li>-->
<li><a style="background-color:#4B75B3; height:30px;" href="javascript:insert_element('select');"><p style="text-align:center; padding-top:5px; color:white; font-size:16px;"> <?=$this->lang->line("user_loading_list");?> </p></a></li>
<!--<li><a id="date" href="javascript:insert_element('date');"><img src="<?=$js_path?>images/button_text/date.gif" /></a></li>
<li><a id="phone" href="javascript:insert_element('phone');"><img src="<?=$js_path?>images/button_text/phone.gif" /></a></li>
<li><a id="web_site" href="javascript:insert_element('url');"><img src="<?=$js_path?>images/button_text/web_site.gif" /></a></li>
<li><a id="email" href="javascript:insert_element('email');"><img src="<?=$js_path?>images/button_text/email.gif" /></a></li>-->
<li><a style="background-color:#4B75B3; height:30px;"  href="javascript:insert_element('file');"><p style="text-align:center; padding-top:5px; color:white; font-size:15px;"> <?=$this->lang->line("user_loading_file");?></p></a></li>
</ul>
</div>
</div>
<form style="display: block;" id="element_properties" action="" onsubmit="return false;">
<div class="element_inactive" id="element_inactive">
<h3><b><?=$this->lang->line("ps");?></b></h3>
<p><?=$this->lang->line("co");?></p>
</div>

<div class="num" id="element_position">1</div>
<ul id="all_properties">
<li>
<label class="desc" for="element_label">
<?=$this->lang->line("fl")?>
<a href="#" class="tooltip" title="Field Label" rel="Field Label is one or two words placed directly above the field.">(?)</a>
</label>
<textarea id="element_label" class="textarea" 
					 onkeyup="set_properties(this.value, 'title')"
					  /></textarea><img src="<?=$js_path?>images/icons/arrow_left.gif" id="arrow_left" height="24" width="24" align="top" style="margin-left: 3px;" />
</li>

<li class="left half" id="prop_element_type">
<label class="desc" for="element_type" style="display:none;">
 <?=$this->lang->line("ft");?>
<a href="#" class="tooltip" title="Field Type" rel="Field Type detemines what kind of data can be collected by your field. After you save the form, the field type cannot be changed.">(?)</a>
</label>
<select class="select full" id="element_type" autocomplete="off" tabindex="12" onchange="set_properties($F(this), 'type')"  style="display:none;">
<option value="text"><?=$this->lang->line("slt");?></option>
<option value="textarea"><?=$this->lang->line("pt");?></option>
<option value="radio"><?=$this->lang->line("mc");?></option>
<option value="checkbox"><?=$this->lang->line("Checkboxes");?></option>
<option value="select"><?=$this->lang->line("dd");?></option>
<option value="number"><?=$this->lang->line("Number");?></option>
<option value="simple_name">Name<?=$this->lang->line("no");?></option>
<option value="date"><?=$this->lang->line("Date");?></option>
<option value="time"><?=$this->lang->line("Time");?></option>
<option value="phone"><?=$this->lang->line("Phone");?></option>
<option value="money"><?=$this->lang->line("Price");?></option>
<option value="url"><?=$this->lang->line("ws");?></option>
<option value="email"><?=$this->lang->line("Email");?></option>
<option value="address"><?=$this->lang->line("Address");?></option>
<option value="file"><?=$this->lang->line("fu");?></option>
<option value="section"><?=$this->lang->line("sb");?></option>
</select>
</li>

<li class="right half" id="prop_element_size">
<label class="desc" for="field_size" style="display:none;">
<?=$this->lang->line("fss");?>
<a href="#" class="tooltip" title="Field Size" rel="This property set the visual appearance of the field in your form. It does not limit nor increase the amount of data that can be collected by the field.">(?)</a>
</label>
<select class="select full" id="field_size" autocomplete="off" tabindex="13" onchange="set_properties(JJ(this).val(), 'size')" style="display:none;">
<option value="small"><?=$this->lang->line("Small");?></option>
<option value="medium"><?=$this->lang->line("Medium");?></option>
<option value="large"><?=$this->lang->line("Large");?></option>
</select>
</li>

<li class="right half" id="prop_date_format">
<label class="desc" for="field_size">
<?=$this->lang->line("df");?>
<a href="#" class="tooltip" title="Date Format" rel="You can choose between American and European Date Formats">(?)</a>
</label>
<select class="select full" id="date_type" autocomplete="off" onchange="set_properties(JJ(this).val(), 'type')">
<option id="element_date" value="date"><?=$this->lang->line("dd");?></option>
<option id="element_europe_date" value="europe_date"><?=$this->lang->line("dd");?></option>
</select>
</li>

<li class="right half" id="prop_name_format">
<label class="desc" for="name_format">
<?=$this->lang->line("nff");?>
<a href="#" class="tooltip" title="Name Format" rel="Two format available. A normal name field, or an extended name field with title and suffix.">(?)</a>
</label>
<select class="select full" id="name_format" autocomplete="off" onchange="set_properties(JJ(this).val(), 'type')">
<option id="element_simple_name" value="simple_name" selected="selected"><?=$this->lang->line("Normal");?></option>
<option id="element_name" value="name"><?=$this->lang->line("Extended");?></option>
</select>
</li>

<li class="right half" id="prop_phone_format">
<label class="desc" for="field_size">
Phone Format
<a href="#" class="tooltip" title="Phone Format" rel="You can choose between American and International Phone Formats">(?)</a>
</label>
<select class="select full" id="phone_format" autocomplete="off" onchange="set_properties(JJ(this).val(), 'type')">
<option id="element_phone" value="phone">(###) ### - ####</option>
<option id="element_simple_phone" value="simple_phone"><?=$this->lang->line("International");?></option>
</select>
</li>

<li class="right half" id="prop_currency_format">
<label class="desc" for="field_size">
Currency Format
</label>
<select class="select full" id="money_format" autocomplete="off" onchange="set_properties(JJ(this).val(), 'constraint')">
<option id="element_money_usd" value="dollar">$ <?=$this->lang->line("Dollars");?></option>
<option id="element_money_euro" value="euro">� <?=$this->lang->line("Euros");?></option>
<option id="element_money_pound" value="pound">� <?=$this->lang->line("Pounds");?></option>
<option id="element_money_yen" value="yen">� <?=$this->lang->line("Yen");?></option>
</select>
</li>

<li class="clear" id="prop_choices">
<fieldset class="choices">
<legend>
<?=$this->lang->line("Choices");?>
<a href="#" class="tooltip" title="Choices" rel="Use the plus and minus buttons to add and delete choices. Click on the star to make a choice the default selection.">(?)</a>
</legend>
<ul id="element_choices">
</ul>
</fieldset>
</li>

<li class="left half clear" id="prop_options">
<fieldset class="fieldset" style="display:none">
<legend>Rules</legend>
<input id="element_required" class="checkbox" value="" tabindex="14" onchange="(this.checked) ? checkVal = '1' : checkVal = '0';set_properties(checkVal, 'is_required')" type="checkbox">
<label class="choice" for="element_required"><?=$this->lang->line("Required");?></label>
<a href="#" class="tooltip" title="Required" rel="Checking this rule will make sure that a user fills out a particular field. A message will be displayed to the user if they have not filled out the field.">(?)</a><br>
<span id="element_unique_span">
<input id="element_unique" class="checkbox" value="" tabindex="15" onchange="(this.checked) ? checkVal = '1' : checkVal = '0';set_properties(checkVal, 'is_unique')" type="checkbox"> 
<label class="choice" for="element_unique"><?=$this->lang->line("nd");?></label>  
<a href="#" class="tooltip" title="No Duplicates" rel="Checking this rule will verify that the data entered into this field is unique and has not been submitted previously.">(?)</a></span><br>
</fieldset>
</li>

<li class="right half" id="prop_access_control">
<fieldset class="fieldset" style="display:none">
<legend><?=$this->lang->line("fv");?></legend>
<input id="fieldPublic" name="security" class="radio" value="" checked="checked" tabindex="16" onclick="set_properties('0', 'is_private')" type="radio">
<label class="choice" for="fieldPublic"><?=$this->lang->line("Everyone");?></label>
<a href="#" class="tooltip" title="Visible to Everyone" rel="This is the default option. The field will be accessible by anyone when the form is made public.">(?)</a><br>
<span id="admin_only_span">
<input id="fieldPrivate" name="security" class="radio" value="" tabindex="17" onclick="set_properties('1', 'is_private')" type="radio">
<label class="choice" for="fieldPrivate"><?=$this->lang->line("ao");?></label>
<a href="#" class="tooltip" title="Admin Only" rel="Fields that are set to 'Admin Only' will not be shown to users when the form is made public.">(?)</a></span><br>
</fieldset>
</li>

<li class="left half clear" id="prop_randomize" >
<fieldset class="fieldset" style="display:none">
<legend><?=$this->lang->line("Randomize");?></legend>
<input id="element_not_random" name="randomize" class="radio" value="" checked="checked" tabindex="16" onclick="set_properties('', 'constraint')" type="radio">
<label class="choice" for="element_not_random"><?=$this->lang->line("so");?></label>
<a href="#" class="tooltip" title="Static Order" rel="This is the default option. Options will always be displayed in the order you have created them.">(?)</a><br>

<input id="element_random" name="randomize" class="radio" value="" tabindex="16" onclick="set_properties('random', 'constraint')" type="radio">
<label class="choice" for="element_random"><?=$this->lang->line("ro");?></label>
<a href="#" class="tooltip" title="Random Order" rel="Choose this if you would like the options to be shuffled around each time someone views your form.">(?)</a><br>
</fieldset>
</li>

<li class="clear" id="prop_default_value">
<label class="desc" for="element_default" style="display:none">
<?=$this->lang->line("dvv");?>
<a href="#" class="tooltip" title="Default Value" rel="By setting this value, the field will be prepopulated with the text you enter.">(?)</a>
</label>

<input style="display:none" id="element_default" class="text large" name="text" value="" tabindex="11" maxlength="255" onkeyup="set_properties($F(this), 'default_value')" onblur="set_properties($F(this), 'default_value')" type="text">
</li>

<li class="clear" id="prop_default_country">
<label class="desc" for="fieldaddress_default" style="display:none">
<?=$this->lang->line("dcc");?>
<a href="#" class="tooltip" title="Default Country" rel="By setting this value, the country field will be prepopulated with the selection you make.">(?)</a>
</label>
<select style="display:none" class="select medium" id="element_countries" onchange="set_properties($F(this), 'default_value')">
<option value=""></option>

<optgroup label="North America">
<option value="Antigua and Barbuda"><?=$this->lang->line("aab");?></option>
<option value="Bahamas"><?=$this->lang->line("Bahamas");?></option>
<option value="Barbados"><?=$this->lang->line("Barbados");?></option> 
<option value="Belize"><?=$this->lang->line("Belize");?></option> 
<option value="Canada">Canada<?=$this->lang->line("no");?></option> 
<option value="Costa Rica"><?=$this->lang->line("cr");?></option> 
<option value="Cuba"><?=$this->lang->line("Cuba");?></option> 
<option value="Dominica"><?=$this->lang->line("Dominica");?></option> 
<option value="Dominican Republic"><?=$this->lang->line("dr");?></option>
<option value="El Salvador"><?=$this->lang->line("es");?></option>
<option value="Grenada"><?=$this->lang->line("Grenada");?></option> 
<option value="Guatemala"><?=$this->lang->line("Guatemala");?></option> 
<option value="Haiti"><?=$this->lang->line("Haiti");?></option> 
<option value="Honduras"><?=$this->lang->line("Honduras");?></option> 
<option value="Jamaica"><?=$this->lang->line("Jamaica");?></option> 
<option value="Mexico"><?=$this->lang->line("Mexico");?></option> 
<option value="Nicaragua"><?=$this->lang->line("Nicaragua");?></option> 
<option value="Panama"><?=$this->lang->line("Panama");?></option> 
<option value="Puerto Rico"><?=$this->lang->line("pr");?></option> 
<option value="Saint Kitts and Nevis"><?=$this->lang->line("skk");?></option> 
<option value="Saint Lucia"><?=$this->lang->line("sl");?></option>
<option value="Saint Vincent and the Grenadines"><?=$this->lang->line("sv");?></option> 
<option value="Trinidad and Tobago"><?=$this->lang->line("tat");?></option>
<option value="United States"><?=$this->lang->line("us");?></option>
</optgroup>

<optgroup label="South America">
<option value="Argentina"><?=$this->lang->line("Argentina");?></option>
<option value="Bolivia"><?=$this->lang->line("Bolivia");?></option> 
<option value="Brazil"><?=$this->lang->line("Brazil");?></option> 
<option value="Chile"><?=$this->lang->line("Chile");?></option> 
<option value="Columbia"><?=$this->lang->line("Columbia");?></option>
<option value="Ecuador"><?=$this->lang->line("Ecuador");?></option> 
<option value="Guyana"><?=$this->lang->line("Guyana");?></option> 
<option value="Paraguay">Paraguay<?=$this->lang->line("no");?></option> 
<option value="Peru"><?=$this->lang->line("Peru");?></option> 
<option value="Suriname"><?=$this->lang->line("Suriname");?></option> 
<option value="Uruguay"><?=$this->lang->line("Uruguay");?></option> 
<option value="Venezuela"><?=$this->lang->line("Venezuela");?></option>
</optgroup>

<optgroup label="Europe">
<option value="Albania"><?=$this->lang->line("Albania");?></option>
<option value="Andorra"><?=$this->lang->line("Andorra");?></option>
<option value="Armenia"><?=$this->lang->line("Armenia");?></option>
<option value="Austria"><?=$this->lang->line("Austria");?></option>
<option value="Azerbaijan"><?=$this->lang->line("Azerbaijan");?></option>
<option value="Belarus"><?=$this->lang->line("Belarus");?></option>
<option value="Belgium"><?=$this->lang->line("Belgium");?></option> 
<option value="Bosnia and Herzegovina"><?=$this->lang->line("bah");?></option>
<option value="Bulgaria"><?=$this->lang->line("Bulgaria");?></option> 
<option value="Croatia"><?=$this->lang->line("Croatia");?></option> 
<option value="Cyprus"><?=$this->lang->line("Cyprus");?></option> 
<option value="Czech Republic"><?=$this->lang->line("crr");?></option>
<option value="Denmark"><?=$this->lang->line("Denmark");?></option> 
<option value="Estonia"><?=$this->lang->line("Estonia");?></option> 
<option value="Finland"><?=$this->lang->line("Finland");?></option> 
<option value="France"><?=$this->lang->line("France");?></option> 
<option value="Georgia"><?=$this->lang->line("Georgia");?></option>
<option value="Germany"><?=$this->lang->line("Germany");?></option>
<option value="Greece"><?=$this->lang->line("Greece");?></option> 
<option value="Hungary"><?=$this->lang->line("Hungary");?></option> 
<option value="Iceland"><?=$this->lang->line("Iceland");?></option> 
<option value="Ireland"><?=$this->lang->line("Ireland");?></option> 
<option value="Italy"><?=$this->lang->line("Italy");?></option> 
<option value="Latvia"><?=$this->lang->line("Latvia");?></option> 
<option value="Liechtenstein"><?=$this->lang->line("Liechtenstein");?></option>
<option value="Lithuania"><?=$this->lang->line("Lithuania");?></option> 
<option value="Luxembourg"><?=$this->lang->line("Luxembourg");?></option> 
<option value="Macedonia"><?=$this->lang->line("Macedonia");?></option> 
<option value="Malta"><?=$this->lang->line("Malta");?></option> 
<option value="Moldova"><?=$this->lang->line("Moldova");?></option> 
<option value="Monaco"><?=$this->lang->line("Monaco");?></option> 
<option value="Montenegro"><?=$this->lang->line("Montenegro");?></option> 
<option value="Netherlands"><?=$this->lang->line("Netherlands");?></option> 
<option value="Norway"><?=$this->lang->line("Norway");?></option> 
<option value="Poland"><?=$this->lang->line("Poland");?></option> 
<option value="Portugal"><?=$this->lang->line("Portugal");?></option>
<option value="Romania"><?=$this->lang->line("Romania");?></option> 
<option value="San Marino"><?=$this->lang->line("sm");?></option>
<option value="Serbia"><?=$this->lang->line("Serbia");?></option>
<option value="Slovakia"><?=$this->lang->line("Slovakia");?></option>
<option value="Slovenia"><?=$this->lang->line("Slovenia");?></option> 
<option value="Spain"><?=$this->lang->line("Spain");?></option> 
<option value="Sweden"><?=$this->lang->line("Sweden");?></option> 
<option value="Switzerland"><?=$this->lang->line("Switzerland");?></option> 
<option value="Ukraine"><?=$this->lang->line("Ukraine");?></option> 
<option value="United Kingdom"><?=$this->lang->line("uk");?></option>
<option value="Vatican City"><?=$this->lang->line("vc");?></option>
</optgroup>

<optgroup label="Asia">
<option value="Afghanistan"><?=$this->lang->line("Afghanistan");?></option>
<option value="Bahrain"><?=$this->lang->line("Bahrain");?></option>
<option value="Bangladesh"><?=$this->lang->line("Bangladesh");?></option>
<option value="Bhutan"><?=$this->lang->line("Bhutan");?></option>
<option value="Brunei Darussalam"><?=$this->lang->line("bdd");?></option>
<option value="Myanmar"><?=$this->lang->line("Myanmar");?></option>
<option value="Cambodia"><?=$this->lang->line("Cambodia");?></option>
<option value="China"><?=$this->lang->line("China");?></option>
<option value="East Timor"><?=$this->lang->line("et");?></option>
<option value="Hong Kong"><?=$this->lang->line("hk");?></option> 
<option value="India"><?=$this->lang->line("India");?></option>
<option value="Indonesia"><?=$this->lang->line("Indonesia");?></option>
<option value="Iran"><?=$this->lang->line("Iran");?></option>
<option value="Iraq"><?=$this->lang->line("Iraq");?></option>
<option value="Israel"><?=$this->lang->line("Israel");?></option>
<option value="Japan"><?=$this->lang->line("Japan");?></option>
<option value="Jordan"><?=$this->lang->line("Jordan");?></option>
<option value="Kazakhstan"><?=$this->lang->line("Kazakhstan");?></option>
<option value="North Korea"><?=$this->lang->line("nk");?></option>
<option value="South Korea"><?=$this->lang->line("sk");?></option>
<option value="Kuwait"><?=$this->lang->line("Kuwait");?></option> 
<option value="Kyrgyzstan"><?=$this->lang->line("Kyrgyzstan");?></option> 
<option value="Laos"><?=$this->lang->line("Laos");?></option> 
<option value="Lebanon"><?=$this->lang->line("Lebanon");?></option> 
<option value="Malaysia"><?=$this->lang->line("Malaysia");?></option> 
<option value="Maldives"><?=$this->lang->line("Maldives");?></option> 
<option value="Mongolia"><?=$this->lang->line("Mongolia");?></option> 
<option value="Nepal"><?=$this->lang->line("Nepa");?>l</option> 
<option value="Oman"><?=$this->lang->line("Oman");?></option> 
<option value="Pakistan"><?=$this->lang->line("Pakistan");?></option> 
<option value="Philippines"><?=$this->lang->line("Philippines");?></option> 
<option value="Qatar"><?=$this->lang->line("Qatar");?></option> 
<option value="Russia"><?=$this->lang->line("Russia");?></option> 
<option value="Saudi Arabia"><?=$this->lang->line("sa");?></option> 
<option value="Singapore"><?=$this->lang->line("Singapore");?></option> 
<option value="Sri Lanka"><?=$this->lang->line("Sri");?></option>
<option value="Syria"><?=$this->lang->line("Syria");?></option>
<option value="Taiwan"><?=$this->lang->line("Taiwan");?></option> 
<option value="Tajikistan"><?=$this->lang->line("Tajikistan");?></option> 
<option value="Thailand">Thailand<?=$this->lang->line("no");?></option> 
<option value="Turkey"><?=$this->lang->line("Turkey");?></option> 
<option value="Turkmenistan"><?=$this->lang->line("Turkmenistan");?></option> 
<option value="United Arab Emirates"><?=$this->lang->line("uae");?></option>
<option value="Uzbekistan"><?=$this->lang->line("Uzbekistan");?></option> 
<option value="Vietnam"><?=$this->lang->line("Vietnam");?></option> 
<option value="Yemen"><?=$this->lang->line("Yemen");?></option>
</optgroup>

<optgroup label="Oceania">
<option value="Australia"><?=$this->lang->line("Australia");?></option>
<option value="Fiji"><?=$this->lang->line("Fiji");?></option> 
<option value="Kiribati"><?=$this->lang->line("Kiribati");?></option>
<option value="Marshall Islands"><?=$this->lang->line("mi");?></option> 
<option value="Micronesia"><?=$this->lang->line("Micronesia");?></option> 
<option value="Nauru"><?=$this->lang->line("Nauru");?></option> 
<option value="New Zealand"><?=$this->lang->line("nz");?></option>
<option value="Palau"><?=$this->lang->line("Palau");?></option>
<option value="Papua New Guinea"><?=$this->lang->line("png");?></option>
<option value="Samoa">Samoa<?=$this->lang->line("no");?></option> 
<option value="Solomon Islands"><?=$this->lang->line("sll");?></option>
<option value="Tonga"><?=$this->lang->line("Tonga");?></option> 
<option value="Tuvalu"><?=$this->lang->line("Tuvalu");?></option>  
<option value="Vanuatu"><?=$this->lang->line("Vanuatu");?></option>
</optgroup>

<optgroup label="Africa">
<option value="Algeria"><?=$this->lang->line("Algeria");?></option> 
<option value="Angola"><?=$this->lang->line("Angola");?></option> 
<option value="Benin"><?=$this->lang->line("Benin");?></option> 
<option value="Botswana"><?=$this->lang->line("Botswana");?></option> 
<option value="Burkina Faso"><?=$this->lang->line("bf");?></option> 
<option value="Burundi"><?=$this->lang->line("Burundi");?></option> 
<option value="Cameroon"><?=$this->lang->line("Cameroon");?></option> 
<option value="Cape Verde"><?=$this->lang->line("cv");?></option>
<option value="Central African Republic"><?=$this->lang->line("car");?></option>
<option value="Chad"><?=$this->lang->line("Chad");?></option>  
<option value="Comoros"><?=$this->lang->line("Comoros");?></option>  
<option value="Congo"><?=$this->lang->line("Congvo");?></option>
<option value="Djibouti"><?=$this->lang->line("Djibouti");?></option> 
<option value="Egypt"><?=$this->lang->line("Egypt");?></option> 
<option value="Equatorial Guinea"><?=$this->lang->line("eg");?></option> 
<option value="Eritrea"><?=$this->lang->line("Eritrea");?></option> 
<option value="Ethiopia"><?=$this->lang->line("Ethiopia");?></option> 
<option value="Gabon"><?=$this->lang->line("Gabon");?></option> 
<option value="Gambia"><?=$this->lang->line("Gambia");?></option> 
<option value="Ghana"><?=$this->lang->line("Ghana");?></option> 
<option value="Guinea"><?=$this->lang->line("no");?></option> 
<option value="Guinea-Bissau"><?=$this->lang->line("gb");?></option>
<option value="C�te d'Ivoire"><?=$this->lang->line("cc");?></option> 
<option value="Kenya"><?=$this->lang->line("Kenya");?></option> 
<option value="Lesotho"><?=$this->lang->line("Lesotho");?></option> 
<option value="Liberia"><?=$this->lang->line("Liberia");?></option> 
<option value="Libya"><?=$this->lang->line("Libya");?></option> 
<option value="Madagascar"><?=$this->lang->line("Madagascar");?></option> 
<option value="Malawi"><?=$this->lang->line("Malaw");?>i</option> 
<option value="Mali"><?=$this->lang->line("Mali");?></option>
<option value="Mauritania"><?=$this->lang->line("Mauritania");?></option> 
<option value="Mauritius"><?=$this->lang->line("Mauritius");?></option> 
<option value="Morocco"><?=$this->lang->line("Morocco");?></option> 
<option value="Mozambique"><?=$this->lang->line("Mozambique");?></option> 
<option value="Namibia"><?=$this->lang->line("Namibia");?></option>
<option value="Niger"><?=$this->lang->line("Niger");?></option>
<option value="Nigeria">Nigeria<?=$this->lang->line("no");?></option> 
<option value="Rwanda"><?=$this->lang->line("Rwanda");?></option> 
<option value="Sao Tome and Principe"><?=$this->lang->line("sta");?></option>
<option value="Senegal"><?=$this->lang->line("Senegal");?></option> 
<option value="Seychelles"><?=$this->lang->line("Seychelles");?></option> 
<option value="Sierra Leone"><?=$this->lang->line("sla");?></option>
<option value="Somalia"><?=$this->lang->line("Somalia");?></option> 
<option value="South Africa"><?=$this->lang->line("saa");?></option>
<option value="Sudan"><?=$this->lang->line("Sudan");?></option> 
<option value="Swaziland"><?=$this->lang->line("Swaziland");?></option> 
<option value="United Republic of Tanzania"><?=$this->lang->line("Tanzania");?></option>
<option value="Togo"><?=$this->lang->line("Togo");?></option> 
<option value="Tunisia"><?=$this->lang->line("Tunisia");?></option> 
<option value="Uganda"><?=$this->lang->line("Uganda");?></option> 
<option value="Zambia"><?=$this->lang->line("Zambia");?></option> 
<option value="Zimbabwe"><?=$this->lang->line("Zimbabwe");?></option>
</optgroup>
</select>
</li>

<li class="clear" id="prop_phone_default"><span style="display:none">
<label class="desc" for="element_phone_default1">
<?=$this->lang->line("dvv");?>
<a href="#" class="tooltip" title="Default Value" rel="By setting this value, the field will be prepopulated with the text you enter.">(?)</a>
</label>

 <input id="element_phone_default1" class="text" size="3" name="text" value="" tabindex="11" maxlength="3" onkeyup="set_properties($F('element_phone_default1').toString()+$F('element_phone_default2').toString()+$F('element_phone_default3').toString(), 'default_value')" onblur="set_properties($F('element_phone_default1').toString()+$F('element_phone_default2').toString()+$F('element_phone_default3').toString(), 'default_value')" type="text"> 

<input id="element_phone_default2" class="text" size="3" name="text" value="" tabindex="11" maxlength="3" onkeyup="set_properties($F('element_phone_default1').toString()+$F('element_phone_default2').toString()+$F('element_phone_default3').toString(), 'default_value')" onblur="set_properties($F('element_phone_default1').toString()+$F('element_phone_default2').toString()+$F('element_phone_default3').toString(), 'default_value')" type="text"> -
<input id="element_phone_default3" class="text" size="4" name="text" value="" tabindex="11" maxlength="4" onkeyup="set_properties($F('element_phone_default1').toString()+$F('element_phone_default2').toString()+$F('element_phone_default3').toString(), 'default_value')" onblur="set_properties($F('element_phone_default1').toString()+$F('element_phone_default2').toString()+$F('element_phone_default3').toString(), 'default_value')" type="text"></span>
</li>

<li class="clear">
<label class="desc" for="element_instructions">
 <?=$this->lang->line("gfu");?>
<a href="#" class="tooltip" title="Guidelines" rel="This text will be displayed to your users while they're filling out particular field.">(?)</a>
</label>

<textarea class="textarea full" rows="10" cols="50" id="element_instructions" tabindex="18" onkeyup="set_properties(this.value, 'guidelines')" onblur="set_properties(this.value, 'guidelines')"></textarea>
</li>
</ul>
</form>
<ul id="add_elements_button" style="display: none; padding-top: 5px">
<li class="buttons" id="list_buttons">
<a href="#" onclick="display_fields(0);return false">
<img src="<?=$js_path?>images/icons/textfield_add.gif" alt=""><?=$this->lang->line("aaf");?></a>
</li>
</ul>
<form style="display: none;" id="form_properties" action="" onsubmit="return false;">
<ul>
<li>
<label class="desc" for="form_title"><?=$this->lang->line("ftt");?> <a class="tooltip" title="Form Title" rel="The title of your form displayed to the user when they see your form.">(?)</a></label>
<input id="form_title" class="text medium" value="" tabindex="1" maxlength="50" onkeyup="update_form(this.value, 'name')" onblur="update_form(this.value, 'name')" type="text">
</li>
<li>
<label class="desc" for="form_description"> <?=$this->lang->line("Description");?><a class="tooltip" title="Descripcion" rel="This will appear directly below the form name. Useful for displaying a short description or any instructions, notes, guidelines.">(?)</a></label>
<textarea class="textarea small" rows="10" cols="50" id="form_description" tabindex="2" onkeyup="update_form(this.value, 'description')" onblur="update_form(this.value, 'description')"></textarea>
</li>

<li style="display: none">
<input id="form_password_option" class="checkbox" value="" tabindex="5" type="checkbox">
<label class="choice" for="form_password_option"><b><?=$this->lang->line("top");?></b></label>
<a class="tooltip" title="Turn On Password Protection" rel="If enabled, all users accessing the public form will then be required to type in the password to access the form. Your form is password protected.">(?)</a><br>
<div id="form_password" class="password hide">
<img src="<?=$js_path?>images/icons/key.gif" alt="Password : ">
<input id="form_password_data" class="text" value="" size="25" tabindex="6" maxlength="255" onkeyup="update_form(this.value, 'password')" onblur="update_form(this.value, 'password')" type="password">
</div>
</li>

<li style="display: none">
<input id="form_captcha" class="checkbox" value="" onchange="(this.checked)?update_form('1', 'captcha'):update_form('0','captcha');" tabindex="6" type="checkbox">
<label class="choice" for="form_captcha"><b><?=$this->lang->line("tos");?></b></label>
<a class="tooltip" title="Turn On Spam Protection (CAPTCHA)" rel="If enabled, an image with random words will be generated (audio also provided) and users will be required to enter the correct words to be able submitting your form. This is useful to prevent abuse from bots or automated programs usually written to generate spam.">(?)</a><br>
</li>

<li style="display: none">
<input id="form_unique_ip" class="checkbox" value="" onchange="(this.checked)?update_form('1', 'unique_ip'):update_form('0','unique_ip');" tabindex="7" type="checkbox">
<label class="choice" for="form_unique_ip"><b><?=$this->lang->line("loe");?></b></label>
<a class="tooltip" title="Limit One Entry Per User" rel="Use this to prevent users from filling out your form more than once. This is done by comparing user's IP Address.">(?)</a><br>
</li>

<li style="display: none">
<fieldset>
<legend>Success Message</legend>

<div class="left">
<input id="form_success_message_option" name="confirmation" class="radio" value="" checked="checked" tabindex="8" onclick="update_form('', 'redirect'); Element.removeClassName('form_success_message', 'hide');Element.addClassName('form_redirect_url', 'hide')" type="radio">
<label class="choice" for="form_success_message_option"><?=$this->lang->line("show");?></label>
<a class="tooltip" title="Success Message" rel="This message will be displayed after your users have successfully submitted an entry.">(?)</a>
</div>

<div class="right">
<input id="form_redirect_option" name="confirmation" class="radio" value="" tabindex="7" onclick="update_form(redirect_url, 'redirect'); Element.addClassName('form_success_message', 'hide');Element.removeClassName('form_redirect_url', 'hide');" type="radio">
<label class="choice" for="form_redirect_option"><?=$this->lang->line("url");?></label>
<a class="tooltip" title="Redirect URL" rel="After your users have successfully submitted an entry, you can redirect them to another 
website/URL of your choice.">(?)</a>
</div>

<textarea class="textarea full" rows="10" cols="50" id="form_success_message" tabindex="9" onkeyup="update_form($F(this), 'success_message')" onblur="update_form($F(this), 'success_message')"><?=$this->lang->line("succ");?></textarea>

<input id="form_redirect_url" class="text full hide" name="text" value="http://" tabindex="10" onkeyup="redirect_url = $F(this);update_form($F(this), 'redirect')" onblur="urlInHistory = $F(this);update_form($F(this), 'redirect')" type="text">
</fieldset>
</li>
</ul>
</form>
</div>
</div>
</div><!--end panel-->

</div><!--end container-->

<img id="bottom" src="<?=$js_path?>images/bottom.png" class="fix_png"/>
<?php
if(empty($document->form_data))
{
$id_display=$document->id;
$form_data = '{"id":'.$id_display.',"name":"'.$document->name.'","description":"'.$this->lang->line("create_your_form_desc").'","redirect":"","success_message":"Success! Your submission has been saved!","password":"","frame_height":0,"unique_ip":0,"captcha":0};';
$string = '{"elements":[{"title":"'.$this->lang->line("default_doc_id").'","guidelines":"","size":"large","is_required":"1","is_unique":"0","is_private":"0","type":"text","position":0,"id":0,"is_db_live":"0","default_value":"","constraint":"","options":[{"option":"First option","is_default":0,"is_db_live":"0","id":"0"},{"option":"Second option","is_default":0,"is_db_live":"0","id":"0"},{"option":"Third option","is_default":0,"is_db_live":"0","id":"0"}]},{"title":"'.$this->lang->line("default_doc_desc").'","guidelines":"","size":"large","is_required":"1","is_unique":"0","is_private":"0","type":"text","position":1,"id":1,"is_db_live":"0","default_value":"","constraint":"","options":[{"option":"First option","is_default":0,"is_db_live":"0","id":"0"},{"option":"Second option","is_default":0,"is_db_live":"0","id":"0"},{"option":"Third option","is_default":0,"is_db_live":"0","id":"0"}]}]};'; 
}
else
{
	$form_data=str_replace("\\","",$document->form_data).";";
	$string=str_replace("\\","",$document->elements);
	$string=str_replace('"object":"",','',$string);
	
	
}
?>

<script type="text/javascript">
var json_form =<?=$form_data?>
<?php echo "\n";?>
var json_elements =<?=$string?>
</script>
</div>

</div>
<?php  }

else
{
?>

<script type="text/javascript">
window.location.href="<?php echo $this->logik->setting("default_url");?>"
</script>
<?php
}
?>