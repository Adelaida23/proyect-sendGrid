<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

 
</head>

<body>
    <section class="space-ptb">
        <div class="container ">
            <div class="container">
                <div class="row ">
                    <div class="col-md-12">
                        <form action="{!! route('email.multipleSend') !!}" method="post" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Name:</label>
                                <input name="name"  value="" autocomplete="off" class="form-control" id="inputEmail4">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Email:</label>
                                <input name="email"  value="" autocomplete="off" class="form-control" id="inputEmail4">
                            </div>

                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Message</label>
                                <textarea name="msg" id="description" class="form-control " cols="30" rows="20" >
                    {!! old('msg')??"" !!}
                    </textarea>
                            </div>

                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-warning">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

 

</body>

</html>