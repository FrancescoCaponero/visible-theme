jQuery(document).ready(function($){

    // search animation
    const searchLabel = $('.custom-form label');
    const searchInput = $('.custom-form input');
    const navMenuExcept = $('.site-header .main-navigation .main-navigation__container .main-navigation__container--menu-items .nav-menu ul li').not('li:nth-child(4)');

    var clicked = false;
    $('#searchsubmit').click(function(e) {
        if (!clicked) {
            e.preventDefault();
            clicked = true;
        }    
        searchLabel.toggleClass('active-input hidden-input');
        searchInput.toggleClass('active-input hidden-input');
        if ((searchLabel && searchInput).hasClass('active-input')) {
            navMenuExcept.removeClass('active');
            navMenuExcept.addClass('hidden');
        }
        else{
            navMenuExcept.removeClass('hidden');
            navMenuExcept.addClass('active');
        }
    
      });

    

    //event listener for home select options
    var currentURL = window.location.href;

    if (currentURL === "http://localhost:8888/www/") {
        $("#go-to-permalink").click(function() {
            window.location = $(".page-home__select").val();
        });
        const select = document.querySelector('.page-home__select');
        const img = document.querySelector('.container-page-home img');
        const firstOption = select.options[0];

        // Set the initial image
        img.src = firstOption.dataset.img;


        select.addEventListener('change', function() {
            img.src = this.options[this.selectedIndex].dataset.img;
        });
    }
     

        //hero btn read more 
        const spanNext = $('.lazyblock-hero-section div div:nth-child(2) span');
        spanNext.next('p').addClass('hide-text');

        $(".read-more-btn-black").click(function() {
            spanNext.next('p').removeClass('hide-text');
            spanNext.next('p').addClass('show-text-anim');
            $(".read-more-btn-black").addClass('btn-black-hero-disappear');
        });
        const pageStoriesContainer = $('.page-stories-container');


        pageStoriesContainer.addClass('hidden-hover-stories')
        pageStoriesContainer.each(function(e) {
            $( this ).hover(
                function() {
                    $( this ).removeClass( "hidde-hover-stories" );
                    $( this ).addClass( "hover-stories" );
                    myColorData = $( this ).children().children("span").data();
                    myColorDataString = myColorData.color;

                    $(this).append("<div class='item-container-first' style=background-color:"+myColorDataString+">");
                    $(this).append("<div class='item-container-second'>");
                    for (var j = 0; j < 24; j++) {
                        $(this).find(".item-container-second").append("<div class='item-single' style=background-color:"+myColorDataString+";></div>");
                        if (Math.random() < 0.25) {
                            $(this).find(".item-single").last().addClass("random");
                        }                                                 
                        if (Math.random() < 0.15) {
                            $(this).find(".item-single").last().addClass("random2");
                        }                                                 
                      }
                }, function() {
                    $( this ).removeClass( "hover-stories" );
                    $( this ).addClass( "hidden-hover-stories");
                    $target1 = $(this).find(".item-container-first");
                    $target2 = $(this).find(".item-container-second");
                    $target1.fadeOut(400, function(){ $target1.remove(); });
                    $target2.fadeOut(200, function(){ $target2.remove(); });
                }
              );
          });

});