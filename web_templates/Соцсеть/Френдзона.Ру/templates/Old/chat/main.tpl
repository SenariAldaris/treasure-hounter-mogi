<style>
.chat {
background-color: #e4e6e9;
height:550px;
overflow-y: scroll;
padding: 10px;
margin-left: 2px;
-webkit-box-shadow: inset 0 1px 0 #f8f8f8;
-moz-box-shadow: inset 0 1px 0 #f8f8f8;
box-shadow: inset 0 1px 0 #f8f8f8;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
$('#chatz').scrollTop(1000000);
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	vii_interval = setInterval('chatz.update()', 2000);
});
</script>
<div class="chat" id="chatz">
{comms}

<span id="msg"></span>
</div>


<div class="no_display"><audio id="new1" controls preload="auto"><source src="templates/Old/sound/message1.ogg"></source></audio></div>