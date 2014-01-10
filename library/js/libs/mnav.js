if (typeof Object.create !== "function") {
    Object.create = function(obj) {
        function F() {};
        F.prototype = obj;
        return new F();
    };
}

(function($, window, undefined) {
    var Mnav = {
        init: function(options, elem) { // Initialize
            var base = this;
            base.$elem = $(elem);
            base.options = $.extend({}, $.fn.Mnav.options, base.$elem.data(), options);
            base.userOptions = options;
            base.prepContainer();
            base.prepEvents();
            base.buildWidget();
        },
        /** This is where the buttons are added to the nav **/
        buildWidget: function() {
            var base = this;
            var mobileContainer = $('<div/>', {
                'class': "mnav-mobile-btn"
            });
            base.$elem.addClass(base.options.theme);
            base.$elem.prepend(mobileContainer);
            
            if(base.options.mobileButtonPos === 'left') {
                mobileContainer.css({left:0});
            } else if(base.options.mobileButtonPos === 'right') {
                mobileContainer.css({right:0});
            } else if(base.options.mobileButtonPos === 'center') {
                mobileContainer.css({margin:'auto',position:'relative'});
                base.$elem.css({padding:'0'});
            }
            
            if(!base.options.subMenuOpen) {
                base.$elem.children('.mnav-menu').children('.mnav-menu-item').has('ul').prepend('<span class="mnav-open-close"><b class="mnav-mobile-arrow"></b></span>');
            } else {
                if(base.$elem.children('.mnav-mobile-btn').is(':visible')) {
                    base.$elem.find('.mnav-submenu').show();
                }
            }
            base.addListeners();
        },
        /** Adds listeners to the buttons **/
        addListeners: function() {
            var base = this;
            // Open the main menu
            base.$elem.children('.mnav-mobile-btn').on('click', function() {
                base.$elem.trigger('mnav.open');          
            });
            //Eww jQuery dropwdown for when we're in desktop view (hover)
            base.$elem.find('.mnav-menu-item').has('ul').one('mouseenter', function() {
                if($('#mnav-active').length === 0) {
                    $(this).attr('id', 'mnav-active');
                    base.$elem.trigger('mnav.hover');
                }   
            });
            
            if(!base.options.subMenuOpen) { // Don't attach if subMenuOpen == true
                // Showing sub menus
                base.$elem.children('.mnav-menu').on('click', '.mnav-open-close', function() {
                    $(this).siblings('.mnav-submenu').slideToggle(base.options.subMenuSpeed);
                    $(this).children('.mnav-mobile-arrow').toggleClass('mnav-mobile-arrow-mirror');
                });
            }
            // Show the menu again just in case
            $(window).resize(function() {
                if(!base.$elem.children('.mnav-mobile-btn').is(':visible')) {
                    base.$elem.find('.mnav-submenu').hide();
                    base.$elem.children('.mnav-menu').show();
                } else if(base.options.subMenuOpen) {
                    base.$elem.find('.mnav-submenu').show();
                }
            });
        },
        /** Prepares the public events **/
        prepEvents: function() {
            var base = this;
            base.$elem.on('mnav.open', function() {
                base.openMenu();    
            });
            base.$elem.on('mnav.hover', function() {
                base.openHover();
            });
        },
        /** This is where the necessary classes are added to the elements in your  nav **/
        prepContainer: function() {
            var base = this; 
            base.$elem.children('ul').addClass('mnav-menu');
            base.$elem.children('.mnav-menu')
                .children('li').addClass('mnav-menu-item');
            base.$elem.children('.mnav-menu')
                .children('li')
                    .children('ul').addClass('mnav-submenu');
            base.$elem.children('.mnav-menu')
                .children('li').children('ul')
                    .children('li')
                        .addClass('mnav-submenu-item');    
        },
        /** Event handler for opening the menu when the mobile button is pressed **/
        openMenu: function() {
            var base = this;
            base.$elem.children('.mnav-menu').slideToggle(base.subMenuSpeed);         
        },
        /** Event handler for when the menu item is hovered on **/
        openHover: function() {
            var base = this;
            var active = $('#mnav-active');
            if(!base.$elem.children('.mnav-mobile-btn').is(':visible')) {
                active.children('.mnav-submenu').slideToggle(base.subMenuSpeed);
                active.one('mouseleave', function(e) {
                    active.children('.mnav-submenu')
                    .delay(base.delayClose)
                    .slideToggle(base.subMenuSpeed, function() {
                        active.one('mouseenter', function() {
                            if($('#mnav-active').length === 0) {
                                active.attr('id', 'mnav-active');
                                base.$elem.trigger('mnav.hover');
                            } 
                        });
                    });
                });
            } else {
                active.one('mouseenter', function() {
                    if($('#mnav-active').length === 0) {
                        active.attr('id', 'mnav-active');
                        base.$elem.trigger('mnav.hover');
                    } 
                });
            }
            active.attr('id', '');
        }
    };
    $.fn.Mnav = function(options) {
        return this.each(function() {
            var mnav = Object.create(Mnav);
            mnav.init(options, this);
            $.data(this, 'Mnav', mnav);
        });
    };
    $.fn.Mnav.options = {
        theme: 'mnav-theme',        // Base class to be used
        
        mainMenuSpeed: 200,         // How fast will the main menu slide down?
        subMenuSpeed: 200,          // How fast will the sub menu slide down?
        delayClose: 250,            // How long to wait before the dropdown closes
        
        mobileButtonPos: 'right',   // Which side will the button be?
        
        subMenuOpen: false,         // Sub Menu open by default?
    };
})(jQuery, window, document);
