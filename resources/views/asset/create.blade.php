@extends('layouts.main')
@section('title', 'ครุภัณฑ์')
@section('menu2', 'active')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    เพิ่มครุภัณฑ์
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => '#','id' => 'insertForm','class' => 'insertForm','files' => true]) !!}
                            {{ method_field('POST') }}
                            <div class="row">
                                <div class="col-md">
                                    <label>รหัสครุภัณฑ์</label>
                                    <input type="text" name="inv_number" id="inv_number" class="form-control"
                                           placeholder="ยังไม่ระบุ" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>รหัสครุภัณฑ์ในระบบ</label>
                                    <input type="text" name="erp_number" id="erp_number" class="form-control"
                                           placeholder="ยังไม่ระบุ" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>หมายเลขเครื่อง</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                           placeholder="ยังไม่ระบุ" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>รายการ</label>
                                    <textarea name="description1" id="description1" class="form-control"
                                              placeholder="ยังไม่ระบุ" rows="6" required></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>รายละเอียด</label>
                                    <textarea name="description2" id="description2" class="form-control"
                                              placeholder="ยังไม่ระบุ" rows="6" required></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>ราคา</label>
                                    <input type="number" name="price" id="price" class="form-control"
                                           placeholder="ยังไม่ระบุ" required>
                                </div>

                                <div class="col-md-6">
                                    <label>ปีงบ</label>
                                    <input type="text" name="year" id="year" class="form-control"
                                           placeholder="ยังไม่ระบุ" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>สถานที่</label>
                                    <select class="select2" name="location" id="location">
                                        @foreach(\App\LocationTable::all() as $list)
                                            <option value="{{$list->id}}">{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>ห้อง</label>
                                    <select class="select2" name="room" id="room">
                                        @foreach(\App\RoomTable::all() as $list)
                                            <option value="{{$list->id}}">{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>ผู้รับผิดชอบดูแล</label>
                                    <select class="select2" name="user_manage" id="user_manage">
                                        @foreach(\App\UserAppTable::all() as $list)
                                            <option value="{{$list->id}}">{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <div class="row">
                                <a href="{{url('assets')}}" class="btn btn-default">ย้อนกลับ</a>
                                <button type="button" class="btn btn-success pull-right" onclick="checkForm()">ยืนยัน
                                </button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>

        function checkForm() {
            var inv_number = document.getElementById('inv_number').value;
            var erp_number = document.getElementById('erp_number').value;
            var description1 = document.getElementById('description1').value;
            var description2 = document.getElementById('description2').value;
            var code = document.getElementById('code').value;
            var price = document.getElementById('price').value;
            var location = document.getElementById('location').value;
            var room = $("#room").val();
            var year = $("#year").val();
            var user_manage = $("#user_manage").val();

            if (
                inv_number &&
                erp_number &&
                description1 &&
                description2 &&
                code &&
                price &&
                location &&
                room &&
                year &&
                user_manage
            ) {
                confirm();
            } else {
                swal({
                    title: "กรุณากรอกข้อมูลให้ครบถ้วน",
                    text: "",
                    type: "error",
                    showConfirmButton: true,
                    confirmButtonText: 'ตกลง',
                });
            }
        }

        function confirm() {

            swal.queue([{
                title: 'บันทึกข้อมูลหรือไม่ ?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                text: 'กดปุ่ม "ตกลง" เพื่อยืนยันการบันทึกข้อมูล',
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        saveForm();
                    })
                }
            }]);
        }

        function saveForm() {
            var form = $('#insertForm')[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                enctype: 'multipart/form-data',
                url: '{{url('assets')}}',
                data: data,
                processData: false,
                contentType: false,
                timeout: 10000,
                cache: false,
                success: function (data) {
                    if (data === 'success') {
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
                error: function (data) {
                    console.log(data);
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
