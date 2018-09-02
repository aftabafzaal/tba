<html>
    <head>
        <title><?php echo Config('params.site_name'); ?> | @yield('title')</title>
        <meta name="description" content="@yield('description')">
        <meta name="keywords" content="@yield('keywords')" />

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--iPhone from zooming form issue-->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" /> 
        <!--iPhone from zooming form issue-->
        <link rel="icon" type="image/png" href="{{asset('front/images/favicon.png')}}">
        <link href="{{asset('front/css/bootstrap.min.css')}}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('front/style.css')}}">
        <link rel="stylesheet" href="{{asset('front/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine|Inconsolata|Droid+Sans|Baloo+Tammudu|Lobster|Rancho">
        <script src="http://jquery-textfill.github.io/js/prologue/jquery.min.js"></script>
        <script src="{{ asset('front/js/modernizr.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('front/js/html2canvas.js') }}"></script>   
        <script type="text/javascript" src="http://jquery-textfill.github.io/js/textfill/jquery.textfill.js"></script> 

    </head>

    <body >
        @include('front/common/navigation')
        <main id="page-content">
            @yield('content')
        </main>
        <script type="text/javascript">


function saveCart() {
    var price = $('#total_price').val();
    var form = $('#form_add_to_cart').serialize();
    var jqxhr = $.get("../cart/add", form, function () {
        //alert( "Product added to cart."+$('#image').val() );
        window.location = "../cart/view";

    })
            .done(function () {
                //alert( "second success" );
            })
            .fail(function () {
                //alert( "error" );
            })
            .always(function () {
                //alert( "finished" );
            });

}

function makeOrderImage() {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $("#large").show();
    html2canvas($("#large"), {
        onrendered: function (canvas) {
            theCanvas = canvas;
            // document.body.appendChild(canvas);
            var photo = canvas.toDataURL('image/jpeg');
            $("#large").hide();
            $.ajax({
                method: 'POST',
                type: 'POST',
                url: '../makeorderimage',
                data: {
                    photo: photo,
                    _token: CSRF_TOKEN,
                    time: <?php echo time(); ?>
                },
                success: function (data) {
                    $('#image').val(data);

                    if (data.length >= 5)
                        saveCart();
                    else
                        alert("Please upload an image");
                }
            });
        }
    });


}


$('#draggable-zone').mouseleave(function () {

    var top = $("#front_1").css("top");
    var left = $("#front_1").css("left");


    top = parseFloat(top) * 2;
    left = parseFloat(left) * 2;
    $("#front_1_large").css("left", left).css("top", top);
});

$('#font_family').change(function () {
    textWr = $('#text_' + currentSelectedId);
    
    var style=$("#font_family").val();
    
    
    $(textWr).css('font-family', styles[style]);
    $('#front_text_large').css('font-family', styles[style]);
    // update(currentSelectedId);
    
});

$('.font-style').click(function () {
    var type = $(this).data("type");
    //$("#front_" + currentSelectedId).toggleClass($(this).val());

});

function setFontSize()
{
    alert("asdasd");
    var size = $("#size").val();
    if (!isNaN(size)) {
        $("#front_" + currentSelectedId).css("font-size", size + "px");
        size = parseFloat(size) * 2;
        $("#front_" + currentSelectedId + "_large").css("font-size", size + "px");
    }
}
        </script>
    </body>
</html>