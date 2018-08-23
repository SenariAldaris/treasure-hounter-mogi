var opera = Boolean(window["opera"]);
var ie = (navigator.appName.indexOf("Microsoft") != -1) && !opera;

function mju_play_track(num) {
	if (num <= 0) return false;
	var mc = ie ? window.mju : window.document.mju;
	mc.SetVariable("play_track",num);
}

function mju_play_file(chars) {
	if (!chars.length) return false;
	var mc = ie ? window.mju : window.document.mju;
	mc.SetVariable("play_file",chars);
}

function mju_do(cmd) {
	if (!cmd.length) return false;
	var mc = ie ? window.mju : window.document.mju;
	mc.SetVariable("do_"+cmd," ");
}
