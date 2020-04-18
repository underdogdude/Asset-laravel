@extends('layouts.main')
@section('title', 'User')
@section('menu1', 'active')
@section('head')
    <style>
        .select2-dropdown {
            z-index: 210000 !important;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-search {
            display: none;
        }

        @media (min-width: 768px) {
            .modal-dialog {
                width: 700px !important;
                margin: 30px auto;
            }
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-success btn-social " data-toggle="modal"
                            data-target="#myModalInsert">
                        <div class="info">
                            <i class="icon fa fa-pencil" aria-hidden="true"></i>
                            <span class="title">Insert User App</span>
                        </div>
                    </button>
                </div>
                <div class="card-body">
                    <table class="datatable table table-striped primary" cellspacing="0" width="100%"
                           id="data-server-side">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>ชื่อ</th>
                            <th>อีเมลล์</th>
                            <th>สถานะ</th>
                            <th></th>
                            <th width="150"></th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalInsert" tabindex="-99" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"></span></button>
                    <h4 class="modal-title">Insert User</h4>
                </div>
                {!! Form::open(['url' => '#','id' => 'FormInsert','files' => true]) !!}
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <label class="col-md-12 control-label"><h4>Name</h4></label>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="ยังไม่ระบุ" name="name" id="val_name">
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-12 control-label"><h4>Email</h4></label>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="ยังไม่ระบุ" name="email"
                                   id="val_email">
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-12 control-label"><h4>Password</h4></label>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="ยังไม่ระบุ" name="password"
                                   id="val_pass">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>สถานะการเปิดใช้งาน</label>
                            <div class="radio radio-inline">
                                <input type="radio" name="status" id="raOn" value="1" checked>
                                <label for="raOn">
                                    เปิดใช้งาน
                                </label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="status" id="raOff" value="0">
                                <label for="raOff">
                                    ระงับการใช้งาน
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="modal-footer">
                    <div class="col-md-12">
                        <div class="row">
                            <button type="button" class="btn btn-success pull-right" onclick="checkInput()">บันทึก
                            </button>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                                    id="clearFormInsert">ยกเลิก
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModalUpdate" tabindex="-99" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true"></span></button>
                    <h4 class="modal-title">Edit Main Category</h4>
                </div>
                {!! Form::open(['url' => '#','id' => 'FormEdit','files' => true]) !!}
                {{ csrf_field() }}
                {{ Form::hidden('_method', 'PUT')}}
                <div class="modal-body">
                    <div class="row">
                        <label class="col-md-12 control-label"><h4>Name</h4></label>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="ยังไม่ระบุ" name="name" id="edit_name">
                            <input type="hidden" name="id" id="edit_id">
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-md-12 control-label"><h4>Email</h4></label>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" class="form-control" placeholder="ยังไม่ระบุ" name="email"
                                   id="edit_email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="checkbox">
                                <input type="checkbox" id="checkbox1" name="reset">
                                <label for="checkbox1">
                                    รีเซ็ตรหัสผ่าน
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <label>สถานะการเปิดใช้งาน</label>
                            <div class="radio radio-inline">
                                <input type="radio" name="status" id="radioOn" value="1">
                                <label for="radioOn">
                                    เปิดใช้งาน
                                </label>
                            </div>
                            <div class="radio radio-inline">
                                <input type="radio" name="status" id="radioOff" value="0">
                                <label for="radioOff">
                                    ระงับการใช้งาน
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="modal-footer">
                    <div class="col-md-12">
                        <div class="row">
                            <button type="button" class="btn btn-success pull-right" onclick="checkInputUpdate()">
                                อัพเดท
                            </button>
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                                    id="clearFormEdit">ยกเลิก
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
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
            loadDatable();
        });

        function loadDatable() {
            var dt = $('#data-server-side').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: '{{ url('api/user/server-side') }}',
                columns: [
                    {
                        data: 'id',
                        orderable: true,
                        searchable: false,
                        visible: false
                    },
                    {data: 'name'},
                    {data: 'email'},
                    {
                        "data": 'status',
                        render: function (data) {
                            return checkStatus(data)
                        },
                        defaultContent: '<p></p>'
                    },
                    {
                        data: 'status',
                        orderable: true,
                        searchable: false,
                        visible: false
                    },
                    {
                        "class": "text-center",
                        "orderable": false,
                        "data": null,
                        "defaultContent": strBtnAction
                    }
                ],
            });

            $('#data-server-side tbody').on('click', 'tr td button.edit-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var data = row.data();
                getValue(data['id'], data['name'], data['email'], data['status']);
            });

            $('#data-server-side tbody').on('click', 'tr td button.delete-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row(tr);
                var data = row.data();
                onDelete(data['id'], data['name'])
            });
        }

        function checkStatus(data) {
            if (data === '1') {
                var str = '<span class="badge badge-success badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>เปิดใช้งาน</span></span>';
                return str;
            } else {
                var str = '<span class="badge badge-danger badge-icon"><i class="fa fa-check" aria-hidden="true"></i><span>ระงับการใช้งาน</span></span>';
                return str;
            }
        }

        function validateEmail(sEmail) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        }

        function ccin() {
            document.getElementById('val_name').value = "";
        }

        function checkInput() {
            const name = document.getElementById('val_name').value;
            const email = document.getElementById('val_email').value;
            const password = document.getElementById('val_pass').value;
            if (name && password && validateEmail(email)) {
                $('#myModalInsert').modal('toggle');
                onSave();
            } else {
                $('#myModalInsert').modal('toggle');
                swal({
                    title: "กรุณากรอกข้อมูลให้ครบถ้วน",
                    text: "",
                    // timer: 2000,
                    type: "error",
                    showConfirmButton: true,
                    confirmButtonText: 'ตกลง'
                }).then(function () {
                    $("#myModalInsert").modal()
                });
            }

        }

        function onSave() {
            swal.queue([{
                title: 'บันทึกข้อมูลหรือไม่ ?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                text:
                    'กดปุ่ม "ตกลง" เพื่อยืนยันการบันทึกข้อมูล',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        var form = $('#FormInsert')[0];
                        var data = new FormData(form);
                        $.ajax({
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            enctype: 'multipart/form-data',
                            url: '{{url('/user')}}',
                            data: data,
                            processData: false,
                            contentType: false,
                            timeout: 10000,
                            cache: false,
                            success: function (data) {
                                if (data === 'success') {
                                    setTimeout(function () {
                                        window.location.href = "{{url('user')}}";
                                        // document.getElementById('FormInsert').reset();
                                        // loadDatable();
                                    }, 1000);
                                    swal({
                                        title: "บันทึกข้อมูลสำเร็จแล้ว",
                                        timer: 1000,
                                        type: "success",
                                        showConfirmButton: false,
                                        preConfirm: function () {
                                            $("#myModalInsert").modal();
                                        }
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
                                    $("#myModalInsert").modal();
                                }
                            },
                            error: function (data) {
                                swal({
                                    title: "อุ๊ปส์ เกิดข้อผิดพลาด",
                                    text: "เกิดข้อผิดพลาดบางอย่าง กรุณาลองใหม่อีกครั้ง.",
                                    // timer: 2000,
                                    type: "warning",
                                    howConfirmButton: true,
                                    confirmButtonText: 'ตกลง'
                                });
                            }
                        });
                    })
                }
            }]).then(function () {
                $("#myModalInsert").modal()
            });
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
                            url: "{{url('/user')}}/" + id,
                            data: {
                                "_method": 'DELETE'
                            },
                            timeout: 10000,
                            cache: false,
                            success: function (data) {
                                if (data === 'success') {
                                    setTimeout(function () {
                                        {{--window.location.href = "{{url('admin/user')}}";--}}
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

        function getValue(id, name, email, status) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;

            if (status === '1') {
                document.getElementById('radioOn').checked = true;
            } else {
                document.getElementById('radioOff').checked = true;
            }

            $("#myModalUpdate").modal()
        }

        function checkInputUpdate() {
            var id = document.getElementById('edit_id').value;
            var email = document.getElementById('edit_name').value;
            var name = document.getElementById('edit_email').value;
            if (name && email) {
                $('#myModalUpdate').modal('toggle');
                onUpdate(id);
            } else {
                $('#myModalUpdate').modal('toggle');
                swal({
                    title: "กรุณากรอกข้อมูลให้ครบถ้วน",
                    text: "",
                    // timer: 2000,
                    type: "warning",
                    showConfirmButton: true,
                    confirmButtonText: 'ตกลง'
                }).then(function () {
                    $("#myModalUpdate").modal()
                });
            }
        }

        function onUpdate(id) {
            swal.queue([{
                title: 'อัพเดทข้อมูลหรือไม่ ?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                text:
                    'กดปุ่ม "ตกลง" เพื่อยืนยันการอัพเดทข้อมูล',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        var form = $('#FormEdit')[0];
                        var data = new FormData(form);
                        $.ajax({
                            type: 'POST',
                            enctype: 'multipart/form-data',
                            url: '{{url('user')}}/' + id,
                            data: data,
                            processData: false,
                            contentType: false,
                            timeout: 10000,
                            cache: false,
                            success: function (data) {
                                if (data === 'success') {
                                    setTimeout(function () {
                                        {{--window.location.href = "{{url('admin/user')}}";--}}
                                        loadDatable();
                                    }, 1000);
                                    swal({
                                        title: "อัพเดทข้อมูลสำเร็จแล้ว",
                                        timer: 1000,
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
                                        confirmButtonText: 'ตกลง',
                                        preConfirm: function () {
                                            $("#myModalUpdate").modal();
                                        }
                                    });
                                }
                            },
                            error: function (data) {
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
                    })
                }
            }]).then(function () {
                $('#myModalUpdate').modal()
            });
        }
    </script>
@endsection

