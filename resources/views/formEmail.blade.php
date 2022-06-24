@extends('layouts.app')

@section('content')

<section class="">
    <div class="container ">
        <div class="container">
            <div class="row ">
                <div class="card " style="border-style: solid;">
                    <div class="card-header mx-auto ">
                        SENDER TO EMAILS
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 mx-auto text-center ">
                            <form action="{!! route('email.multipleSend') !!}" method="post" enctype="multipart/form-data" class="row g-3">
                                @csrf
                                <div class="col-4">
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Select one platform</option>
                                        <option value="1">Send Grid</option>
                                        <option value="2">Mail Gun</option>
                                    </select>
                                </div>
                                <div class="">
                                    <label for="inputAddress" class="form-label ">Message to send </label>
                                    <textarea name="message" id="message_id" class="form-control border border-primary" cols="30" rows="10" value="{!! old('message')??'' !!}" placeholder="Type messages to send">{!! old('correos')??"" !!}</textarea>
                                </div>
                                <div class="">
                                    <label for="inputAddress" class="form-label ">Email's to send </label>
                                    <textarea name="correos" class="form-control border border-primary" cols="30" rows="10" value="{!! old('correos')??'' !!}" placeholder="Type emails">{!! old('correos')??"" !!}</textarea>
                                </div>
                                @error('correos')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>

@endsection
@section('javascript')


<script src="{{asset('tinymce/tinymce.min.js')}}"></script>
<script>

tinymce.init({
        selector:"#message_id",
        relative_urls: false,
        force_br_newlines: false,
        force_p_newlines: false,
        forced_root_block: '',
        //extended_valid_elements : "emstart,emend,LOOP,ENDLOOP",
        //custom_elements: "emstart,emend,LOOP,ENDLOOP",
        plugins: [
            'image code',
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste",
            "mention"
        ],
        //    menubar: 'table',
        toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | image code | table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol",
        mentions: {
            delimiter: ['@', '{'],
            source: [],
            highlighter: function(text) {
                //make matched block italic
                return text.replace(new RegExp('(' + this.query + ')', 'ig'), function($1, match) {
                    return '<i>' + match + '</i>';
                });
            },
            render: function(item) {
                return '<li>' +
                    '<a href="javascript:;"><span>' + item.name + '</span></a>' +
                    '</li>';
            },
            renderDropdown: function() {
                //add twitter bootstrap dropdown-menu class
                return '<ul class="rte-autocomplete dropdown-menu"></ul>';
            },
            insert: function(item) {
                return '{' + item.name + '}';
            }
        },
        image_title: true,
        automatic_uploads: true,
        images_upload_url: '/upload',
        file_picker_types: 'image',
        // images_upload_base_path: '/some/basepath',
        images_upload_handler: function(blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/upload');

            var token = '{{ csrf_token() }}';
            xhr.setRequestHeader("X-CSRF-Token", token);
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                console.log("response is ", json)
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
    });
</script>
@endsection