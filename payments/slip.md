-----------------------------------------------------------------------
**create a payment slip with a logo and issue a receipt to a customer**
-----------------------------------------------------------------------
To create a payment slip with a logo and issue a receipt to a customer using PHP and FPDF, you can follow these steps
Step 1: Install TCPDF
  Download TCPDF from tcpdf.org and include it in your project directory(https://github.com/tecnickcom/tcpdf)

Step 2: Create the Table
  ```sql
      CREATE TABLE payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date DATE NOT NULL,
        customer_name VARCHAR(255) NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        payment_method VARCHAR(50) NOT NULL
    );
  ```
Step 3: Insert Sample Data
  ```sql
      INSERT INTO payments (date, customer_name, amount, payment_method) VALUES
      ('2024-07-01', 'John Doe', 100.00, 'Credit Card'),
      ('2024-07-02', 'Jane Smith', 150.50, 'PayPal'),
      ('2024-07-03', 'Alice Johnson', 200.75, 'Bank Transfer'),
      ('2024-07-04', 'Bob Brown', 250.00, 'Credit Card'),
      ('2024-07-05', 'Charlie Davis', 300.00, 'Cash');
  ```
Step 3:Create a PHP script to generate the payment slip(payments\slip.php)
  ```php
      <?php
      // Include the TCPDF library
      require_once('../../TCPDF/tcpdf.php');
      
      // Extend the TCPDF class to create custom Header and Footer
      class MYPDF extends TCPDF {
          // Page header
          public function Header() {
              // Logo
              $image_file = 'logo.png'; // Path to the logo file
              $this->Image($image_file, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
              // Set font
              $this->SetFont('helvetica', 'B', 20);
              // Title
              $this->Cell(0, 15, 'Payment Receipt', 0, false, 'C', 0, '', 0, false, 'M', 'M');
          }
      
          // Page footer
          public function Footer() {
              // Position at 15 mm from bottom
              $this->SetY(-15);
              // Set font
              $this->SetFont('helvetica', 'I', 8);
              // Page number
              $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
          }
      }
      
      // Include database connection
      include_once '../init.php';
      $db = dbConn();
      
      // Query to fetch payment data from the table
      $payment_id = 1; // Replace with dynamic ID if needed
      $sql = "SELECT * FROM payments WHERE id = $payment_id";
      $result = $db->query($sql);
      
      // Fetch the payment data
      $payment = $result->fetch_assoc();
      
      // Create new PDF document
      $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      
      // Set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Your Company Name');
      $pdf->SetTitle('Payment Receipt');
      $pdf->SetSubject('Receipt');
      
      // Set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      
      // Set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      
      // Set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      
      // Set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      
      // Set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      
      // Add a page
      $pdf->AddPage();
      
      // Set font
      $pdf->SetFont('helvetica', '', 12);
      
      // Title
      $pdf->Cell(0, 10, 'Payment Receipt', 0, 1, 'C');
      $pdf->Ln(10); // Line break
      
      // Add payment details
      $pdf->SetFont('helvetica', '', 12);
      $pdf->Cell(50, 10, 'Receipt No:', 0, 0);
      $pdf->Cell(0, 10, $payment['id'], 0, 1);
      
      $pdf->Cell(50, 10, 'Date:', 0, 0);
      $pdf->Cell(0, 10, $payment['date'], 0, 1);
      
      $pdf->Cell(50, 10, 'Customer Name:', 0, 0);
      $pdf->Cell(0, 10, $payment['customer_name'], 0, 1);
      
      $pdf->Cell(50, 10, 'Amount:', 0, 0);
      $pdf->Cell(0, 10, 'Rs.' . number_format($payment['amount'], 2), 0, 1);
      
      $pdf->Cell(50, 10, 'Payment Method:', 0, 0);
      $pdf->Cell(0, 10, $payment['payment_method'], 0, 1);
      
      $pdf->Ln(20); // Line break
      
      // Add thank you note
      $pdf->Cell(0, 10, 'Thank you for your payment!', 0, 1, 'C');
      
      // Output the PDF
      $pdf->Output('payment_receipt.pdf', 'D');
      ?>

  ```
Custom Page Sizes
  ```php
      <?php
      // Include the TCPDF library
      require_once('../../TCPDF/tcpdf.php');
      
      // Extend the TCPDF class to create custom Header and Footer
      class MYPDF extends TCPDF {
          // Page header
          public function Header() {
              // Logo
              $image_file = 'logo.png'; // Path to the logo file
              $this->Image($image_file, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
              // Set font
              $this->SetFont('helvetica', 'B', 20);
              // Title
              $this->Cell(0, 15, 'Payment Receipt', 0, false, 'C', 0, '', 0, false, 'M', 'M');
          }
      
          // Page footer
          public function Footer() {
              // Position at 15 mm from bottom
              $this->SetY(-15);
              // Set font
              $this->SetFont('helvetica', 'I', 8);
              // Page number
              $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
          }
      }
      
      // Include database connection
      include_once '../init.php';
      $db = dbConn();
      
      // Query to fetch payment data from the table
      $payment_id = 1; // Replace with dynamic ID if needed
      $sql = "SELECT * FROM payments WHERE id = $payment_id";
      $result = $db->query($sql);
      
      // Fetch the payment data
      $payment = $result->fetch_assoc();
      
      // Set custom page size (e.g., 150mm x 100mm)
      $custom_layout = array(170, 100); // width, height
      
      // Create new PDF document with custom page size
      $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
      
      // Set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Your Company Name');
      $pdf->SetTitle('Payment Receipt');
      $pdf->SetSubject('Receipt');
      
      // Set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      
      // Set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      
      // Set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      
      // Set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      
      // Set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      
      // Add a page
      $pdf->AddPage();
      
      // Set font
      $pdf->SetFont('helvetica', '', 12);
      
      // Title
      $pdf->Cell(0, 10, 'Payment Receipt', 0, 1, 'C');
      $pdf->Ln(10); // Line break
      
      // Add payment details
      $pdf->SetFont('helvetica', '', 12);
      $pdf->Cell(50, 10, 'Receipt No:', 0, 0);
      $pdf->Cell(0, 10, $payment['id'], 0, 1);
      
      $pdf->Cell(50, 10, 'Date:', 0, 0);
      $pdf->Cell(0, 10, $payment['date'], 0, 1);
      
      $pdf->Cell(50, 10, 'Customer Name:', 0, 0);
      $pdf->Cell(0, 10, $payment['customer_name'], 0, 1);
      
      $pdf->Cell(50, 10, 'Amount:', 0, 0);
      $pdf->Cell(0, 10, 'Rs.' . number_format($payment['amount'], 2), 0, 1);
      
      $pdf->Cell(50, 10, 'Payment Method:', 0, 0);
      $pdf->Cell(0, 10, $payment['payment_method'], 0, 1);
      
      $pdf->Ln(20); // Line break
      
      // Add thank you note
      $pdf->Cell(0, 10, 'Thank you for your payment!', 0, 1, 'C');
      
      // Output the PDF
      $pdf->Output('payment_receipt.pdf', 'D');
      ?>

  ```
To display the PDF directly in the browser instead of forcing a download, you need to change the output destination parameter in the Output method from 'D' (download) to 'I' (inline display).

PHP Script to Save PDF on Server
  ```php
      <?php
      // Include the TCPDF library
      require_once('../../TCPDF/tcpdf.php');
      
      // Extend the TCPDF class to create custom Header and Footer
      class MYPDF extends TCPDF {
          // Page header
          public function Header() {
              // Logo
              $image_file = 'logo.png'; // Path to the logo file
              $this->Image($image_file, 10, 10, 30, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
              // Set font
              $this->SetFont('helvetica', 'B', 20);
              // Title
              $this->Cell(0, 15, 'Payment Receipt', 0, false, 'C', 0, '', 0, false, 'M', 'M');
          }
      
          // Page footer
          public function Footer() {
              // Position at 15 mm from bottom
              $this->SetY(-15);
              // Set font
              $this->SetFont('helvetica', 'I', 8);
              // Page number
              $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
          }
      }
      
      // Include database connection
      include_once '../init.php';
      $db = dbConn();
      
      // Query to fetch payment data from the table
      $payment_id = 1; // Replace with dynamic ID if needed
      $sql = "SELECT * FROM payments WHERE id = $payment_id";
      $result = $db->query($sql);
      
      // Fetch the payment data
      $payment = $result->fetch_assoc();
      
      // Set absolute path to save the PDF file
      $save_path = __DIR__ . '/../../docs/payment_receipt.pdf'; // Replace with your desired absolute server path
      
      // Set custom page size (e.g., 150mm x 100mm)
      $custom_layout = array(150, 100); // width, height
      
      // Create new PDF document with custom page size
      $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, $custom_layout, true, 'UTF-8', false);
      
      // Set document information
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetAuthor('Your Company Name');
      $pdf->SetTitle('Payment Receipt');
      $pdf->SetSubject('Receipt');
      
      // Set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
      
      // Set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      
      // Set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
      
      // Set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      
      // Set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
      
      // Add a page
      $pdf->AddPage();
      
      // Set font
      $pdf->SetFont('helvetica', '', 12);
      
      // Title
      $pdf->Cell(0, 10, 'Payment Receipt', 0, 1, 'C');
      $pdf->Ln(10); // Line break
      
      // Add payment details
      $pdf->SetFont('helvetica', '', 12);
      $pdf->Cell(50, 10, 'Receipt No:', 0, 0);
      $pdf->Cell(0, 10, $payment['id'], 0, 1);
      
      $pdf->Cell(50, 10, 'Date:', 0, 0);
      $pdf->Cell(0, 10, $payment['date'], 0, 1);
      
      $pdf->Cell(50, 10, 'Customer Name:', 0, 0);
      $pdf->Cell(0, 10, $payment['customer_name'], 0, 1);
      
      $pdf->Cell(50, 10, 'Amount:', 0, 0);
      $pdf->Cell(0, 10, '$' . number_format($payment['amount'], 2), 0, 1);
      
      $pdf->Cell(50, 10, 'Payment Method:', 0, 0);
      $pdf->Cell(0, 10, $payment['payment_method'], 0, 1);
      
      $pdf->Ln(20); // Line break
      
      // Add thank you note
      $pdf->Cell(0, 10, 'Thank you for your payment!', 0, 1, 'C');
      
      // Output the PDF to a file on the server
      $pdf->Output($save_path, 'F');
      
      // Optionally, you can echo a message or redirect to another page
      echo "Payment receipt saved: <a href='../../docs/payment_receipt.pdf'>Download</a>";
      ?>

  ```
  Send the generated PDF file as an attachment along with your email using PHPMailer
  Modify sendEmail Function
    ```php
        function sendEmailWithAttachment($recipient = null, $recipient_name = null, $subject = null, $message = null, $attachment_path = null) {
          $mail = new PHPMailer(true);
      
          try {
              // Set mailer to use SMTP
              $mail->isSMTP();
              $mail->SMTPDebug = 0; // Set to 2 for detailed debugging
      
              // SMTP configuration (example for Gmail)
              $mail->Host = 'smtp.gmail.com';
      
              // Enable TLS encryption
              $mail->SMTPSecure = 'tls';
      
              // Set the SMTP port (465 for SSL, 587 for TLS)
              $mail->Port = 587;
      
              // Set your Gmail credentials
              $mail->SMTPAuth = true;
              $mail->Username = 'bitprojectclass@gmail.com'; // Your Gmail address
              $mail->Password = 'xxxxxxxxxxx'; // Your Gmail password
              // Set the 'from' address and recipient
              $mail->setFrom('your@gmail.com', 'Your Name');
              $mail->addAddress($recipient, $recipient_name);
      
              // Set email subject and body
              $mail->Subject = $subject;
              $mail->Body = $message;
              $mail->isHTML(true);
      
              // Attach PDF file if path provided
              if ($attachment_path !== null) {
                  $mail->addAttachment($attachment_path);
              }
      
              // Send the email
              $mail->send();
              
              echo 'Email has been sent successfully';
          } catch (Exception $e) {
              echo "Mailer Error: {$mail->ErrorInfo}";
          }
      }
    ```
    Create Email sendig file
      ```php
          <?php
          include '../../mail.php';
          
          $msg = "<h1>SUCCESS</h1>";
          $msg .= "<h2>Congratulations</h2>";
          $msg .= "<p>Your account has been successfully created</p>";
          $msg .= "Click here to verifiy your account</a>";
          $pdf_file = __DIR__ . '/../../docs/payment_receipt.pdf';
          sendEmailWithAttachment("mpsarathw@gmail.com", "Sarath", "Account Verification", $msg,$pdf_file);
          
          ?>
      ```
