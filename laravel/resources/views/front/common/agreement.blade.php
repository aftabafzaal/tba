<div class="agreement col-sm-12">
    <div style="display: none;" class="agreement-errors alert alert-danger">
    </div>
    <input type="checkbox" name="agreement" id="agreement" required="required">
    I accept the <a target="_black" href="{{url('agreement')}}" >Hold Harmless Agreement </a>.
</div>
<script>
    function check_agreement_services() {
        var agreement = jQuery("#agreement").prop("checked");

        if (agreement === false) {
            $('.agreement-errors').show();
            $('.agreement-errors').text('Please accept our agreement of service.');
            $('.agreement-errors').addClass('alert alert-danger');

            return false;
        }

    }
</script>