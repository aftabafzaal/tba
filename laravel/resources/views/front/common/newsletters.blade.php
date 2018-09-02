<section class="newsletter-area text-center">
    <div class="container">

        <div class="newsletter-box">
            <div class="newsletter-box__inr">
                <div class="hed">
                    <h2>NEWSLETTER <span>SUBSCRIPTION</span></h2>
                    <p>Subscribe our Newsletter for latest updates.</p>
                </div>

                <form class="form-inline col-sm-8 pul-cntr" role="form" id="commentForm" name="commentForm">
                    <div id="error_comment"></div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="exampleInputEmail2" placeholder="Enter Your Name" required="required">
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="exampleInputPassword2" placeholder="Enter Your Email Address" required="required">


                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="button" id="subscribe" onclick="save();" class="btn btn-default">SUBSCRIBE</button>
                </form>

            </div>
        </div>

    </div>
</section>

<script type="text/javascript">
    function save() {
        var formdata = $("#commentForm").serialize();
        $('#error_comment').html("").hide();
        $.ajax({
            url: '<?php echo url('newsletter/store'); ?>',
            type: 'POST',
            dataType: 'json',
            data: formdata,
            success: function (response) {
                if (response.error === 1) {
                    var errorsHtml = '<div class="alert alert-danger alert-dismissable clrlist listview"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>Whoops!</strong> There were some problems with your input.<br> <ul>';
                    $.each(response.errors, function (key, value) {
                        errorsHtml += '<li>' + value + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></div>';
                    $('#error_comment').html(errorsHtml).show();
                } else
                {
                    $('#error_comment').html('<div class="alert alert-success alert-dismissable clrlist listview"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><p><i class="icon fa fa-check"></i> &nbsp Successfully Submitted!</p></div>').show();
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function (xhr, status, response) {
            }
        });
    }
</script>