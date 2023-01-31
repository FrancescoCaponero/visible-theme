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
});