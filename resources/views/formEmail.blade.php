@extends('layouts.app')

@section('content')

<section class="">
    <div class="container ">
        <div class="container">
            <div class="row ">
                <div class="card ">
                    <div class="card-header mx-auto ">
                        SENDER TO EMAILS
                        
                    </div>

                    <div class="card-body">
                        <div class="col-md-12 mx-auto text-center ">
                            <form action="{!! route('email.multipleSend') !!}" method="post" enctype="multipart/form-data" class="row g-3">
                                @csrf

                                <div class="">
                                    <label for="inputAddress" class="form-label ">Email's to send </label>

                                    <textarea name="correos" class="form-control border border-primary" cols="30" rows="10" value= "{!! old('correos')??'' !!}">{!! old('correos')??"" !!}</textarea>
                                 
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

{{--
<!-- Row -->
<div class="row r">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header"></div>
            <div class="card-body">
                <div id="form" class="col-md-6">
                    <form action="{!! route('email.multipleSend') !!}" method="post" enctype="multipart/form-data" class="row g-3">
                        @csrf
                        <div class="text-center mx-auto">
                            <label for="inputAddress" class="form-label ">Email</label>
                            <textarea name="correos" class="form-control " cols="30" rows="10">
                                {!! old('msg')??"Type emails" !!}
                               </textarea>
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
<div class="card-footer"></div>
</div>
</div>
</div>
--}}
<!-- End Row -->
@endsection