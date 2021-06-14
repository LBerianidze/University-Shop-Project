$().ready(function ()
{
    $(document).on('click', '.add_to_cart_button', function (e)
    {
        e.preventDefault();
        let data = {
            action: 'add_to_cart',
            'add-to-cart': $(e.currentTarget).attr('data-product_id'),
            quantity: $(e.currentTarget).attr('data-quantity')
        };
        $.ajax({
            type: "POST", url: '/', data: data, success: function (response)
            {
                $(e.currentTarget).addClass('item_added');
            }
        });
    });
    $(document).on('click', '.hamburger_btn', function (e)
    {
        $(e.currentTarget).toggleClass('menu_opened');
        $('.menu').toggleClass('open');
    });
    $(document).on('click', '.close_btn', function (e)
    {
        $('.img_preview').hide();
    });
    $(document).on('click', '.product_img_zoom', function (e)
    {
        $('.img_preview').show();
    });
    $(document).on('click', '.img_list_container img', function (e)
    {
        $('.img_list_container img').removeClass('active');
        $(e.currentTarget).addClass('active');
        let link = $(e.currentTarget).attr('data-big_image');
        $('.product_img_container img').attr('src', link);
        $('.img_preview img').attr('src', link);
    });
    $(document).on('click', '.alert_close', function (e)
    {
        $(e.currentTarget).parent().hide('slow', function ()
        {
            $(e.currentTarget).parent().remove();
        });
    });
    $(document).on('click', '.product-remove .remove', function (e)
    {
        let data = {action: 'remove_product', product_id: $(e.currentTarget).attr('data-product_id')};
        $.ajax({
            type: "POST", url: '/cart/index.php', data: data, success: function (response)
            {
                var doc = document.open("text/html", "replace");
                doc.write(response);
                doc.close();
            }
        });
    })
    $(document).on('click', '.title', function (e)
    {
        if ($('.table-responsive').is(':visible'))
        {
            $('.table-responsive').hide(100);
        }
        else
        {
            $('.table-responsive').show(100);
        }
        $('.icon-minus').toggleClass('active');

    })
    $(document).on('change', '.quantity input', function (e)
    {
        $('#update_cart').addClass('allowed');
    })
    $(document).on('click', '#update_cart', function (e)
    {
        let cart = {};
        let inputs = $('.cart-table input[type=number]');
        inputs.each(function (i, e)
        {
            let info = {qty: $(e).val()};
            cart[$(e).attr('data-product_id')] = info;
        });
        let data = {
            action: 'update_cart', cart: cart
        };
        $.ajax({
            type: "POST", url: '/cart/index.php', data: data, success: function (response)
            {
                var doc = document.open("text/html", "replace");
                doc.write(response);
                doc.close();
            }
        });
    })
    $(window).scroll(function ()
    {
        if ($('.img_preview').is(':visible'))
        {
            window.scrollTo(0, 0);
        }
        //sticky fixed
        /*        $('.menu').removeClass('open');
                $('.hamburger_btn').removeClass('menu_opened');*/
    });
    $('.img_list_container').find('img:first').addClass('active');

    $(document.body).on("click", "a.showlogin", function (e)
    {
        let d = $(e.currentTarget).attr('data-order-id');
        d = $(`.expander-${d}`);
        d.slideToggle();
    });
    $(document).on('click', '.product-remove .export', function (e)
    {
        let id = $(e.currentTarget).attr('data-user_id');
        let data = {action: 'export_user_data', user_id: id};
        $.ajax({
            type: "POST", url: '/user/admin.php', data: data, success: function (response)
            {
                var link = document.createElement('a');
                link.href = response;
                link.download = `user_${id}.txt`;
                link.click();
                link.remove();
            }
        });
    })
});