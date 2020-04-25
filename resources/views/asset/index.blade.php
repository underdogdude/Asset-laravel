@extends('layouts.main')
@section('title', 'ครุภัณฑ์')
@section('menu2', 'active')
@section('head')
    <style>
        .detail-dialog b{
            font-size: 20px;
            color: #ffa000 !important;
        }
        .modal-dialog{
            width: 1200px
        }
        .form_bright_custom { 
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .form_bright_custom .select2-container { 
            margin-bottom: 0;
        }
        .swal2-container {
            z-index: 999999999;
        }

        .upload__wrapper { 
            margin-top: 20px;
            border-top: 1px dashed #e5e5e5;
            padding-top: 20px;
           
        }
        .upload__wrapper .upload__section { 
            text-align: center;
            width: 50%;
            margin-left:auto; 
            margin-right:auto; 
        }
        .img_preview img { 
            max-width :100%;
            width: 100%;
        }
        .upload_btn_section {
            display: flex;
            padding: 1rem;
        }
        .upload_btn_section button {
            margin-bottom: 15px;
            margin-left: 10px;
        }

        .import__modal .modal-dialog{ 
            max-width: 720px;
            margin: 0 auto;
        }

        .import__btn { 
            border-radius: 50px;
            border-color: #39c3da;
            color: #39c3da;
            height: 50px;
        }
    </style>
    @endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between;">
                    <a href="{{url('assets/create')}}" class="btn btn-success btn-social ">
                        <div class="info">
                            <i class="icon fa fa-pencil" aria-hidden="true"></i>
                            <span class="title">เพิ่มครุภัณฑ์</span>
                        </div>
                    </a>

                    <!-- TODO -->
                    <button type="button" class="btn btn-outline-primary import__btn" data-toggle="modal" data-target="#importModal">
                    <i class="icon fa fa-plus" aria-hidden="true"></i>
                        Launch demo modal
                    </button>
                    <!--  -->
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6 form-group form_bright_custom">
                            <label for="sUser" class="col-sm-4 text-right">
                                เลือกตามผู้รับผิดชอบ: 
                            </label>
                            <div class="col-sm-8" style="padding:0;" class="">
                                <select class="select2 " name="sUser" id="sUser" onchange="filterOnchange()">
                                    <option value="all">ทั้งหมด</option>
                                        @foreach(\App\UserAppTable::all() as $list)
                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                        @endforeach
                                </select>
                            </div>
                            
                        </div>
                    </div>

                    <table class="datatable table table-striped primary" cellspacing="0" width="100%"
                           id="data-server-side">
                        <thead>
                        <tr>
                            <th></th>
                            <th>รหัสครุภัณฑ์</th>
                            <th>รหัสครุภัณฑ์ในระบบ</th>
                            <th>รายการ</th>
                            <th>ผู้รับผิดชอบดูแล</th>
                            <th>รายละเอียด</th>
                            <th width="200"></th>
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

                        <div class="col-md-12">
                            <div class="upload__wrapper">
                                 
                                <div class="upload__section">
                                    <b>
                                        รูปภาพครุภัณฑ์
                                    </b>
                                    <div id="img_preview" style="margin-top: 8px"></div>
                                </div>
                            </div>
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


    <div class="modal fade import__modal" id="importModal" tabindex="-1" role="dialog"
         aria-labelledby="importModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Import Excel File</h4>
                </div>
                <div class="modal-body">
                    <form id="uploadExcel" class="text-center"> 
                        @csrf
                        <input type="file" name="file" class="form-control" id="excel_file">
                        <br>
                        <button class="btn btn-success" onclick="importData()" id="import_button" type="button">IMPORT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
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

        var user_manage_lists = [];

        $(document).ready(function () {
            swal('กรุณารอสักครู่...');
            swal.showLoading();

            $.ajax({
                url: '{{url('api/user/server-side')}}',
                type: "GET",
            }).done(function (res) { 
                user_manage_lists = res.data;
                loadDatable('');
            });
        });
        

        function loadDatable(user) {

            var search_user = '';
            if(user === 'all') { 
                search_user = '';
            }else{ 
                search_user = user;
            }

            var dt = $('#data-server-side').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax:{
                    url:  '{{ url('api/assetSearch/server-side') }}',
                    type: "POST",
                    dataType: 'json',
                    data: { 
                        user: search_user
                    },
                    dataFilter: function(reps) {
                        swal.close();
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
                        "data": 'user_manage',
                        "render": function (data, type, row)  { 
                            var manage_filtered = user_manage_lists.filter(function(item) {
                                return  item.id === data;
                            });
                            return manage_filtered[0].name;
                        }
                    },
                    {
                        "class": "",
                        "orderable": false,
                        "data": null,
                        "defaultContent": strBtnDetail
                    },
                    {
                        "class": "text-center",
                        "orderable": false,
                        "data": null,
                        "defaultContent": strBtnAction
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
            var strBtnAction = '<span class="badge badge-danger badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>ระงับการใช้งาน</span></span>';
            if(data === '1'){
                strBtnAction = '<span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>เปิดใช้งาน</span></span>';
                return strBtnAction;
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
                                
                                if (data['image'] !== null) {

                                    document.getElementById('img_preview').innerHTML = 
                                        ` <img src="${data['image']}" name="img_uploaded" width="100%">`;
                                }else { 

                                    document.getElementById('img_preview').innerHTML = 
                                        ` <img src="./images/default.jpg" name="img_uploaded" width="100%">`;
                                }
                                $("form[name='upload_form']").attr("id", id);
                                
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

        // bright add 
        function filterOnchange() {
            var elem = $(sUser);
            var user_selected_id = $(elem).val();
            loadDatable( user_selected_id );
        }
            
        // Show import btn when file uploaded
        $('#importModal').on('show.bs.modal	', function (e) {
            
            $("#excel_file").val('');
            $("#import_button").hide();

        });
        $("#excel_file").change(function() {
            $("#import_button").show();
        });

        function importData() { 

            swal('กรุณารอสักครู่...');
            swal.showLoading();

            var form = $('#uploadExcel')[0];
            var data = new FormData(form);
            var files = $('#excel_file')[0].files[0];
           
            $.ajax({
                url:"{{ url('import_excel/import') }}",
                method:"POST",
                data: data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                timeout: 10000,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(res)
                {
                    if (res === 'success') {
                        setTimeout(function () {
                            window.location.href = "{{url('assets')}}";
                        }, 2000);
                        swal({
                            title: "บันทึกข้อมูลสำเร็จแล้ว",
                            timer: 5000,
                            type: "success",
                            showConfirmButton: false
                        });
                        
                    } else {
                        swal({
                            title: "อุ๊ปส์ เกิดข้อผิดพลาด",
                            text: data,
                            // timer: 2000,
                            type: "warning",
                            howConfirmButton: true,
                            confirmButtonText: 'ตกลง'
                        });
                    }
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

