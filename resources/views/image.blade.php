@if($message = Session::get('success'))
    <strong>{{ $message }}</strong>
@endif
 
<form action="{{ url('image') }}" method="post" enctype="multipart/form-data">
    @csrf
    Upload Image(s): <input type="file" name="profile_image[]" multiple />
    <p><button type="submit" name="submit">Submit</button></p>
</form>