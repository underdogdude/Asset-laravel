@extends('layouts.main')
@section('title', 'รายงานตรวจครุภัณฑ์')
@section('menu3', 'active')
@section('head')
    <style>
        .detail-dialog b{
            font-size: 20px;
            color: #ffa000 !important;
        }
        .modal-dialog{
            width: 1200px
        }
        .btn-export { 
            display:flex;
            align-items:center;
            border-color: #1d6f42;
            color: #1d6f42;
            margin-bottom: 20px;
        }
    </style>
    @endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <form id="formSearch">
                    <div class="row">
                        <br>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <label>วันที่ค้นหา</label>
                                <input id="date-start" name="date_start" class="form-control" placeholder="กรุณาเลือกวันที่" style="height: 49px" required>
                            </div>
                            <div class="col-md-6">
                                <label>ถึงวันที่</label>
                                <input id="date-end" name="date_end" class="form-control" placeholder="กรุณาเลือกวันที่" style="height: 49px" required>
                            </div>
                            <div class="col-md-6">
                                <label>อาคาร</label>
                                <br>
                                <select class="select2" name="sLocation" id="sLocation">
                                    <option value="all">ทั้งหมด</option>
                                    @foreach(\App\LocationTable::orderBy('id','desc')->get() as $list)
                                        <option value="{{$list->id}}">{{$list->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>ห้อง</label>
                                <select class="select2" name="sRoom" id="sRoom">
                                    <option value="all">ทั้งหมด</option>
                                    @foreach(\App\RoomTable::orderBy('name','asc')->get() as $list)
                                        <option value="{{$list->id}}">{{$list->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>ผู้รับผิดชอบดูแล</label>
                                <br>
                                <select class="select2" name="sUser" id="sUser">
                                    <option value="all">ทั้งหมด</option>
                                    @foreach(\App\UserAppTable::all() as $list)
                                        <option value="{{$list->id}}">{{$list->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-header">
                    <div class="btn btn-success btn-social col-lg-2" onclick="searchData()">
                        <div class="info">
                            <i class="icon fa fa-search" aria-hidden="true"></i>
                            <span class="title">ค้นหา</span>
                        </div>
                    </div>
                    <a href="{{url('asset-check')}}" class="btn btn-info btn-social col-lg-2" style="margin-left: 20px">
                        <div class="info">
                            <i class="icon fa fa-refresh" aria-hidden="true"></i>
                            <span class="title">รีเฟรช</span>
                        </div>
                    </a>
                </div>
                <div class="card-body">
                    <div style="display: flex;justify-content: flex-end;">
                        <button class="btn btn-export" onclick="getAllData()">
                            Export Excel 
                            <span class="material-icons">
                                publish
                            </span>
                        </button>
                    </div>
                    <table class="datatable table table-striped primary" cellspacing="0" width="100%"
                           id="data-server-side">
                        <thead>
                        <tr>
                            <th></th>
                            <th>รหัสครุภัณฑ์</th>
                            <th>รหัสครุภัณฑ์ในระบบ</th>
                            <th>รายการ</th>
                            <th>สถานะ</th>
                            <th>รายละเอียด</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalShow" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="asset_name"></h4>
                </div>
                <div class="modal-body text-left">
                    <div class="row detail-dialog">
                        <div class="col-md-6">
                            <b>รหัสครุภัณฑ์</b>
                            <p id="inv_number"></p>
                            <b>รหัสครุภัณฑ์ในระบบ</b>
                            <p id="erp_number"></p>
                            <b>รายการ</b>
                            <p id="description1"></p>
                            <b>รายละเอียด</b>
                            <p id="description2"></p>
                            <b>หมายเลขเครื่อง</b>
                            <p id="code"></p>
                        </div>
                        <div class="col-md-6">
                            <b>ราคา</b>
                            <p id="price"></p>
                            <b>สถานที่</b>
                            <p id="location"></p>
                            <b>ห้อง</b>
                            <p id="room"></p>
                            <b>ปีงบ</b>
                            <p id="year"></p>
                            <b>ผู้รับผิดชอบดูแล</b>
                            <p id="user_manage"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-default"
                            data-dismiss="modal">ปิด
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>

        var golbal_dataFromLoadSearch = "";
        var golbal_date_start = "";
        var golbal_date_end = "";

        $('#date-start').bootstrapMaterialDatePicker({
            weekStart : 0,
            time: false ,
            format : 'YYYY-MM-DD',
            minDate :'2020-01-01',
            lang : 'th',
            currentDate: '2020-01-01'
        });

        $('#date-end').bootstrapMaterialDatePicker({
            weekStart : 0,
            time: false ,
            format : 'YYYY-MM-DD',
            minDate :'2020-01-01',
            lang : 'th',
            currentDate: new Date()
        });

        var strBtnDetail = "<button type='button' class='btn btn-info btn-sm details-control'>" +
            "<div class='info'>" +
            "<i class='icon fa fa-eye' aria-hidden='true'></i>" +
            "<span class='title'> รายละเอียด</span>" +
            "</div>" +
            "</button>";

        var strBtnAction =
            "<button class='btn btn-warning btn-sm edit-control' style='margin-right: 20px;'>" +
            "<i class='icon fa fa-edit' aria-hidden='true'></i>" +
            // "<span class='title'>แก้ไข</span>" +
            "</button>" +
            "<button class='btn btn-danger btn-sm delete-control'>" +
            "<i class='icon fa fa-trash' aria-hidden='true'></i>" +
            // "<span class='title'>ลบ</span>" +
            "</button>";

        $(document).ready(function () {
            searchData();
        });

        function   loadDatable(date_start,date_end,location,room,user){

            var dt = $('#data-server-side').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax:{
                    url:  '{{ url('api/asset-count/server-side') }}',
                    type: "POST",
                    dataType: 'json',
                    data:{
                        date_start:date_start,
                        date_end:date_end,
                        location:location,
                        room:room,
                        user:user,
                    },
                    dataFilter: function(reps) {

                        swal.close();
                        var data = JSON.parse(reps)

                        golbal_dataFromLoadSearch = data.data;
                        golbal_date_start = date_start;
                        golbal_date_end = date_end;

                        return reps;
                    },
                    error:function(err){
                        swal({
                            title: "อุ๊ปส์ เกิดข้อผิดพลาด",
                            text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง.",
                            timer: 2000,
                            type: "error",
                            showConfirmButton: false
                        });
                        console.log(err);
                    }

                },
                columns: [
                    {
                        data: 'id',
                        orderable: true,
                        searchable: false,
                        visible: false
                    },
                    {data: 'inv_number'},
                    {data: 'erp_number'},
                    {data: 'description1'},
                    {
                        "data": 'status',
                        render: function (data) {
                            return checkStatus(data)
                        },
                        defaultContent: '<p></p>'
                    },
                    {
                        "class": "",
                        "orderable": false,
                        "data": null,
                        "defaultContent": strBtnDetail
                    }
                ],
            });

            $('#data-server-side tbody').on('click', 'tr td button.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var data = row.data();

                onGetSelect(data['id']);
            });

            $('#data-server-side tbody').on('click', 'tr td button.edit-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var data = row.data();
                window.location.href = "{{url('assets')}}/"+data['id']+"/edit";
            });

            $('#data-server-side tbody').on('click', 'tr td button.delete-control', function () {
                return;
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var data = row.data();
                onDelete(data['id'], data['description1'])
            });
        }

        function searchData() {
            swal('กรุณารอสักครู่...');
            swal.showLoading();
            var date_start = $('#date-start').val();
            var date_end = $('#date-end').val();
            var location = $('#sLocation').val();
            var room = $('#sRoom').val();
            var user = $('#sUser').val();
            console.log(date_start);
            console.log(date_end);
            console.log(location);
            console.log(room);
            console.log(user);

            loadDatable(date_start,date_end,location,room,user);
        }

        function searchAssetCount() {


            var dt = $('#data-server-side').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: '{{ url('api/asset-count/server-side') }}',
                columns: [
                    {
                        data: 'id',
                        orderable: true,
                        searchable: false,
                        visible: false
                    },
                    {data: 'inv_number'},
                    {data: 'erp_number'},
                    {data: 'description1'},
                    {
                        "data": 'status',
                        render: function (data) {
                            return checkStatus(data)
                        },
                        defaultContent: '<p></p>'
                    },
                    {
                        "class": "",
                        "orderable": false,
                        "data": null,
                        "defaultContent": strBtnDetail
                    }
                ],
            });

            $('#data-server-side tbody').on('click', 'tr td button.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var data = row.data();

                onGetSelect(data['id']);
            });

            $('#data-server-side tbody').on('click', 'tr td button.edit-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var data = row.data();
                window.location.href = "{{url('assets')}}/"+data['id']+"/edit";
            });

            $('#data-server-side tbody').on('click', 'tr td button.delete-control', function () {
                return;
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var data = row.data();
                onDelete(data['id'], data['description1'])
            });
        }

        function checkStatus(data) {
            var strBtnAction = '<span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>ใช้งานอยู่</span></span>';
            if (data === '2') {
                strBtnAction = '<span class="badge badge-warning badge-icon"><i class="fa fa-warning" aria-hidden="true"></i><span>ชำรุด/เสื่อมสภาพ</span></span>';
            } else if (data === '3'){
                strBtnAction = '<span class="badge badge-pill badge-icon"><i class="fa fa-exclamation-circle" aria-hidden="true"></i><span>ไม่จำเป็นใช้งาน</span></span>';
            }else if (data === '4'){
                strBtnAction = '<span class="badge badge-danger badge-icon"><i class="fa fa-close" aria-hidden="true"></i><span>หาไม่พบ</span></span>';
            }
            return strBtnAction;
        }

        function onGetSelect(id) {
            if (id) {
                swal('กรุณารอสักครู่...');
                swal.showLoading();
                $.ajax({
                    type: "GET",
                    url: '{{url('assets')}}/'+id,
                    cache: false,
                    timeout: 30000,
                    success: function (data) {
                        console.log(data);
                        if (data.length === 0) {
                            swal({
                                title: "ไม่พบรายการที่ค้นหา ",
                                text: "",
                                type: "warning",
                                showConfirmButton: true,
                                confirmButtonText: 'ตกลง',
                            });
                        } else {
                                document.getElementById('inv_number').innerHTML =  data['inv_number'];
                                document.getElementById('erp_number').innerHTML =  data['erp_number'];
                                document.getElementById('asset_name').innerHTML =  data['description1'];
                                document.getElementById('description1').innerHTML =  data['description1'];
                                document.getElementById('description2').innerHTML =  data['description2'];
                                document.getElementById('code').innerHTML =  data['code'];
                                document.getElementById('price').innerHTML =  data['price'];
                                document.getElementById('location').innerHTML =  data['location'];
                                document.getElementById('room').innerHTML =  data['room'];
                                document.getElementById('year').innerHTML =  data['year'];
                                document.getElementById('user_manage').innerHTML =  data['user_manage_name'];
                            swal.close();
                            $("#myModalShow").modal();
                        }

                    },
                    error: function (data) {
                        swal({
                            title: "อุ๊ปส์ เกิดข้อผิดพลาด",
                            text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง.",
                            type: "error",
                            showConfirmButton: true,
                            confirmButtonText: 'ตกลง',
                        });
                    }
                });
            }
        }

        function onDelete(id, name) {
            swal.queue([{
                title: 'ยืนยันการลบ ' + name + ' ?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                text:
                    'กดปุ่ม "ตกลง" เพื่อยืนยันการทำรายการ',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "POST",
                            url: "{{url('assets')}}/" + id,
                            data: {
                                "_method": 'DELETE'
                            },
                            timeout: 10000,
                            cache: false,
                            success: function (data) {
                                console.log(data);
                                if (data === 'success') {
                                    setTimeout(function () {
                                        loadDatable();
                                    }, 1000);
                                    swal({
                                        title: "ทำรายการสำเร็จแล้ว",
                                        timer: 1000,
                                        type: "success",
                                        showConfirmButton: false
                                    });
                                } else if (data === 'NoDelete') {
                                    swal({
                                        title: "อุ๊ปส์ เกิดข้อผิดพลาด",
                                        text: "ไม่สามารถลบได้ เนื่องจากกำลังถูกใช้งาน.",
                                        timer: 2000,
                                        type: "warning",
                                        showConfirmButton: false
                                    });
                                }
                            },
                            error: function (data) {
                                swal({
                                    title: "อุ๊ปส์ เกิดข้อผิดพลาด",
                                    text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง.",
                                    timer: 2000,
                                    type: "error",
                                    showConfirmButton: false
                                });
                            }
                        });
                    })
                }
            }]);
        }


       

        function getAllData(dataFromLoadSearch, date_start, date_end) { 
            $.ajax({
                url:"{{ url('export_excel/export') }}",
                type: "POST",
                data:{
                    data: golbal_dataFromLoadSearch,
                    date_start: golbal_date_start,
                    date_end: golbal_date_end
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                // This line help to remove can't read response
                xhrFields: {
                    responseType: 'blob',
                },
                success:function(result, status, xhr) {

                    console.log(result);
                    console.log(status);
                    console.log(xhr);

                    // IF YOU WANT TO HAVE FILE NAME >>
                    // var disposition = xhr.getResponseHeader('content-disposition');
                    // var matches = /"([^"]*)"/.exec(disposition);
                    // var filename = (matches != null && matches[1] ? matches[1] : 'salary.xlsx');
                    // // The actual download
                    // var blob = new Blob([result], {
                    //     type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    // });

                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(result);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function () {
                    swal({
                        title: "อุ๊ปส์ เกิดข้อผิดพลาด",
                        text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง.",
                        timer: 2000,
                        type: "error",
                        showConfirmButton: true,
                        confirmButtonText: 'ตกลง',
                    });
                }
            });
        }
    </script>
@endsection

