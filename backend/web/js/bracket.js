/*!
 * Bracket Plus v1.1.0 (https://themetrace.com/bracketplus)
 * Copyright 2017-2018 ThemePixels
 * Licensed under ThemeForest License
 */

'use strict';

$(document).ready(function () {

    // This will collapsed sidebar menu on left into a mini icon menu
    $('#btnLeftMenu').on('click', function () {
        var menuText = $('.menu-item-label');

        if ($('body').hasClass('collapsed-menu')) {
            $('body').removeClass('collapsed-menu');

            // show current sub menu when reverting back from collapsed menu
            $('.show-sub + .br-menu-sub').slideDown();

            $('.br-sideleft').one('transitionend', function (e) {
                menuText.removeClass('op-lg-0-force');
                menuText.removeClass('d-lg-none');
            });

        } else {
            $('body').addClass('collapsed-menu');

            // hide toggled sub menu
            $('.show-sub + .br-menu-sub').slideUp();

            menuText.addClass('op-lg-0-force');
            $('.br-sideleft').one('transitionend', function (e) {
                menuText.addClass('d-lg-none');
            });
        }
        return false;
    });



    // This will expand the icon menu when mouse cursor points anywhere
    // inside the sidebar menu on left. This will only trigget to left sidebar
    // when it's in collapsed mode (the icon only menu)
    $(document).on('mouseover', function (e) {
        e.stopPropagation();

        if ($('body').hasClass('collapsed-menu') && $('#btnLeftMenu').is(':visible')) {
            var targ = $(e.target).closest('.br-sideleft').length;
            if (targ) {
                $('body').addClass('expand-menu');

                // show current shown sub menu that was hidden from collapsed
                $('.show-sub + .br-menu-sub').slideDown();

                var menuText = $('.menu-item-label');
                menuText.removeClass('d-lg-none');
                menuText.removeClass('op-lg-0-force');

            } else {
                $('body').removeClass('expand-menu');

                // hide current shown menu
                $('.show-sub + .br-menu-sub').slideUp();

                var menuText = $('.menu-item-label');
                menuText.addClass('op-lg-0-force');
                menuText.addClass('d-lg-none');
            }
        }
    });


    $(".chosen-select").chosen({'width': '100%', 'white-space': 'nowrap'});
    // This will show sub navigation menu on left sidebar
    // only when that top level menu have a sub menu on it.
    $('.br-sideleft').on('click', '.br-menu-link', function () {
        var nextElem = $(this).next();
        var thisLink = $(this);

        if (nextElem.hasClass('br-menu-sub')) {

            if (nextElem.is(':visible')) {
                thisLink.removeClass('show-sub');
                nextElem.slideUp();
            } else {
                $('.br-menu-link').each(function () {
                    $(this).removeClass('show-sub');
                });

                $('.br-menu-sub').each(function () {
                    $(this).slideUp();
                });

                thisLink.addClass('show-sub');
                nextElem.slideDown();
            }
            return false;
        }
    });



    // This will trigger only when viewed in small devices
    // #btnLeftMenuMobile element is hidden in desktop but
    // visible in mobile. When clicked the left sidebar menu
    // will appear pushing the main content.
    $('#btnLeftMenuMobile').on('click', function () {
        $('body').addClass('show-left');
        return false;
    });



    // This is the right menu icon when it's clicked, the
    // right sidebar will appear that contains the four tab menu
    $('#btnRightMenu').on('click', function () {
        $('body').addClass('show-right');
        return false;
    });



    // This will hide sidebar when it's clicked outside of it
    $(document).on('click touchstart', function (e) {
        e.stopPropagation();

        // closing left sidebar
        if ($('body').hasClass('show-left')) {
            var targ = $(e.target).closest('.br-sideleft').length;
            if (!targ) {
                $('body').removeClass('show-left');
            }
        }

        // closing right sidebar
        if ($('body').hasClass('show-right')) {
            var targ = $(e.target).closest('.br-sideright').length;
            if (!targ) {
                $('body').removeClass('show-right');
            }
        }
    });



    // displaying time and date in right sidebar
    var interval = setInterval(function () {
        var momentNow = moment();
        $('#brDate').html(momentNow.format('MMMM DD, YYYY') + ' '
                + momentNow.format('dddd')
                .substring(0, 3).toUpperCase());
        $('#brTime').html(momentNow.format('hh:mm:ss A'));
    }, 100);

    // Datepicker
    if ($().datepicker) {
        $('.form-control-datepicker').datepicker({dateFormat: 'yy-mm-dd'})
                .on("change", function (e) {
                    console.log("Date changed: ", e.target.value);
                });
    }



    // custom scrollbar style
    $('.overflow-y-auto').perfectScrollbar();

    // jquery ui datepicker
    $('.datepicker').datepicker({dateFormat: 'yy-mm-dd'});

    // switch button
    $('.switch-button').switchButton();

    // peity charts
    $('.peity-bar').peity('bar');
    $('.peity-donut').peity('donut');

    // highlight syntax highlighter
    $('pre code').each(function (i, block) {
        hljs.highlightBlock(block);
    });

    // Initialize tooltip
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="tooltip"]').tooltip();

    // Initialize popover
    $('[data-popover-color="default"]').popover();

    $('.spark1').sparkline('html', {
        type: 'bar',
        barWidth: 8,
        height: 30,
        barColor: '#29B0D0',
        chartRangeMax: 12
    });


    $('.cal').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd'
    });

    $('.calfwd').datepicker({
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd',
        minDate: new Date()
    });

    $('.dob').datepicker({
        yearRange: "-50:-21",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });

    $("#printer").click(function () {
        var myStyle = '<link rel="stylesheet" href="/css/bracket.css" /><style>.table-bordered { border: 1px solid #000;}</style>';
        var print_area = window.open();
        print_area.document.write(myStyle + $("#printarea").html());
        print_area.document.close();
        print_area.focus();
        print_area.print();
        print_area.close();
    });


    // By default, Bootstrap doesn't auto close popover after appearing in the page
    // resulting other popover overlap each other. Doing this will auto dismiss a popover
    // when clicking anywhere outside of it
    $(document).on('click', function (e) {
        $('[data-toggle="popover"],[data-original-title]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                (($(this).popover('hide').data('bs.popover') || {}).inState || {}).click = false  // fix for BS 3.3.6
            }

        });
    });



    // Select2 Initialize
    // Select2 without the search
    if ($().select2) {
        $('.select2').select2({
            minimumResultsForSearch: Infinity
        });

        // Select2 by showing the search
        $('.select2-show-search').select2({
            minimumResultsForSearch: ''
        });

        // Select2 with tagging support
        $('.select2-tag').select2({
            tags: true,
            tokenSeparators: [',', ' ']
        });
    }


    $(document).on('change', '.bcp', function () {
        planRateUpdate(this)
    });

    $(document).on('change', '.brd', function () {
        planRateUpdate(this)
    });

    $(document).on('change', '.mrp', function () {
        planMrpUpdate(this)
    });

    $(document).on('change', '.rt', function () {
        operatorrpUpdate(this)
    });


    $("#model").on("change", function () {
        $(".disableall").addClass("invisible");
        var val = this.value;
        var ids = val.replace(/\\/g, "_");
        console.log(ids);
        $("#" + ids).removeClass("invisible");
    });
});

