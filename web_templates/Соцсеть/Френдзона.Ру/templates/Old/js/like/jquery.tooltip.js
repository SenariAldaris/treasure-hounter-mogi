/* JQuery Tooltip Plugin
* This notice must stay intact for usage
* Author: VAlex at http://valex.net.ru
* Visit http://valex.net.ru/ for full source code
*/
(function($){

    "use strict";

    jQuery.fn.tooltip = function(options){
        return this.each(function()
        {
            new Tooltip(this, options);
        });
    };


    var Tooltip = function(element, options)
    {
        // Element
        this.$el = $(element);

        // Options
        this.opts = $.extend({}, options);

        // Init
        this.init();
    }


    // Functionality
    Tooltip.prototype = {

        // Initialization
        init: function()
        {
            var s = {tooltiptext: this.$el.attr('title')};
            this.opts = $.extend(s, this.opts);

            var $tooltip = this.build();
            if($tooltip){
                if (this.opts.tooltiptext) //if title attribute is defined
                    this.$el.attr('title', ""); //disable it

                this.$el.mouseenter(function(e){
                    if ($tooltip.queue().length==0){
                        clearTimeout(s.hidetimer);
                        Tooltip.prototype.place(this, $tooltip, e);
                    }
                });

                this.$el.mouseleave(function(e){
                    s.hidetimer=setTimeout(function(){$tooltip.stop(true,true).hide()}, 200);
                });
            }

        }, // end init


        place:function(element, $tooltip, e){

            var $el = $(element);
            var $offset=$el.offset(); // current position of an element relative to the document. offset() returns an object containing the properties top and left.

            var windowmeasure={w:$(window).width(), h:$(window).height(), left:$(document).scrollLeft(), top:$(document).scrollTop()}; //get various window measurements
            var elmeasure={w:$el.outerWidth(), h:$el.outerHeight(), left:$offset.left, top:$offset.top}; //get various element measurements

            var arrowheight= $tooltip.data('$arrowparts').eq(0).outerHeight();
            var tooltipmeasure={w:$tooltip.outerWidth(), h:$tooltip.outerHeight()+arrowheight}; //get tooltip measurements

            var x=elmeasure.left;
            var y=elmeasure.top+elmeasure.h;
            x=(x+tooltipmeasure.w > windowmeasure.left+windowmeasure.w-3)? x-tooltipmeasure.w+elmeasure.w-5 : x; //right align tooltip if no space to the right of the element
            y = y+arrowheight;

            var isrightaligned = x != elmeasure.left; //Boolean to indicate if tooltip is right aligned

            var arrowpos=(isrightaligned)? tooltipmeasure.w-(elmeasure.left+elmeasure.w-e.pageX)-25 : e.pageX-elmeasure.left-25; //25 is to move arrow 25px to the left so it's not obscured by cursor
            if (arrowpos>tooltipmeasure.w-25) //if arrow exceeds the width of the tooltip
                arrowpos=tooltipmeasure.w-40; //move it to the left of the cursor
            else{
                arrowpos=(isrightaligned)? Math.max(elmeasure.left-x+10, arrowpos) : Math.max(15, arrowpos); //make sure arrow doesn't appear too far to the left of the tooltip
            }

            $tooltip.data('$arrowparts').css('left', arrowpos);

            var tooltipcss_before={opacity:0, left:x, top: y+tooltipmeasure.h};
            var tooltipcss_after={opacity:1, top:y};

            $tooltip.css(tooltipcss_before).show().animate(tooltipcss_after);

            return;

        }, // end place


        build:function(){

            var $tooltipContainer;
            if(this.opts.tooltiptext){
                $tooltipContainer=$('<div class="tooltip">'+this.opts.tooltiptext+'</div>').appendTo(document.body);
                $tooltipContainer.append('<div class="tooltip-arrow-border"></div>\n<div class="tooltip-arrow"></div>');
                $tooltipContainer.data('$arrowparts', $tooltipContainer.find('div.tooltip-arrow, div.tooltip-arrow-border')); //store ref to the two arrow DIVs within tooltip
                $tooltipContainer.css({display:'none', visibility:'visible'});
                this.opts.$tooltipContainer=$tooltipContainer; //remember ref to tooltip
            };

            return this.opts.$tooltipContainer;

        } // end build
    };

})(jQuery)