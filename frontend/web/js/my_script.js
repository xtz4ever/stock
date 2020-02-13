$(document).on('click','.modal_xtz',function(e){
    e.preventDefault();

    var id = $(this).data('modal');
    var txt = $(this).data('info');
    // var title =  $(this).data('title'); // для изменения title в модалке
    $(".popup[data-modal=" + id + "]").toggle("fade", 200).find("form").css('display', 'block');
    $(".popup[data-modal=" + id + "] input[name=form_name]").val(txt);
    // $(".popup[data-modal="+id+"] h2").html(title); // прописать в ссылку data-title="нужный title"
    mCustomScrollbarModal();
});

//accordion
$(document).on('click','.accordion_xtz',function(e){

        var $content = $(this).next();
        if ($content.is(":visible")) {
            //если нажали на title аккордеона,
            $content.slideUp('fast', function () {//и если контент аккордеона видимый, то
            }); //убираем его
            $(this).children().removeClass("active"); //убираем активный класс у стрелки к примеру
            $(this).removeClass("active");
        } else {
            $(".accordion .accordion_content").slideUp('fast'); //если невидимый, прячем все скрытые
            $(".accordion .accordion_title").children() //убираем активный класс у стрелки к примеру
                .removeClass("active");
            $content.slideToggle("fast");
            $(".accordion .accordion_title").removeClass("active");
            $(this).addClass("active");
            $(this).children().addClass("active"); //добавляем активный класс у стрекли к примеру
        }
    });


// Открываем модальное окно
$(document).on("click", ".modal", function (e) {
    e.preventDefault();
    var id = $(this).data('modal');
    var txt = $(this).data('info');
    // var titlдобавляет класс для анимации самой кнопкиe =  $(this).data('title'); // для изменения title в модалке
    $(".popup[data-modal=" + id + "]").toggle("fade", 200).find("form").css('display', 'block');
    $(".popup[data-modal=" + id + "] input[name=form_name]").val(txt);
    // $(".popup[data-modal="+id+"] h2").html(title); // прописать в ссылку data-title="нужный title"
    mCustomScrollbarModal();
    setTimeout(function () {

        if (window.matchMedia("(min-width: 520px)").matches) {
            selectAndInputPadding();
        }
        if (window.matchMedia("(max-width: 520px)").matches) {
            selectAndInputPaddingMobile();
        }
    }, 200);

    if (window.matchMedia("(min-width: 992px)").matches) {
        $("body").css({ "overflow": "hidden", "padding-right": "17px" });
    }
    if (window.matchMedia("(max-width: 992px)").matches) {

        $("body").css({ "overflow": "hidden", "padding-right": "0px" });
    }
});
// overlay для закрытия
$(".overlay").click(function () {
    $(this).parent().toggle("fade", 200);
    $("body").css({ "overflow": "inherit", "padding-right": "0" });
});
// закрываем модальное окно на крестик
$(".popup .close").click(function (e) {
    e.preventDefault();
    $(this).parents(".popup").hide("drop", { direction: "up" }, 200);
    $("body").css({ "overflow": "inherit", "padding-right": "0" });
});
//обработчик кнопки на нажатие btn_mnu
$("#nav-button-label").click(function (e) {
    e.preventDefault();
    $(this).toggleClass('nav-on'); // добавляет класс для анимации самой кнопки
    $(this).next().slideToggle(); // открывает меню main_nav_block, которое было скрыто
    $(this).find('.nav-line').toggleClass('active');
    $(".mnu_dropdown").toggleClass("active");
});
// Скрыть элемент при клике за его пределами бутерброд и его выпадающее меню
$(document).click(function (event) {
    if ($(event.target).closest("#nav-button-label").length) return;
    if ($(event.target).closest("[off-canvas]").length) return;
    $("#nav-button-label").removeClass("nav-on");
    $("#nav-button-label .nav-line").removeClass("active");

    event.stopPropagation();
});

// Initialize Slidebars
var controller = new slidebars();
controller.init();
// Toggle Slidebars
$('#nav-button-label').on('click', function (event) {
    // Stop default action and bubbling
    event.stopPropagation();
    event.preventDefault();
    // Toggle the Slidebar with id 'id-1'
    controller.toggle('id-1');
    $("html,body").toggleClass("slidebars");
    $(".off-canvas-wrap").toggleClass("active");
});

// Close Slidebar links
$('[off-canvas] a').on('click', function (event) {
    event.preventDefault();
    event.stopPropagation();

    var url = $(this).attr('href'),
        target = $(this).attr('target') ? $(this).attr('target') : '_self';

    $("#nav-button-label").removeClass("nav-on");
    $("#nav-button-label .nav-line").removeClass("active");
    $(".off-canvas-wrap").removeClass("active");
    $("html,body").removeClass("slidebars");
    controller.close(function () {
        window.open(url, target);
    });
});

// Add close class to canvas container when Slidebar is opened
$(controller.events).on('opening', function (event) {
    $('[canvas]').addClass('js-close-any');
});
// Add close class to canvas container when Slidebar is opened
$(controller.events).on('closing', function (event) {
    $('[canvas]').removeClass('js-close-any');
});
// Close any
$(document).on('click', '.js-close-any', function (event) {
    if (controller.getActiveSlidebar()) {
        event.preventDefault();
        event.stopPropagation();
        $("#nav-button-label").removeClass("nav-on");
        $("#nav-button-label .nav-line").removeClass("active");
        $(".off-canvas-wrap").removeClass("active");
        $("html,body").removeClass("slidebars");
        controller.close();
    }
});
// клик на ссылку вызова footer_dropdown
$('#footer-dropdown > a').on('click', function (e) {
    e.preventDefault();
});

if (window.matchMedia("(max-width: 992px)").matches) {
    footerDropdown();
}
$(document).click(function (event) {
    if ($(event.target).closest("#footer-dropdown").length) return;
    $('.footer .footer_dropdown').removeClass('active');
    $('#footer-dropdown').removeClass('active');
    event.stopPropagation();
});
function footerDropdown() {
    $('#footer-dropdown').off().on('click', function () {
        var $elem = $('.footer_dropdown');
        if ($elem.is(":hidden") || $elem.css("visibility") == "hidden" || $elem.css("opacity") == 0) {
            $('.footer_dropdown').addClass('active');
            $(this).addClass('active');
        } else {
            $('.footer_dropdown').removeClass('active');
            $(this).removeClass('active');
        }
    });
}

// Скролл по классу .scroll_to и атрибуту data-scroll у кнопки к примеру (data-scroll="куда скроллим" в элементе куда скроллим ставим id потом впишем в куда скроллим)
$(".scroll_to").on("click", function (e) {
    e.preventDefault();
    var anchor = $(this);
    $('html, body').stop().animate({
        scrollTop: $("#" + anchor.data('scroll')).offset().top
    }, 500);
    return false;
});

$(document).ready(function(){
    $('.scroll_to').fadeOut();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 250) {
            $('.scroll_to').fadeIn();
        } else {
            $('.scroll_to').fadeOut();
        }
    });
});