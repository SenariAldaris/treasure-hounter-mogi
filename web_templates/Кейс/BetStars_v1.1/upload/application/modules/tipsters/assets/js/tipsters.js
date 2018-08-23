
$(function() {
	var dates = $( "#from, #to" ).datepicker({
		defaultDate: "+1w",
		changeMonth: false,
		showOtherMonths:true,
		numberOfMonths:3,
		format: 'yyyy-mm-dd',
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});

});

////////////////////////////////////////////////////////////////////
$("#date-search").on('click', function (e){
     e.preventDefault();
       var from = $('#from').val();
	   var to = $('#to').val();
	   var user_id = $('#user_id').val();
	   var sport = $('#sport_id').val();
	   var status = $('#status').val();
        var post_url = site_url+"/tipsters/get_user_tips_by_date";
        $.ajax({
            type: "POST",
             url: post_url,
			data: {
			"from": from,
			"to": to,
			"user_id": user_id,
			"sport": sport,
			"status": status,
			"ci_csrf_token": ci_csrf_token()
			},				 
			}).done(function (data){
            $("#result").html(data);
			$("#search-tips").show();
			$("#archived-tips").hide();
        });
    
});	


$("#date-clear").on('click', function (e){
	e.preventDefault();
    $("#search-tips").hide();
	$("#archived-tips").show();

});	


//////////////////////////////////////////////////////////////////
        $(function () {
        /* jQueryKnob */

        $(".knob").knob({
          /*change : function (value) {
           //console.log("change : " + value);
           },
           release : function (value) {
           console.log("release : " + value);
           },
           cancel : function () {
           console.log("cancel : " + this.value);
           },*/
          draw: function () {

            // "tron" case
            if (this.$.data('skin') == 'tron') {

              var a = this.angle(this.cv)  // Angle
                      , sa = this.startAngle          // Previous start angle
                      , sat = this.startAngle         // Start angle
                      , ea                            // Previous end angle
                      , eat = sat + a                 // End angle
                      , r = true;

              this.g.lineWidth = this.lineWidth;

              this.o.cursor
                      && (sat = eat - 0.3)
                      && (eat = eat + 0.3);

              if (this.o.displayPrevious) {
                ea = this.startAngle + this.angle(this.value);
                this.o.cursor
                        && (sa = ea - 0.3)
                        && (ea = ea + 0.3);
                this.g.beginPath();
                this.g.strokeStyle = this.previousColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                this.g.stroke();
              }

              this.g.beginPath();
              this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
              this.g.stroke();

              this.g.lineWidth = 2;
              this.g.beginPath();
              this.g.strokeStyle = this.o.fgColor;
              this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
              this.g.stroke();

              return false;
            }
          }
        });
	});	
        /* END JQUERY KNOB */
		
		
		
		
		
		
		
		
		
		