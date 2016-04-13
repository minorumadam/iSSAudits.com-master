//variable checking radio or check box for survey quiz last questions 
var finishAll = [];

$(function() {
    // Adding datepicker and Time picker
$('.starttime').length > 0 && $('.starttime').timespinner();

$('.endtime').length > 0 && $('.endtime').timespinner();

    $('.datepicker').length > 0 && $('.datepicker').pikaday({
        firstDay: 1,
        position: 'bottom left',
        container: $(".date_container")[0]
    });
    $('.datepicker1').length > 0 && $('.datepicker1').pikaday({
        firstDay: 1,
        position: 'bottom left',
        container: $(".date_container1")[0]
    });
    // Adding timepicker page runtime in survey quiz
    $('.surveytime').length > 0 && $('.surveytime').timespinner();
    // Adding datepicker in survey quiz
    if($('.surveydatepicker').length) {
        $('.surveydatepicker').each(function() {
            var getID = $(this).attr("id");
            $(this).parents(".start_date").append('<div class="date_container ' + getID + '"></div>');
            $('#' + getID).pikaday({
                firstDay: 1,
                position: 'bottom left',
                container: $('.' + getID)[0]
            });
        });
    }
	// Adding select in survey quiz
	$('.surveydropdown').length>0 && $('.surveydropdown').selectize({
					create: true,
					dropdownParent: 'body'
				});
});


$(document).ready(function() {
    // Adding Radio check style
    var callbacks_list = $('.demo-callbacks ul');
    $('.survey_sec input, .yes_no_option input').length > 0 && $('.survey_sec input, .yes_no_option input').on('ifCreated ifClicked ifChanged ifChecked ifUnchecked ifDisabled ifEnabled ifDestroyed', function(event) {
        callbacks_list.prepend('<li><span>#' + this.id + '</span> is ' + event.type.replace('if', '').toLowerCase() + '</li>');
    }).iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });



    //country selection

/*


    // Next button click for survey quiz
    $(".survey_sec").on("click", ".nxt", function(e) {
        e.preventDefault();
        checkRadioPlus(".survey_sec");
    });

    // Back button click for survey quiz
    $(".survey_sec").on("click", ".bck", function(e) {
        e.preventDefault();
        checkRadioMinus(".survey_sec");
    });

    // Finish button click for survey quiz
    $(".survey_sec").on("click", ".finish", function(e) {
        e.preventDefault();
        checkFinish(".survey_sec");
        if(finishAll.indexOf(true) != -1) {
            window.location = "thanks.html";
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
        }
        finishAll = [];

    });
	
	*/

});


// Next button function for survey quiz
function checkRadioPlus(id) {
        var firstIndex = 0;
        var lastIndex = $(id).find(".checkSection").length - 1;
        var checkingCheckStatus = false;
        var checkingRadioCheckbox = false;
        var currentID;
        $(id).find(".checkSection").each(function() {
            if($(this).is(':visible')) {
                currentID = $(this).attr("id");
                if($(this).find("input").is(':radio') || $(this).find("input").is(':checkbox')) {
                    $(this).find("input").each(function(i, val) {
                        if($(this).prop("checked") == true) {
                            checkingCheckStatus = true;
                            checkingRadioCheckbox = false;

                        }
                    });
                } else {
                    checkingRadioCheckbox = true;

                }


            }

        });



        if(checkingCheckStatus == true || checkingRadioCheckbox == true) {
            if(!$(id).find(".checkSection").eq(lastIndex).is(':visible')) {
                $(".bck").show();
                $('#' + currentID).hide();
                $(".finish").hide();
                $('#' + currentID).next(".checkSection").show();

            }
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
    // Back button function for survey quiz
function checkRadioMinus(id) {
    var firstIndex = 0;
    var lastIndex = $(id).find(".checkSection").length - 1;
    var checkingCheckStatus = false;
    var checkingRadioCheckbox = false;
    var currentID;
    $(".finish").hide();

    $(id).find(".checkSection").each(function() {
        if($(this).is(':visible')) {
            currentID = $(this).attr("id");
            if($(this).find("input").is(':radio') || $(this).find("input").is(':checkbox')) {
                $(this).find("input").each(function(i, val) {
                    if($(this).prop("checked") == true) {
                        checkingCheckStatus = true;
                        checkingRadioCheckbox = false;
                    }
                });
            } else {
                checkingRadioCheckbox = true;
            }


        }

    });

    if(checkingCheckStatus == true || checkingRadioCheckbox == true) {
        $(".bck").show();

        if(!$(id).find(".checkSection").eq(firstIndex).is(':visible')) {
            $(".nxt").show();

            $('#' + currentID).hide();
            $('#' + currentID).prev(".checkSection").show();

        }
        if($(id).find(".checkSection").eq(firstIndex).is(':visible')) {
            $(".bck").hide();
        }

    } else {
        var html = $("#inline_content").html();
        var winWidth = $(window).width();

        if($(id).find(".checkSection").eq(lastIndex).is(':visible')) {

            $(".nxt").hide();
            $(".finish").show();
        }

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

// Finish button function for survey quiz
function checkFinish(id) {
    var lastIndex = $(id).find(".checkSection").length - 1;
    if($(id).find(".checkSection").eq(lastIndex).is(':visible')) {

        if($(id).find(".checkSection").eq(lastIndex).find("input").is(':radio') || $(this).find("input").is(':checkbox')) {
            $(id).find(".checkSection").eq(lastIndex).find("input").each(function(i, val) {
                if($(this).prop("checked") == true) {
                    finishAll.push(true);
                } else {
                    finishAll.push(false);
                }

            });
        } else {
            finishAll.push(true);
        }
    }
}

function next(event) {
	
	document.getElementById('step').value = 'next';
    document.getElementById('question').submit();

}
function previous(event) {
	document.getElementById('step').value = 'previous';
    document.getElementById('question').submit();

	
}
function finish(event) {
	document.getElementById('step').value = 'finish';
    document.getElementById('question').submit();

	
}


function show_error(){
		var html = $("#inline_content").html();
        if(html) {
		
		var winWidth = $(window).width();
        if(winWidth < 1024) {
            $.colorbox({
                html: html,
                reposition: true,
                innerHeight: 250,
                width: "80%"
            });
        } else {
            $.colorbox({
                html: html,
                reposition: true,
                innerHeight: 250,
                width: "30%"
            });
        }
		}
}
 $(".nxt").show();
 $(".finish").hide();
 $(".bck").show();
if(q_num==q_total){
   $(".nxt").hide();
   $(".finish").show();
}
if(q_num==1){
  $(".bck").hide();
}
show_error();

