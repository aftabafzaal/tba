<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Store</li>


            <!-- Optionally, you can add icons to the links -->
            <!-- Admin Links Start-->
            <?php if (Auth::user()->role->role == 'admin') { ?>
                <li>
                    <a href="{{ url('admin') }}">
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Users</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu" style="display: none;">

                        <li><a href="{{ url('admin/clients') }}"><i class="fa fa-circle-o"></i> <span>All Users</span></a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Designs</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ url('admin/products?type=simple') }}"><i class="fa fa-circle-o"></i>List Designs</a></li>
                        <li><a href="{{ url('admin/products/create?type=simple') }}"><i class="fa fa-circle-o"></i> Add New Design</a></li>

                    </ul>
                </li>
                <!--
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Products Attributes</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ url('admin/attributes') }}"><i class="fa fa-circle-o"></i> List Attributes</a></li>
                        <li><a href="{{ url('admin/attributes/create') }}"><i class="fa fa-circle-o"></i> Add Attribute</a></li>
                    </ul>
                </li>
                -->
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Content Blocks</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ url('admin/content?type=page') }}"><i class="fa fa-circle-o"></i> Pages</a></li>
                        <li><a href="{{ url('admin/content?type=email') }}"><i class="fa fa-circle-o"></i> Emails</a></li>
                        <li><a href="{{ url('admin/content?type=block') }}"><i class="fa fa-circle-o"></i> Blocks</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Orders</span> <i class="fa fa-angle-left pull-right"></i>
                    </a>
                    <ul class="treeview-menu" style="display: none;">
                        <li><a href="{{ url('admin/orders') }}"><i class="fa fa-circle-o"></i> List Orders</a></li>
                    </ul>
                </li>



            <?php } ?>
        </ul>


        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>