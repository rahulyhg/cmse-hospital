<!-- Left panel : Navigation area -->
    <!-- Note: This width of the aside area can be adjusted through LESS variables -->
    <aside id="left-panel">
        <!-- User info -->
        <div class="login-info">
            <span> <!-- User image size is adjusted inside CSS, it should stay as it -->

                <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                    <img src="img/avatars/sunny.png" alt="me" class="online" />
                    <span>
                        john.doe
                    </span>
                    <i class="fa fa-angle-down"></i>
                </a>

            </span>
        </div>
        <!-- end user info -->

        <!-- NAVIGATION : This navigation is also responsive-->
        <nav>
            <ul>
                <li class="active">
                    <a href="{{ URL::to('/') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-lg fa-fw fa-barcode "></i> <span class="menu-item-parent">Items</span></a>
                    <ul>
                        <li>
                            <a href="{!! url('items') !!}">Item List</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-lg fa-fw fa-file-text-o "></i> <span class="menu-item-parent">Requests</span></a>
                    <ul>
                        <li>
                            <a href="{!! url('orders') !!}">My Item Requests</a>
                        </li>
                        <li><a href="{!! url('orders/newrequest') !!}">Request New Items</a></li>

                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-lg fa-fw fa-book "></i> <span class="menu-item-parent">Usages</span></a>
                    <ul>
                        <li>
                            <a href="{!! url('usages/newusage') !!}">Usage Entry</a>
                        </li>
                    </ul>
                </li>


            </ul>
        </nav>
        <span class="minifyme" data-action="minifyMenu">
            <i class="fa fa-arrow-circle-left hit"></i>
        </span>

    </aside>
<!-- END NAVIGATION -->