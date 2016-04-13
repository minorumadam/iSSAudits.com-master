var finishAll = [];

$(function() {
    $('.starttime').length > 0 && $('.starttime').timespinner().on('focus', function(){$(this).trigger('blur')});
    $('.endtime').length > 0 && $('.endtime').timespinner().on('focus', function(){$(this).trigger('blur')});
	$('.datepicker').length > 0 && $('.datepicker').pikaday({ firstDay: 1,  position: 'bottom left', container:$(".date_container")[0] });
	$('.datepicker1').length > 0 && $('.datepicker1').pikaday({ firstDay: 1,  position: 'bottom left', container:$(".date_container1")[0] });
});


$(document).ready(function() {
    var callbacks_list = $('.demo-callbacks ul');
    $('.survey_sec input, .yes_no_option input').length > 0 && $('.survey_sec input, .yes_no_option input').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event) {
        callbacks_list.prepend('<li><span>#' + this.id + '</span> is ' + event.type.replace('if', '').toLowerCase() + '</li>');
    }).iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });

   

   

    /*----country---*/

    var $g = $('#select-links').selectize({
					theme: 'links',
					addPrecedence: true,
					valueField: 'id',
					maxItems:1,
					searchField: 'title',
					load: function(){
					
					},
					options: [
						{id: 1, title: 'images/flags/flag_1.png', url: 'United States'},
						{id: 2, title: 'images/flags/flag_2.png', url: 'India'},
						{id: 3, title: 'images/flags/flag_3.png', url: 'Italy'},
						{id: 4, title: 'images/flags/flag_4.png', url: 'South Africa'}
					],
					render: {
						option: function(data, escape) {
							return '<div class="option">' +
									'<span class="title">' + '<img src='+escape(data.title)+'>' + '</span>' +
									'<span class="ddlabel">' + escape(data.url) + '</span>' +
									
								'</div>';
						},
						item: function(data, escape) {
							//return '<div class="item"><a href="' + escape(data.url) + '">' + escape(data.title) + '</a></div>';
							return '<span>'+'<span class="ddlabel">'+'<img src='+escape(data.title)+'>' + escape(data.url) + '</span></span>';
						}
					},
					create: function(input) {
						return {
							id: 0,
							title: input,
							url: '#'
						};
					}
				})
				
				$g[0].selectize.addItem('1');

    /*----country---*/



    /*$("#datepickerstart").length>0 && $("#datepickerstart").datepicker();
	$("#datepickerend").length>0 && $("#datepickerend").datepicker();*/
	
    /*$(".datepickstart").length > 0 && $(".datepickstart").on("click", function(e) {
        e.preventDefault();
		 e.stopPropagation();
        $("#datepickerstart").datepicker();
        $("#datepickerstart").datepicker('show');
    });

    $(".datepickstop").length > 0 && $(".datepickstop").on("click", function(e) {
        e.preventDefault();
		 e.stopPropagation();
        $("#datepickerend").datepicker();
        $("#datepickerend").datepicker('show');
    });*/
});

function checkRadioPlus(id) {
    var firstIndex = 0;
    var lastIndex = $(id).find(".checkSection").length - 1;
    var checkingCheckStatus = false;
    var currentID;
    $(id).find(".checkSection").each(function() {
        if($(this).is(':visible')) {
            $(this).find(".iradio_square-blue").each(function(i, val) {
                if($(this).hasClass("checked")) {
                    checkingCheckStatus = true;
                    currentID = $(this).parents(".checkSection").attr("id");
                }
            });
        }

    });

    if(checkingCheckStatus == true) {
        if(!$(id).find(".checkSection").eq(lastIndex).is(':visible')) {
            $(".bck").show();
            $('#' + currentID).hide();
            $(".finish").hide();
            $('#' + currentID).next(".checkSection").show();

        }
		//alert(lastIndex);
        if($(id).find(".checkSection").eq(lastIndex).is(':visible')) {
		   $(".nxt").hide();
           $(".finish").show();
        }

    } else {
        var html = $("#inline_content").html();
        var winWidth = $(window).width();
        if(winWidth < 1024) {
            $.colorbox({
                html: html,
                reposition: true,
                innerHeight: 100,
                width: "80%"
            });
        } else {
            $.colorbox({
                html: html,
                reposition: true,
                innerHeight: 100,
                width: "30%"
            });
        }

        return false;
    }
}

function checkRadioMinus(id) {
    var firstIndex = 0;
    var lastIndex = $(id).find(".checkSection").length - 1;
    var checkingCheckStatus = false;
    var currentID;
    $(".finish").hide();
    $(id).find(".checkSection").each(function() {
        if($(this).is(':visible')) {
            $(this).find(".iradio_square-blue").each(function(i, val) {
                if($(this).hasClass("checked")) {
                    checkingCheckStatus = true;
                    currentID = $(this).parents(".checkSection").attr("id");
                }
            });
        }

    });

    if(checkingCheckStatus == true) {

        if(!$(id).find(".checkSection").eq(firstIndex).is(':visible')) {
            $(".nxt").show();

            $('#' + currentID).hide();
            $('#' + currentID).prev(".checkSection").show();

        }
        if(!$(id).find(".checkSection").eq(firstIndex + 1).is(':visible')) {
            $(".bck").hide();
        }


    } else {
        var html = $("#inline_content").html();
        var winWidth = $(window).width();
        if(winWidth < 1024) {
            $.colorbox({
                html: html,
                reposition: true,
                innerHeight: 100,
                width: "80%"
            });
        } else {
            $.colorbox({
                html: html,
                reposition: true,
                innerHeight: 100,
                width: "30%"
            });
        }
        e.preventDefault();
        return false;
    }
}