function planMrpUpdate($obj) {
    var amount = $($obj).closest("tr").find(".mrp").val();
    var days = $($obj).closest("tr").find("td:first span").html();
    if (!isNaN(amount) && amount.trim() != "") {
        var per_days = parseFloat(amount) / parseFloat(days);
        $($obj).closest("table").find("tbody > tr").each(function (row, tr) {
            var d = $(tr).find("td:first span").html();
            var a = per_days * parseFloat(d);
            $(tr).find(".mrp").val(a.toFixed(2));
        });
    }
}

function operatorrpUpdate($obj) {
    var amount = $($obj).closest("tr").find(".rt").val();
    var days = $($obj).closest("tr").find(".period").html();

    var per_days = parseFloat(amount) / parseFloat(days);
    $($obj).closest("table").find("tbody > tr").each(function (row, tr) {
        var d = $(tr).find(".period").html()
        var a = per_days * parseFloat(d);
        var t = calculateTax(a);
        var total = parseFloat(a) + parseFloat(t);
        $(tr).find(".rt").val(a.toFixed(2));
        $(tr).find(".mrptax").html(t);
        $(tr).find(".mrptotal").html(total);
    });
}

function planRateUpdate($obj) {
    var amount = $($obj).closest("tr").find(".bcp").val();
    var rental = $($obj).closest("tr").find(".brd").val();
    var days = $($obj).closest("tr").find("td:first span").html();

    if (!isNaN(amount) && !isNaN(rental) && amount.trim() != "" && rental.trim() != "") {
        var per_days = parseFloat(amount) / parseFloat(days);
        var per_days_rental = parseFloat(rental) / parseFloat(days);
        $($obj).closest("table").find("tbody > tr").each(function (row, tr) {
            var d = $(tr).find("td:first span").html()
            var a = per_days * parseFloat(d);
            var r = per_days_rental * parseFloat(d);
            var tax = calculateTax(a + r);
            var total = a + r + parseFloat(tax);
            //console.log(d,a);
            $(tr).find(".bcp").val(a.toFixed(2));
            $(tr).find(".brd").val(r.toFixed(2));
            $(tr).find(".bct").val(tax);
            $(tr).find(".tbct").val(total);
        });
    }
}

