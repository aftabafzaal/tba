<ul class="nav nav-pills nav-stacked">
    <?php
    $role = Auth::user()->role->role;
    ?>
    
    <li class=""><a href="{{ url('profile') }}"><i class="fa fa-user"></i>Personal</a></li>
    <li class=""><a href="{{ url('address') }}"><i class="fa fa-location-arrow"></i>Address</a></li>
    <li ><a href="{{ url('myorders')}}" ><i class="fa fa-shopping-bag"></i>My Orders</a></li>
    <li><a href="{{ url('changepassword')}}" ><i class="fa fa-key"></i>Change Password</a></li>
    <li><a href="{{ url('auth/logout')}}"><i class="fa fa-sign-out"></i>Log Out</a></li>
</ul>