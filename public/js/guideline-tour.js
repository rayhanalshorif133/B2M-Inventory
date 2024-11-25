
$(() => {

    var URL = window.location.pathname + window.location.search;

    if (URL == '/home') {
        sessionStorage.removeItem('tour');
    }

    $('.btn-guided-tour').click((e) => {
        $(".tour-tips").removeClass('hidden');
        sessionStorage.setItem('tour', 'going');
        if (URL == '/home') {
            window.history.replaceState({}, '', '?tour=going');
        } else {
            window.location.href = '/home?tour=going';
        }
    });

    $(".btn-skip").click((e) => {
        window.history.replaceState({}, '', window.location.pathname);
        $(".tour-tips").addClass('hidden');
        sessionStorage.removeItem('tour');
        // axios.put('/tips-tour-guide/update');
        location.reload();
    });

    if (URL == '/home?tour=going') {
        sessionStorage.setItem('tour', 'going');
        $('.tour-tips').removeClass('hidden').css('--top', '21.2rem').css('--left', '10rem');
        $('.tour-tips .title').text('Click here');
    };

    $("#btn-next-for-inventory").click((e) => {
        $("#sidebar_inventory").click();
        setCLickForSidebarInventory();
    });


    const setCLickForSidebarInventory = () => {
        $('.tour-tips').css('--top', '26.8rem').css('--left', '10rem');
        $('.tour-tips .title').text('Click here to create a new category');
        $("#btn-next-for-inventory").attr("id", "btn-next-for-add_new_category");
        $("#btn-next-for-add_new_category").click((e) => {
            window.location.href = '/category/create?tour=going';
        });
    };

    $("#sidebar_inventory").click((e) => {
        setCLickForSidebarInventory();
    });




    if (URL == '/category/create?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '29.5rem').css('--left', '10rem');
        $('.tour-tips .title').text('Click here to see category Lists');
        $("#btn-next-for-inventory").attr("id", "btn-next-for-see-category-list");
        $("#btn-next-for-see-category-list").click((e) => {
            $('.tour-tips').addClass('hidden')
            window.location.href = '/category/list?tour=going';
        });
    };

    //
    if (URL == '/category/list?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '32rem').css('--left', '10rem');
        $('.tour-tips .title').text('Click here to create a new product');
        $("#btn-next-for-inventory").attr("id", "btn-next-for-create-new-product");
        $("#btn-next-for-create-new-product").click((e) => {
            $('.tour-tips').addClass('hidden')
            window.location.href = '/product/create?tour=going';
        });
    };

    if (URL == '/product/create?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '12.1rem').css('--left', '22rem');
        $('.tour-tips .dark_pointer').removeClass('hidden');
        $('.tour-tips .light_pointer').addClass('hidden');


        $('.tour-tips .title').text(
            'This feature enables the manual creation of products via form submission.');
        $('.tour-tips .btn-container').addClass('hidden');
        $("#btn-next-for-inventory").attr("id", "btn-next-product-list");
        setTimeout(() => {
            $('.tour-tips .btn-container').removeClass('hidden');
            $('.tour-tips .title').text(
                'This option facilitates of product creating by submitting an Excel spreadsheet.'
            );
            $('.tour-tips').css('--top', '12.1rem').css('--left', '31rem');
        }, 2000);

        $("#btn-next-product-list").click(() => {
            $("#sidebar_inventory").click();
            $('.tour-tips .title').text('Click here to see product list');
            setTimeout(() => {
                $('.tour-tips .dark_pointer').addClass('hidden');
                $('.tour-tips .light_pointer').removeClass('hidden');
            }, 200);

            $("#btn-next-product-list").attr("id", "btn-next-product-list-show");
            $('.tour-tips').css('--top', '34.8rem').css('--left', '7rem');

            $("#btn-next-product-list-show").click(() => {
                $('.tour-tips').addClass('hidden')
                window.location.href = '/product/list?tour=going';
            });
        });
    };



    if (URL == '/product/list?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '16.3rem').css('--left', '10rem');
        $('.tour-tips .title').text('Click here for Purchase Items');
        $("#btn-next-for-inventory").attr("id", "btn-next-purchase");
    }

    $("#btn-next-purchase").click(() => {
        $("#sidebar_open_purchase").click();
        $('.tour-tips .title').text('Click here to create a new Purchase Items');
        $("#btn-next-purchase").attr("id", "btn-next-purchase-create-new");
        $('.tour-tips').css('--top', '18.6rem').css('--left', '7rem');
        $("#btn-next-purchase-create-new").click(() => {
            $('.tour-tips').addClass('hidden')
            window.location.href = '/purchase/create?tour=going';
        });
    });


    if (URL == '/purchase/create?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '21.1rem').css('--left', '7rem');
        $('.tour-tips .title').text('Click here to see purchase list');
        $("#btn-next-for-inventory").attr("id", "btn-next-purchase-list");
        $("#btn-next-purchase-list").click(function () {
            $('.tour-tips').addClass('hidden')
            window.location.href = '/purchase/list?tour=going';
        });
    }

    if (URL == '/purchase/list?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '24.1rem').css('--left', '10rem');
        $('.tour-tips .title').text('Click here to create new purchase return');
        $("#btn-next-for-inventory").attr("id", "btn-next-purchase-return-create");
        $("#btn-next-purchase-return-create").click(function () {
            $('.tour-tips').addClass('hidden')
            window.location.href = '/purchase/return/create?tour=going';
        });
    }

    if (URL == '/purchase/return/create?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '26.7rem').css('--left', '10rem');
        $('.tour-tips .title').text('Click here to see purchase return list');
        $("#btn-next-for-inventory").attr("id", "btn-next-purchase-return-list");
        $("#btn-next-purchase-return-list").click(function () {
            $('.tour-tips').addClass('hidden')
            window.location.href = '/purchase/return/list?tour=going';
        });
    }


    if (URL == '/purchase/return/list?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '29.5rem').css('--left', '10rem');
        $('.tour-tips .title').text('Click here to see New Purchases Payments');
        $("#btn-next-for-inventory").attr("id", "btn-next-new-purchase-payemnt");
        $("#btn-next-new-purchase-payemnt").click(function () {
            $('.tour-tips').addClass('hidden')
            window.location.href = '/payment/purchase/pay?tour=going';
        });
    }

    if (URL == '/payment/purchase/pay?tour=going') {
        $('.tour-tips').removeClass('hidden').css('--top', '8.5rem').css('--left', '17rem');
        $('.tour-tips .light_pointer').addClass('hidden');
        $('.tour-tips .content').addClass('hidden');
        $('.purchase_payment_invoice_based_card').addClass('active');
        $('.purchase_payment_supplier_based_card').addClass('active');
        $('.tooltip-content').removeClass('hidden');

        setTimeout(() => {
            $('.tour-tips').removeClass('hidden').css('--top', '9rem').css('--left', '17rem');
            $('.tour-tips .content').removeClass('hidden');
            $('.tour-tips .title').text('This is Purchase Payment for invoice based payment');
            $('.tour-tips .btn-container').addClass('hidden');
        }, 2000);

        setTimeout(() => {
            $('.tour-tips').css('--top', '9rem').css('--left', '58rem');
            $('.tour-tips .title').text('This is Purchase Payment for invoice based payment');
            $('.tour-tips .btn-container').removeClass('hidden');

        }, 5000);
        setTimeout(() => {
            $('.tour-tips').css('--top', '9rem').css('--left', '58rem');
            $('.tour-tips .title').text('This is Purchase Payment for Supplier based payment');
            $("#btn-next-for-inventory").attr("id", "btn-next-purchase-payment-list");
            $("#btn-next-purchase-payment-list").click(() => {
                $('.tour-tips').css('--top', '32rem').css('--left', '10rem');
                $('.tour-tips .dark_pointer').addClass('hidden');
                $('.tour-tips .light_pointer').removeClass('hidden');
                $('.tour-tips .title').text('Click here to see Purchases Payments List');
                $("#btn-next-purchase-payment-list").attr("id", "btn-next-purchase-payment-list-show");
                $("#btn-next-purchase-payment-list-show").click(() => {
                    $('.tour-tips').addClass('hidden');
                    window.location.href = '/purchase/payment-list?tour=going';
                });
            });
        }, 5300);
    }
    // $('.tour-tips').addClass('hidden')
    // window.location.href = '/purchase/payment-list?tour=going';




});
