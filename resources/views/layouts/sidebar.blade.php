<aside class="app-sidebar" id="sidebar">
    <div class="sidebar-header">
        <a class="sidebar-brand" href="#"><span class="highlight">{{ ucfirst(config('multiauth.prefix')) }} Dashboard</span></a>
        <button type="button" class="sidebar-toggle">
            <i class="fa fa-times"></i>
        </button>
    </div>
    <div class="sidebar-menu">
        <ul class="sidebar-nav">
            <li class="@yield('menu1')">
                <a href="{{url('user')}}">
                    <div class="icon">
                        <i class="fa fa-user" aria-hidden="true"></i>
                    </div>
                    <div class="title" style="text-transform: none">ผู้ใช้</div>
                </a>
            </li>

            <li class="@yield('menu2')">
                <a href="{{url('assets')}}">
                    <div class="icon">
                        <i class="fa fa-cubes" aria-hidden="true"></i>
                    </div>
                    <div class="title">ครุภัณฑ์</div>
                </a>
            </li>

            <li class="dropdown @yield('menu3')">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <div class="icon">
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                    </div>
                    <div class="title" style="text-transform: none">รายงาน</div>
                </a>
                <div class="dropdown-menu">
                    <ul>
                        <li class="section"><i class="fa fa-file-excel-o" aria-hidden="true"></i>Report</li>
                        <li><a href="{{url('asset-check')}}">รายงานตรวจครุภัณฑ์</a></li>
                        <li><a href="#">Report2</a></li>
                        <li><a href="#">Report3</a></li>
                        <li><a href="#">Report4</a></li>
                        <li><a href="#">Report5</a></li>
                        <li><a href="#">Report6</a></li>
                    </ul>
                </div>
            </li>

{{--            <li class="dropdown @yield('menu3')">--}}
{{--                <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
{{--                    <div class="icon">--}}
{{--                        <i class="fa fa-star" aria-hidden="true"></i>--}}
{{--                    </div>--}}
{{--                    <div class="title" style="text-transform: none">Class Recommend</div>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu">--}}
{{--                    <ul>--}}
{{--                        <li class="section"><i class="fa fa-star" aria-hidden="true"></i>Class Recommend</li>--}}
{{--                        <li><a href="{{url('admin/class-recommend/3')}}">หรูหรา</a></li>--}}
{{--                        <li><a href="{{url('admin/class-recommend/2')}}">ปานกลาง</a></li>--}}
{{--                        <li><a href="{{url('admin/class-recommend/1')}}">ประหยัด</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}

{{--            <li class="dropdown @yield('menu4')">--}}
{{--                <a href="#" class="dropdown-toggle" data-toggle="dropdown">--}}
{{--                    <div class="icon">--}}
{{--                        <i class="fa fa-map-marker" aria-hidden="true"></i>--}}
{{--                    </div>--}}
{{--                    <div class="title" style="text-transform: none">Place</div>--}}
{{--                </a>--}}
{{--                <div class="dropdown-menu">--}}
{{--                    <ul>--}}
{{--                        <li class="section"><i class="fa fa-star" aria-hidden="true"></i>Place</li>--}}
{{--                        <li><a href="{{url('admin/place')}}">รายชื่อสถานที่</a></li>--}}
{{--                        <li><a href="{{url('admin/place/create')}}">เพิ่มสถานที่</a></li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </li>--}}
        </ul>
    </div>
    <div class="sidebar-footer">
        <ul class="menu">
            <li>
                <a href="/" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
    </div>
</aside>
