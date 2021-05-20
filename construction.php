<?php
$title='FeedBack';
$content=<<<_END
<h2 style="text-align:center;"></h2>
<form>
  <div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" id="name" placeholder="Name">
  </div>
  <div class="form-group">
    <label for="phoneNumber">Phone Number</label>
    <input type="text" class="form-control" id="phoneNumber" placeholder="12345">
  </div>
  <div class="form-group">
    <label for="email">Email address</label>
    <input type="email" class="form-control" id="email" placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="adress">Address</label>
    <input type="text" class="form-control" id="address" placeholder="Address">
  </div>
  <div class="form-group">
    <label for="reason">Reason</label>
    <textarea class="form-control" id="reason" rows="3" placeholder="Why is metred connection unavailable?"></textarea>
  </div>
  <div class="form-group">
  <label for="document">House registeration document</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
  </div>
  <label for="aadhar">Aadhar Card</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile">
        <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
  </div>
  <div class="text-center mb-4">
    <button type="button" class="btn btn-primary btn-lg">Submit</button>
  </div>
  
</form>

<script>
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
_END;
require_once "templates/template1.php";
?>