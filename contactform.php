<div class="container mt-5">
      <h1>Contact Us</h1>
      <div style="background: #FFD700" id="response-message"></div>
      <form id="contact-form" action="contact.php" method="post">
        <div class="col-md-12 mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="123-456-7890" required>
          <small class="form-text text-muted">Format: 123-456-7890</small>
        </div>
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="col-md-12 mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
        </div>
        <!-- <div class="col-md-6 mb-3">
          <label for="spam-check" class="form-label">Anti-Spam Check (5+6=?)</label>
          <input type="text" class="form-control" id="spam-check" name="spam-check" required>
        </div> -->
        <input type="hidden" id="spam-check" name="spam-check" value="11">
        <div class="col-md-12 mb-3">
        <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
</div>

<script>
  $(document).ready(function() {
    $("#contact-form").on("submit", function(event) {
      event.preventDefault();
      if ($("#spam-check").val().trim() !== "11") {
        $("#response-message").html("Error: Incorrect answer to anti-spam question.").fadeIn();
        return;
      }

      $.ajax({
        url: "contact.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
          $("#response-message").html(response).fadeIn();
          $("#contact-form")[0].reset();
        },
        error: function(xhr, status, error) {
          $("#response-message").html("Error: " + xhr.responseText).fadeIn();
        }
      });
    });
  });
</script>
