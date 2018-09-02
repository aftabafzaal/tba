<div class="row0 ">
    <div class="upd__box0 col-sm-12">
        <h3>Current Meal Plan:</h3>
        @if(count($athleteMp)>0)
        <div class="table-responsive table-lmt-400">          
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Uploaded Date</th>
                        <th class="text-right">Download Link</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($athleteMp as $aMp)
                    <tr> 
                        <td>{{ $aMp->title }}</td>
                        <td>{{ $aMp->description }}</td>
                        <td><strong>{{ date('d/m/Y',strtotime($aMp->created_at)) }}</strong></td>
                        <td>
                            <a href="{{ url('uploads/users/meal-plans/'.$aMp->file) }}" download="{{$aMp->file}}" class="btn btn-primary  pul-rgt"><i class="fa fa-download" aria-hidden="true"></i> Download</a></td>
                        <?php if (isset($subscribed) && $subscribed->ambassador_id == Auth::user()->id) { ?>
                            <td><button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo url('meal-plan/delete/' . $aMp->id); ?>"><i class="fa fa-trash"></i></button></td>
                        <?php } ?>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-warning">Sorry, there is no plan added yet </div>
        @endif
    </div>
    <div class="upd__box0 col-sm-12">
        <h3>Current Workout Plan:</h3>
        @if(count($athleteWp)>0)
        <div class="table-responsive table-lmt-400">          
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Uploaded Date</th>
                        <th class="text-right">Download Link</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($athleteWp as $aWp)
                    <tr> 
                        <td>{{ $aWp->title }}</td>
                        <td>{{ $aWp->description }}</td>
                        <td><strong>{{ date('d/m/Y',strtotime($aWp->created_at)) }}</strong></td>
                        <td>
                            <a href="{{ url('uploads/users/workout-plans/'.$aWp->file) }}" download="{{$aWp->file}}" class="btn btn-primary pul-rgt"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                        </td>
                        <?php if (isset($subscribed) && $subscribed->ambassador_id == Auth::user()->id) { ?>
                            <td><button type="button" class="btn btn-danger delete" data-toggle="modal" data-target="#myModal" data-id="<?php echo url('workout-plan/delete/' . $aWp->id); ?>"><i class="fa fa-trash"></i></button></td>
                        <?php } ?>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-warning">Sorry, there is no plan added yet </div>
        @endif
    </div>
</div>
@include('front/common/delete_modal')

<div class="update-area p0 col-sm-12 mt30">
    <div class="upd__box">
        <div class="hed">
            <h2>Updates</h2> (<label>Press Ctrl + F5 to refresh</label>)
        </div>
        @if(count($results)>0)
        <?php if (isset($subscribed) && $subscribed->athlete_id == $user->id) { ?>
            @include('front.profile.subscribed_result')
        <?php } else { ?>
            @include('front.profile.result')   
        <?php } ?>
        @else
        <div class="bg-warning">Sorry, there is no updates to show</div>
        @endif


    </div>
</div>
<div class="modal fade" id="review">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title"><strong>Review</strong></h3>
            </div>
            <div class="modal-body">
                <form role="form" method="post" action="{{ url('messages') }}">
                    <div class="form-group col-sm-12">
                        <textarea name="message" rows="3" class="form-control" placeholder="Type your comment here. . . " maxlength="200" required="required"></textarea>
                    </div>
                    <div class="form-group col-sm-12">
                        <input type="hidden" name="ambassador_id" value="@if(isset($subscribed)) {{ $subscribed->ambassador_id }} @endif">
                        <input type="hidden" name="athlete_id" value="{{ $user->id }}">
                        <input type="hidden" name="result_id" value="">
                        <input type="hidden" name="type" value="review">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-lg btn-primary btn-flat pull-right">Save</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>

    //triggered when modal is about to be shown
    $('#review').on('show.bs.modal', function (e) {

        //get data-id attribute of the clicked element
        var result_id = $(e.relatedTarget).data('result-id');

        //populate the textbox
        $(e.currentTarget).find('input[name="result_id"]').val(result_id);
    });
    jQuery('.delete').click(function ()
    {
        $('#delete').attr('href', $(this).data('id'));
    });
</script>

