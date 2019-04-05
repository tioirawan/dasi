
    
jQuery(function ($) {
    if($(window).width() < 768) {
        $(".page-wrapper").removeClass("toggled");
    }

    // $('.uang').inputmask("999.999", { 
    //     numericInput: false, 
    //     placeholder: '0', 
    //     groupSeparator: ".", 
    //     digits: 0, 
    //     autoGroup: true, 
    //     autoUnmask: true, 
    //     rightAlign: false 
    // });
    
    $(".sidebar-dropdown > a").click(function () {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
                .parent()
                .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $("#close-sidebar").click(function () {
        $(".page-wrapper").removeClass("toggled");
    });

    $("#show-sidebar").click(function () {
        $(".page-wrapper").addClass("toggled");
    });

});
