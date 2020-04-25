@extends('layouts.main')
@section('title', 'ครุภัณฑ์')
@section('menu2', 'active')
@section('content')
    <style>
        .upload_btn_section { 
            margin-top:3px;
        }
        .upload_btn_section { 
            margin-top:3px;
        }
        .btn-remove{ 
            cursor:pointer;
            margin-top: 5px;
            margin-bottom: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .input__container small{
            color: #a2a2a2;
        } 
        .input__container { 
            margin-top: 15px;
        }
        .btn-remove.show {
            display: flex !important;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    แก้ไขครุภัณฑ์
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['url' => '#','id' => 'editForm','class' => 'editForm','files' => true]) !!}
                            {{ method_field('PATCH') }}
                            <div class="row">
                                <div class="col-md">
                                    <label>รหัสครุภัณฑ์</label>
                                    <input type="text" name="inv_number" id="inv_number" class="form-control"
                                           placeholder="ยังไม่ระบุ" required value="{{$data->inv_number}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>รหัสครุภัณฑ์ในระบบ</label>
                                    <input type="text" name="erp_number" id="erp_number" class="form-control"
                                           placeholder="ยังไม่ระบุ" required value="{{$data->erp_number}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>หมายเลขเครื่อง</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                           placeholder="ยังไม่ระบุ" required value="{{$data->code}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>รายการ</label>
                                    <textarea name="description1" id="description1" class="form-control"
                                              placeholder="ยังไม่ระบุ" rows="6" required>{{$data->description1}}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>รายละเอียด</label>
                                    <textarea name="description2" id="description2" class="form-control"
                                              placeholder="ยังไม่ระบุ" rows="6" required>{{$data->description2}}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <label>ราคา</label>
                                    <input type="number" name="price" id="price" class="form-control"
                                           placeholder="ยังไม่ระบุ" required value="{{$data->price}}">
                                </div>

                                <div class="col-lg-6">
                                    <label>ปีงบ</label>
                                    <input type="text" name="year" id="year" class="form-control"
                                           placeholder="ยังไม่ระบุ" required value="{{$data->year}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>สถานที่</label>
                                    <select class="select2" name="location" id="location">
                                        @foreach(\App\LocationTable::all() as $list)
                                            @if($data->location == $list->id)
                                                <option value="{{$list->id}}" selected>{{$list->name}}</option>
                                            @else
                                                <option value="{{$list->id}}">{{$list->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>ห้อง</label>
                                    <select class="select2" name="room" id="room">
                                        @foreach(\App\RoomTable::all() as $list)
                                            @if($data->room == $list->id)
                                                <option value="{{$list->id}}" selected>{{$list->name}}</option>
                                            @else
                                                <option value="{{$list->id}}">{{$list->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md">
                                    <label>ผู้รับผิดชอบดูแล</label>
                                    <select class="select2" name="user_manage" id="user_manage">
                                        @foreach(\App\UserAppTable::all() as $list)
                                            @if($data->user_manage == $list->id)
                                                <option value="{{$list->id}}" selected>{{$list->name}}</option>
                                                @else
                                                <option value="{{$list->id}}">{{$list->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-5">
                                    <label>รูปภาพครุภัณฑ์</label>
                                    <div id="img_preview" style="margin-top: 8px">
                                        <!-- <img src="{{$data->image}}" alt="" id="preview" 
                                        onerror="this.src='../../images/default.jpg'" width="100%"> -->
                                        @if($data->image != '')
                                            <img src="{{$data->image}}" 
                                                alt="" 
                                                id="preview" 
                                                width="100%" />
                                        @else
                                            
                                            <img src="../../images/default.jpg" 
                                                alt="" 
                                                id="preview" 
                                                width="100%" />
                                        @endif
                                    </div>
                                    <!-- <form enctype="multipart/form-data" name="upload_form">
                                    @csrf -->
                                        <div class="upload_btn_section text-center">

                                        @if($data->image != '')
                                            <a class="text-danger text-center btn-remove show" id="btn_remove" onclick="removeImage()"> 
                                                ลบรูปภาพ
                                                <span class="material-icons">
                                                    delete_outline
                                                </span>
                                            </a>
                                        @else
                                            <a class="text-danger text-center btn-remove hide" id="btn_remove" onclick="removeImage()"> 
                                                ลบรูปภาพ
                                                <span class="material-icons">
                                                    delete_outline
                                                </span>
                                            </a>
                                        @endif
                                           
                                            <div class="text-left input__container">
                                                <input type="file" name="image" id="image_file_input" class="form-control"  accept="image/*" />
                                                <small>ไฟล์รูปต้องมีขนาดไม่เกิน 10MB</small>
                                            </div>
                                            <!-- <button type="submit" class="btn btn-success">Upload</button> -->
                                        </div>
                                    <!-- </form> -->
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


        /* 
            STATE
            1 = '' but change in DB to -> '';
            2 = IMG change DB to IMG;
            3 = '' but NOT change in DB;
        */
        var image_state = ''; 
        var check_has_image = $("#btn_remove").hasClass('show');
            image_state = "3";

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

            // upload image
            if( image_state !== '3' ){
                if (image_state === '1') { 
                    $.ajax({
                        url:"{{ route('imageupload.upload') }}",
                        method:"POST",
                        data: {
                            image : '' ,
                            id: {{$data->id}}
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success:function()
                        {
                            submitForm();
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

                }else { 
                    var fd = new FormData();
                    var files = $('#image_file_input')[0].files[0];
                        fd.append('image',files);
                        fd.append('id', {{$data->id}});

                    $.ajax({
                        url:"{{ route('imageupload.upload') }}",
                        method:"POST",
                        data: fd,
                        dataType:'JSON',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function()
                        {
                            submitForm();
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
            }else { 
                submitForm();
            }
        }


        function removeImage() { 
            $("#preview").attr('src', '../../images/default.jpg');
            $("#image_file_input").val('');

            $("#btn_remove").removeClass("show");
            $("#btn_remove").addClass("hide");

                image_state = '1';
        }

        // Show Preview
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string

                $("#btn_remove").removeClass("hide");
                $("#btn_remove").addClass("show");

                image_state = '2';

            }else { 

                $("#preview").attr('src', '../../images/default.jpg');
                $("#btn_remove").removeClass("show");
                $("#btn_remove").addClass("hide");
                image_state = '1';
            }
        }

        $("#image_file_input").change(function() {
            readURL(this);
        });

        function submitForm() { 
            var form = $('#editForm')[0];
            var data = new FormData(form);
                //delete image file 
                data.delete('image');
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                enctype: 'multipart/form-data',
                url: '{{url('assets/'.$data->id)}}',
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
