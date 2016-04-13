function ajax(action, data){	
	var new_data = GETToArray(data);
	jQuery.ajax({
		type : 'GET',
		url : '/ajax_control.php',
		data : {action: action,
				data : new_data},
		async: false, 		
		success: function(response) {
         	result = response; 
		},
		error: function(){
		}
	});	
	return result;
}

function GETToArray(get_var) {
  var request = {};
  var pairs = get_var.substring(get_var.indexOf('?') + 1).split('&');
  for (var i = 0; i < pairs.length; i++) {
    var pair = pairs[i].split('=');
    request[decodeURIComponent(pair[0])] = decodeURIComponent(pair[1]);
  }
  return request;
}

function purify(data){
	data = data.replace(/&/g, 'amp;');
	data = data.replace(/%/g, 'perc;');
	return data;
}
function is_numeric(value){
	if ((isNaN(value)) || (value.length == 0))
		return 0;
	else
		return 1;
}
function imposeMaxLength(Object, MaxLen){
  return (Object.value.length <= MaxLen);
}

function default_check(str, def){
	if( str == def )
		return '';
	else
		return str;
}

function blank_check(str, def){
	if( str == '' )
		return def;
	else
		return str;
}

var AjaxFrameBG = false;
var AjaxFrameContainer = false;

function loadAjaxFrame(url, caption){
	var pgBody = $$('body')[0];
	AjaxFrameBG = new Element('div', {'style' : 'position:fixed; height:100%; width:100%; top:0; left:0; background:black; z-index:50;'});
	AjaxFrameBG.set('opacity', 0);
	AjaxFrameContainer = new Element('div', {'style' : 'position:fixed; margin-top:-150px; margin-left:-275px; left:50%; top:50%; background:white; z-index:99;'});
	var frame = new Element('iFrame', {'src' : url, 
									   'width' : '550', 
									   'height' : '300', 
									   'scrolling' : 'auto', 
									   'style' : 'border:none;', 
									   'frameborder' : '#'});
	frame.injectInside(AjaxFrameContainer);
	var closeButton = new Element('a', {'href' : '#', 'style' : 'float:right;'});
	var captionTxt = new Element('div', {'style' : 'text-align:left; padding:10px;'});
	captionTxt.innerHTML = caption;
	closeButton.innerHTML = 'Close window';
	closeButton.addEvent('click', function(){unloadAjaxFrame(); return false;});
	captionTxt.injectInside(AjaxFrameContainer);
	closeButton.injectInside(captionTxt);
	AjaxFrameContainer.injectInside(pgBody);
	AjaxFrameBG.addEvent('click', function(){unloadAjaxFrame()});
	AjaxFrameBG.injectInside(pgBody);
	AjaxFrameBG.fade('0.85');
}

function unloadAjaxFrame(){
	if( !AjaxFrameContainer || !AjaxFrameBG )
		return false;
	new Fx.Morph(AjaxFrameContainer, {onComplete: function(){ AjaxFrameContainer.dispose(); }}).start({'opacity':0});
	new Fx.Morph(AjaxFrameBG, {onComplete: function(){ AjaxFrameBG.dispose(); }}).start({'opacity':0});
}

//window.addEvent('domready', function(){ $each($$('.AjaxFrame'), function(e){ e.addEvent('click', function(){loadAjaxFrame(this.href, this.title); return false;}); }); });