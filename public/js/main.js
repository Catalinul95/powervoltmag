$(document).ready(function(){
    $('.slider').slick({
        nextArrow: '<button class="nextArrow"><i class="fas fa-chevron-right"></i></button>',
        prevArrow: '<button class="prevArrow"><i class="fas fa-chevron-left"></i></button>',
        arrows: false,
        autoplay: true,
        infinite: true,
    });

    $('#categoriesDropdownButton').click(function (e) {
        $('#categories').toggle();
        $('.fa-chevron-down').toggle();
        $('.fa-chevron-up').toggle();
    });

    $('.products-slider').slick({
        nextArrow: '<button class="nextArrow"><i class="fas fa-chevron-right"></i></button>',
        prevArrow: '<button class="prevArrow"><i class="fas fa-chevron-left"></i></button>',
        slidesToShow: 4,
        responsive: [
            {
                breakpoint: 1400,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 750,
                settings: {
                    slidesToShow: 1,
                }
            }
        ],
    });
});