function calculateTax(amount) {
    return formulas.reduce((total, formula) => (parseFloat(eval(total)) + parseFloat(eval(formula)))).toFixed(2);
}

function validateAccesss(obj) {
    var accessDays = $(obj).closest('tr').find('.accessday').val();
    var starttime = parseInt($(obj).closest('tr').find('.starttime').val());
    var endtime = parseInt($(obj).closest('tr').find('.endtime').val());
    var timediff = 0;

    if (starttime > endtime) {
        timediff = starttime - endtime;
    } else if (starttime < endtime) {
        timediff = endtime - starttime;
    }
    var len = ($('#accees-policy > tbody').children().length) + 1;
    var maxlen = (accessDays == 'ALLDAYS') ? 2 : 4;

    if (timediff < 233000 && len <= maxlen && accessDays != "" && endtime != '0') {
        var $cloneObj = $("#accees-policy tbody:first").clone();
        $cloneObj.find(":input").each(function () {
            $(this).val('').attr('id', $(this).attr('id').replace('-0-', '-' + len + '-'));
            $(this).val('').attr('name', $(this).attr('name').replace('[0]', '[' + len + ']'));
        }).end().appendTo("table");
        $cloneObj.find('td:last span').attr('onclick', "$(this).closest(\'tr\').remove();");
        $cloneObj.find('td:last span').attr('class', "fa fa-minus btn btn-danger btn-xs");

        if (accessDays == 'ALLDAYS') {
            $cloneObj.find('.accessday option[value!="ALLDAYS"]').attr("disabled", true);
        }
    }

    if (len > 2 && $(".accessday").length == 2) {
        $("#accees-policy .accessday").eq(1).find(' option[disabled=disabled]').attr("disabled", false);
        if (accessDays == 'ALLDAYS') {
            $("#accees-policy .accessday").eq(1).find(' option[selected=selected]').attr("selected", false);
            $("#accees-policy .accessday").eq(1).find(' option[value!="ALLDAYS"]').attr("disabled", true);
            $("#accees-policy .accessday").eq(1).find(' option[value="ALLDAYS"]').attr("selected", true);
        } else {
            $("#accees-policy .accessday").eq(1).find(' option[value="ALLDAYS"]').attr("disabled", true);
        }
    }
}

function addmorerow(obj) {
    var $cloneObj = $("#clonetable table").clone();
    var len = ($('#clonetable > table').children().length) + 1;
    
    $cloneObj.find(".reset").each(function () {
        if (!$(this).hasClass("period")) {
            $(this).val('');
        }
        $(this).attr('name', $(this).attr('name').replace(/\[\d+]/, '[' + len + ']'));
    }).end().appendTo("#clonetable");
}

function addmoretablerow(obj) {
    var $cloneObj = $("#clonetable tbody tr:first").clone();
    var len = ($('#clonetable > tbody').children().length) + 1;
    console.log($cloneObj);

    $cloneObj.find('td:last span').attr('onclick', "$(this).closest(\'tr\').remove();");
    // $cloneObj.find('td:last span').attr('class', "fa fa-minus btn btn-danger btn-xs");
    $cloneObj.find(":input").each(function () {
        console.log(this.type);
        console.log($(this).is("button"));
        if (!$(this).is("button")) {
            $(this).val('');
            $(this).attr('name', $(this).attr('name').replace(/\[\d+]/, '[' + len + ']'));
        }

    }).end().appendTo("table");
}
