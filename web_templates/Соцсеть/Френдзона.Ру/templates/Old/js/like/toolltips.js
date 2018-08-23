$(function () {
  $('.tool_inf').each(function () {
    // options
    var distance = 6;
    var time = 190;
    var hideDelay = 100;

    var hideDelayTimer = null;

    // tracker
    var beingShown = false;
    var shown = false;
    
    var tooltops_img = $('.tooltops_img', this);
    var tooltops = $('.tooltops', this).css('opacity', 0);

    // set the mouseover and mouseout on both element
    $([tooltops_img.get(0), tooltops.get(0)]).mouseover(function () {
      // stops the hide event if we move from the tooltops_img to the tooltops element
      if (hideDelayTimer) clearTimeout(hideDelayTimer);

      // don't tooltops_img the animation again if we're being shown, or already visible
      if (beingShown || shown) {
        return;
      } else {
        beingShown = true;

        // reset position of tooltops box
        tooltops.css({
          top: -111,
          left: -7,
          display: 'block' // brings the tooltops back in to view
        })

        // (we're using chaining on the tooltops) now animate it's opacity and position
        .animate({
          top: '-=' + distance + 'px',
          opacity: 1
        }, time, 'swing', function() {
          // once the animation is complete, set the tracker variables
          beingShown = false;
          shown = true;
        });
      }
    }).mouseout(function () {
      // reset the timer if we get fired again - avoids double animations
      if (hideDelayTimer) clearTimeout(hideDelayTimer);
      
      // store the timer so that it can be cleared in the mouseover if required
      hideDelayTimer = setTimeout(function () {
        hideDelayTimer = null;
        tooltops.animate({
          top: '-=' + distance + 'px',
          opacity: 0
        }, time, 'swing', function () {
          // once the animate is complete, set the tracker variables
          shown = false;
          // hide the tooltops entirely after the effect (opacity alone doesn't do the job)
          tooltops.css('display', 'none');
        });
      }, hideDelay);
    });
  });
});