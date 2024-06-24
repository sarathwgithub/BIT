--------------------------------------------------
**Validate Tel Number**
--------------------------------------------------
1. Create html form below
    ```html
      <?php
      include '../../config.php';
      include '../header.php';
      include '../../function.php';
      ?>
      <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          extract($_POST);
      
          $message['tel']=validateMobileNumber($tel);
      }
      ?>
      <main id="main">
      
          <div class="container">
              <h2>NIC Validation</h2>
              <div class="form-container">
      
                  <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                      <div class="form-group">
                          <label for="tel">Enter Tel Number:</label>
                          <input type="text" id="tel" name="tel" placeholder="Enter TEL number..." required>
                          <span><?= @$message['tel'] ?></span>
                      </div>
                      <div class="form-group">
                          <button type="submit">Validate Tel</button>
                      </div>
                  </form>
      
              </div>
          </div>
      </main>
      <?php
      include '../footer.php';
      ?>

2. Create below function in the function file
    ```php
    function validateMobileNumber($mobile) {
        // Remove leading and trailing whitespace
        $mobile = trim($mobile);
    
        // Check if the number starts with +94 followed by 9 digits
        if (substr($mobile, 0, 3) === '+94' && strlen($mobile) === 12 && ctype_digit(substr($mobile, 3))) {
            return "Valid mobile number.";
        } else {
            return "Invalid mobile number.";
        }
    }
