<!DOCTYPE html>
<html>
<head>
<title>Google Recaptcha v3 test</title>
</head>
<body>
<div class="container mt-4">
<div class="card">
<div class="card-header text-center font-weight-bold">
<h2>Recaptcha Test</h2>
</div>
<div class="card-body">
<form name="g-v3-recaptcha-contact-us" id="g-v3-recaptcha-contact-us" method="post" action="{{url('vgr')}}">
    @csrf
    <div class="form-group">
    <label for="exampleInputEmail1">Description</label>
    <textarea name="description" class="@error('description') is-invalid @enderror form-control"></textarea>
    @error('description')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
    </div>
    <div class="form-group">
    {!! RecaptchaV3::initJs() !!}
    {!! RecaptchaV3::field('captcha') !!}
    @error('g-recaptcha-response')
    <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
    @enderror
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
</div>    
</body>
</html>