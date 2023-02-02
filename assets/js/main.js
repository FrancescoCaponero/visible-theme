jQuery(document).ready(function($){

    // search animation
    const searchLabel = $('.custom-form label');
    const searchInput = $('.custom-form input');
    const navMenuExcept = $('.site-header .main-navigation .main-navigation__container .main-navigation__container--menu-items .nav-menu ul li').not('li:nth-child(4)');


    $('#searchsubmit').click(function(e) {
        e.preventDefault();
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


});