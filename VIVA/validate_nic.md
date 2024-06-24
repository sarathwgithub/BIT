----------------------------------------------
**Validate NIC**
----------------------------------------------
1. Create html form
   ```html
     <?php
    include '../../config.php';
    include '../header.php';
    include '../../function.php';
    ?>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        extract($_POST);
    
        $message['nic']=validateNIC($nic);
    }
    ?>
    <main id="main">
    
        <div class="container">
            <h2>NIC Validation</h2>
            <div class="form-container">
    
                <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <label for="nic">Enter NIC Number:</label>
                        <input type="text" id="nic" name="nic" placeholder="Enter NIC number..." required>
                        <span><?= @$message['nic'] ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit">Validate NIC</button>
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
function validateNIC($nic) {
    // Determine the length of the NIC
    $length = strlen($nic);

    // Check for old NIC format
    if ($length == 10) {
        $firstPart = substr($nic, 0, 9);
        $lastChar = substr($nic, -1);

        // Check if the first part is numeric and the last character is 'V' or 'X'
        if (ctype_digit($firstPart) && ($lastChar == 'V' || $lastChar == 'X')) {
            return "Valid old NIC format.";
        } else {
            return "Invalid NIC format.";
        }
    }
    // Check for new NIC format
    elseif ($length == 12) {
        // Check if all characters are numeric
        if (ctype_digit($nic)) {
            return "Valid new NIC format.";
        } else {
            return "Invalid NIC format.";
        }
    } else {
        return "Invalid NIC format.";
    }
}
