$().ready(function ()
{
    function resize()
    {
        let width = $(window).width();
        let newheight = (width / 1920) * 600;
        if (newheight < 150)
        {
            newheight += 30;
        }
        $('.carousel').css('height', newheight + 'px')
    }

    $(window).resize(function (e)
    {
        resize();
    });
    resize();
    let currentPage = 0;
    let nextInterval = 5000;

    function moveToNextSlide()
    {
        if (currentPage >= 5 || animationRunning)
        {
            return;
        }

        animationRunning = true;
        currentPage++;

        $('.carousel').addClass('carousel_moving');
        $('.carousel').css('transform', `translateX(-${(100 / 6) * currentPage}%)`);

    }

    function moveToNextSlideClick()
    {
        if (transitionRunning)
        {
            return;
        }
        clearInterval(carouselTimer);
        moveToNextSlide();
        carouselTimer = setInterval(moveToNextSlide, nextInterval);
    }

    function moveToPrevSlideClick()
    {
        clearInterval(carouselTimer);
        currentPage--;
        prevClicked = true;
        if (currentPage < 0)
        {
            currentPage = 5;
            $('.carousel').removeClass('carousel_moving');
            $('.carousel').css('transform', `translateX(-${(100 / 6) * currentPage}%)`);
            setTimeout(function ()
            {
                currentPage--;
                $('.carousel').addClass('carousel_moving');
                $('.carousel').css('transform', `translateX(-${(100 / 6) * currentPage}%)`);
            }, 1);
        }
        else
        {
            $('.carousel').addClass('carousel_moving');
            $('.carousel').css('transform', `translateX(-${(100 / 6) * currentPage}%)`);
        }
        carouselTimer = setInterval(moveToNextSlide, nextInterval);
    }
    //arrow click events
    $(document).on('click', '.slider_mover.next', moveToNextSlideClick);
    $(document).on('click', '.slider_mover.prev', moveToPrevSlideClick);

    let sx,sy,ex,ey;
    //swipe for mobiles
    $(".carousel").on("touchstart", function (e)
    {
        sx = e.touches[0].pageX;
        sy = e.touches[0].pageY;
    });
    $(".carousel").on("touchmove", function (e)
    {
        ex = e.touches[0].pageX;
        ey = e.touches[0].pageY;
    });
    $(".carousel").on("touchend", function (e)
    {
       let delta = Math.abs(ex-sx);
       if(delta > 100) // 100 should come from width.e.x screen width = 360px,100px delta is enough,but for tablet delta can be up to 250px
       {
           if(ex > sx)
           {
               moveToPrevSlideClick();
           }
           else
           {
               moveToNextSlideClick();
           }
       }
    });


    let transitionRunning = false;
    let prevClicked = false;
    let animationRunning = false;
    $('.carousel').bind('transitionend', function (e)
    {
        if (currentPage == 5)
        {
            $('.carousel').removeClass('carousel_moving');
            $('.carousel').css('transform', 'translateX(0)');
            currentPage = 0;
        }
        else if (currentPage == 0 && prevClicked)
        {
            currentPage = 5;
            $('.carousel').removeClass('carousel_moving');
            $('.carousel').css('transform', `translateX(-${(100 / 6) * currentPage}%)`);
        }
        prevClicked = false;
        transitionRunning = false;
        animationRunning = false;
    });
    $('.carousel').bind('transitionstart', function (e)
    {
        transitionRunning = true;
    });
    $('.carousel').bind('transitionrun', function (e)
    {
        transitionRunning = true;
    });

    //start slider
    let carouselTimer = setInterval(moveToNextSlide, nextInterval);
});