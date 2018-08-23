{script}
<script type="text/javascript">
{fready_begin}
	tomatAPI.init({
		webId : {webid}, 
		login : loginFunction, 
		logout : logoutFunction, 
		uid : {uid}, 
		token : {token}
	});
{fready_end}
function loginFunction() {
	document.location='index.php';
}

function logoutFunction() {
    tomatAPI.onLogout();
}
</script>