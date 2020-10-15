jQuery(document).ready(function(){ 
    jQuery('#show_full_title').click(function(){
      jQuery('#show_full_title, #half_title').hide();
      jQuery('#full_title').show();
    });
    jQuery("#custom_serach_top").keypress(function(event) {
	  var character = String.fromCharCode(event.keyCode);
	  return isValid(character);     
	});
});


function isValid(str) {
  return !/[~`!@#$%\^&*()+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}