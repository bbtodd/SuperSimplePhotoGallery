
"use strict";
var $ = function (id) { 
	return document.getElementById(id); 
};


var imageCache = [];
var imageCounter = 0;
var timer;

var runSlideShow = function() {
    //disable prev and next buttons when slideshow starts
    //$("previous").setAttribute("disabled", "true");
    //$("next").setAttribute("disabled", "true");

    imageCounter = (imageCounter + 1) % imageCache.length;
    var image = imageCache[imageCounter];
    $("ssimage").src = image.src;
    //$("caption").firstChild.nodeValue = image.title;
    
};

/*
var previousSlide = function() {
    imageCounter = (imageCounter - 1) % imageCache.length;
    var image = imageCache[imageCounter];

    $("image").src = image.src;
    //$("caption").firstChild.nodeValue = image.title;

   //Enable next button, if PREV has been clicked, not on last slide, so enable next button if it's not already
    if( $("next").hasAttribute("disabled") ) {
        $("next").removeAttribute("disabled");         
    }
    //Disable prev button when on first slide
    if ( imageCounter < 1 ) {
        $("previous").setAttribute("disabled", "true"); 
    }
};

var nextSlide = function() {
    imageCounter = (imageCounter + 1) % imageCache.length;
    var image = imageCache[imageCounter];

    $("image").src = image.src;
    //$("caption").firstChild.nodeValue = image.title;

    //Enable prev button: if NEXT has been clicked, not on first slide, so enable prev button if it's not already
    if( $("previous").hasAttribute("disabled") ) {
        $("previous").removeAttribute("disabled");         
    }
    //Disable next button when reach last slide
    if (  imageCounter + 1 == imageCache.length ) {
        $("next").setAttribute("disabled", "true"); 
    }

};
*/

jQuery(window).load(function () {
    // jQuery functions to initialize after the page has loaded.

    var listNode = $("image_list");    // the ul element
    if(listNode != null) {
        var links = listNode.getElementsByTagName("a");
        
        // Preload image, copy title properties, and store in array
        var i, link, image;
        for ( i = 0; i < links.length; i++ ) {
            link = links[i];
            image = new Image();
            image.src = link.getAttribute("href");
            image.title = link.getAttribute("title");
            imageCache[imageCache.length] = image;
        }

            runSlideShow();
            timer = setInterval(runSlideShow, 2000);

        // Attach start and pause event handlers
        /* buttons are currently disabled 
        $("start").onclick = function() {
            runSlideShow();
            timer = setInterval(runSlideShow, 2000);
            $("start").setAttribute("disabled", "true");
            $("pause").removeAttribute("disabled");
        }
        $("pause").onclick = function() {
            clearInterval(timer);
            $("start").removeAttribute("disabled");
            $("pause").setAttribute("disabled", "true");

            //Unless we're not on the first, enable the previous button
            if( imageCounter > 0 ) {
                $("previous").removeAttribute("disabled");
            }
            //Unless we're not on the last slide, enable the next button
            if( (imageCounter + 1) < imageCache.length ) {
                $("next").removeAttribute("disabled");
            }
        };
        $("previous").onclick = previousSlide;
        $("next").onclick = nextSlide;
        */
    } //end if

});

