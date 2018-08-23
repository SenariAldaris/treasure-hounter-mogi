
//* Social Share *//

function DShare(siteurl, title, description, image){
	this.siteurl = siteurl;
	this.title = title;
	this.image = image;
	this.description = description;
}

function setUrlParams(siteurl, params, is_hash){
   var vars = hashes = [], hash;
   var new_params='', new_siteurl;
   var siteurl_params = siteurl.split(is_hash ? '#' : '?');
   if (siteurl_params.length>1)
	hashes = siteurl_params[1].split('&');
   var i = 0;
   var param;
   for(i = 0; i < hashes.length; i++){
    hash = hashes[i].split('=');
    vars[hash[0]] = hash[1];
   }
   for(param in params){
    vars[param] = params[param];
   }
   hash = new Array();
   for(param in vars){
     hash.push(param+'='+vars[param]);
   }
   new_params = hash.join('&');
   if (is_hash)
	return new_params;

   new_siteurl = siteurl.split('?')[0]+'?'+new_params;
   return new_siteurl;
}

function getUrlParam(siteurl, name, is_hash) {
	var hashes = [], hash;
	var siteurl_params = siteurl.split(is_hash ? '#' : '?');
	if (siteurl_params.length>1)
		hashes = siteurl_params[1].split('&');
	var i = 0;
	for(i = 0; i < hashes.length; i++){
		hash = hashes[i].split('=');
		if (hash[0] == name)
			return hash[1];
	}
	return false;
}

DShare.prototype.AddMeta = function(name, content){
	var metas = document.getElementsByTagName('meta');
	for (var i = 0; i < metas.length; i++){
		if (metas[i].name == name){
			meta.content = content;
			return;
		}
	}
	var meta = document.createElement('meta');
	meta.name = name;
	meta.content = content;
	document.getElementsByTagName('head')[0].appendChild(meta);
}

DShare.prototype.GetAJAX = function(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}


DShare.prototype.RewriteHREF = function(selector, hrefsrc){
	var elem = document.getElementsBySelector(selector);
	for (var i=0; i<elem.length; i++){
		elem[i].setAttribute("href", hrefsrc);
	}
}

DShare.prototype.ShareVKUrl = function(){
	var res = 'http://vk.com/share.php?url=' + encodeURIComponent(this.siteurl) + '&title=' + encodeURIComponent(this.title);
	if (this.image !== ''){
		res += '&image=' + encodeURIComponent(this.image);
	}
	if (this.description !== ''){
		res += '&description=' + encodeURIComponent(this.description);
	}
	if (this.description !== '' && this.image !== ''){
		res += '&noparse=true';
	}
	return res;
}

DShare.prototype.OpenVK = function(host, id, section, type){
	window.open(this.ShareVKUrl(), this.title, 'width=480,height=350');
	sendCountLikes(host, id, section, type);
}

DShare.prototype.RewriteHREFVK = function(selector){
	this.RewriteHREF(selector, this.ShareVKUrl());
}

DShare.prototype.ShareFBUrl = function(){
	var res = 'http://www.facebook.com/sharer.php?u=' + encodeURIComponent(this.siteurl) + '&t=' + encodeURIComponent(this.title);
	return res;
}

DShare.prototype.OpenFB = function(host, id, section, type){
	window.open(this.ShareFBUrl(), this.title, 'width=480,height=350');
	sendCountLikes(host, id, section, type);
}

DShare.prototype.RewriteHREFFB = function(selector){
	this.RewriteHREF(selector, this.ShareFBUrl());
}

DShare.prototype.ShareMMUrl = function(){
	var res = 'http://connect.mail.ru/share?url=' + encodeURIComponent(this.siteurl) + '&title=' + encodeURIComponent(this.title);
	if (this.image !== ''){
		res += '&imageurl=' + encodeURIComponent(this.image);
	}
	if (this.description !== ''){
		res += '&description=' + encodeURIComponent(this.description);
	}
	return res;
}

DShare.prototype.OpenMM = function(host, id, section, type){
	window.open(this.ShareMMUrl(), this.title, 'width=480,height=350');
	sendCountLikes(host, id, section, type);
}

DShare.prototype.RewriteHREFMM = function(selector){
	this.RewriteHREF(selector, this.ShareMMUrl());
}

DShare.prototype.ShareTWUrl = function(){
	var res = 'http://share.yandex.ru/go.xml?service=twitter&url=' + encodeURIComponent(this.siteurl) + '&title=' + encodeURIComponent(this.title);
	return res;
}

DShare.prototype.OpenTW = function(host, id, section, type){
	window.open(this.ShareTWUrl(), this.title, 'width=480,height=350');
	sendCountLikes(host, id, section, type);
}

DShare.prototype.RewriteHREFTW = function(selector){
	this.RewriteHREF(selector, this.ShareTWUrl());
}

DShare.prototype.ShareLJUrl = function(){
	var res = 'http://www.livejournal.com/update.bml?subject=' + encodeURIComponent(this.title) + '&event=' + encodeURIComponent("<a href='" + this.siteurl +"'>") ;
	var onlyurl = true;
	if (this.image !== ''){
		res += encodeURIComponent("<img src='" + this.image + "'/>");
		onlyurl = false;
	}
	if (this.description !== ''){
		res += encodeURIComponent("<p>" + this.description + "</p>");
		onlyurl = false;
	}
	if (onlyurl){
		res += encodeURIComponent(this.siteurl);
	}
	res += "</a>"
	return res;
}

DShare.prototype.OpenLJ = function(){
	window.open(this.ShareLJUrl(), this.title, 'width=480,height=350');
}

DShare.prototype.RewriteHREFLJ = function(selector){
	this.RewriteHREF(selector, this.ShareLJUrl());
}

DShare.prototype.ShareOKUrl = function(){
	var res = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=' + encodeURIComponent(this.siteurl);
	return res;
}

DShare.prototype.OpenOK = function(host, id, section, type){
	window.open(this.ShareOKUrl(), this.title, 'width=570,height=350');
	sendCountLikes(host, id, section, type);
}

DShare.prototype.RewriteHREFOK = function(selector){
	this.RewriteHREF(selector, this.ShareOKUrl());
}