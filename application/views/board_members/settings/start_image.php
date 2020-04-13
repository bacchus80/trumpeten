<h2>Ändra startbild</h2>
<div>Bilden bör vara minst 1600 pixlar bred och max 0.5 Mb (500 kb) stor.</div>
<form action="/styrelsen/fileupload" method="post" id="modal-form" enctype="multipart/form-data">
<label for="file-upload" class="custom-file-upload">Ladda upp ny startbild</label>
<input onchange="readURL(this);" id="file-upload" type="file" value="" name="file" class="form-control" accept="image/*">

<img id="upload-img" src="/assets/img/main.jpg" width="800" alt="" />
<br />
<br />
<input type="submit" class="btn btn-primary" value="Spara" />
</form>