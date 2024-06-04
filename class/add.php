<?php
ob_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Add";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);
    $DesignationId = dataClean($DesignationId);
    $DepartmentId = dataClean($DepartmentId);
    $AppDate = dataClean($AppDate);
    $UserName = dataClean($UserName);

    $message = array();
    if (empty($FirstName)) {
        $message['FirstName'] = "The First Name should not be blank...!";
    }
    if (empty($LastName)) {
        $message['LastName'] = "The Last Name should not be blank...!";
    }
    if (empty($DesignationId)) {
        $message['DesignationId'] = "The Designation should not be blank...!";
    }
    if (empty($DepartmentId)) {
        $message['DepartmentId'] = "The Department should not be blank...!";
    }
    if (empty($AppDate)) {
        $message['AppDate'] = "The App. Date should not be blank...!";
    }
    if (empty($UserName)) {
        $message['UserName'] = "The UserName should not be blank...!";
    }
    if (empty($Password)) {
        $message['Password'] = "The Password should not be blank...!";
    }
    if (!empty($UserName)) {
        $user = new User();
        if ($user->checkUserName($UserName) > 0) {
            $message['UserName'] = "This User Name already exsist...!";
        }
    }
    if (!empty($Password)) {
        $uppercase = preg_match('@[A-Z]@', $Password);
        $lowercase = preg_match('@[a-z]@', $Password);
        $number = preg_match('@[0-9]@', $Password);
        $specialChars = preg_match('@[^\w]@', $Password);

        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($Password) < 8) {
            $message['Password'] = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.';
        }
    }
    if (empty($message)) {
        //Use bcrypt hasing algorithem
        $pw = password_hash($Password, PASSWORD_DEFAULT);

        $employee = new Employee();
        $employee->save($FirstName, $LastName, $UserName, $pw, $AppDate, $DesignationId, $DepartmentId);

        header("Location:manage.php");
    }
}
?>
<div class="row">
    <div class="col-12">

        <a href="" class="btn btn-dark mb-2"><i class="fas fa-plus-circle"></i> New</a>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New User</h3>
            </div>              
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <div class="card-body">

                    <div class="form-group">
                        <label for="inputFirstName">First Name</label>
                        <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter First Name" value="<?= @$FirstName ?>">
                        <span class="text-danger"><?= @$message['FirstName'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="inputLastName">Last Name</label>
                        <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Enter Last Name" value="<?= @$LastName ?>">
                        <span class="text-danger"><?= @$message['LastName'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="DesignationId">Designation</label>
<?php
$db = dbConn();
$sql = "SELECT * FROM designations";
$result = $db->query($sql);
?>
                        <select class="form-control" id="DesignationId" name="DesignationId">
                            <option value="">--</option>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?= $row['Id'] ?>" <?= @$DesignationId == $row['Id'] ? 'selected' : '' ?>><?= $row['Designation'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?= @$message['DesignationId'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="DepartmentId">Department</label>
<?php
$db = dbConn();
$sql = "SELECT * FROM departments";
$result = $db->query($sql);
?>
                        <select class="form-control" id="DepartmentId" name="DepartmentId">
                            <option value="">--</option>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?= $row['Id'] ?>" <?= @$DepartmentId == $row['Id'] ? 'selected' : '' ?>><?= $row['Department'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?= @$message['DepartmentId'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="AppDate">Application Date</label>
                        <input type="date" class="form-control" id="AppDate" name="AppDate" value="<?= @$AppDate ?>">
                        <span class="text-danger"><?= @$message['AppDate'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="UserName">User Name</label>
                        <input type="text" class="form-control" id="UserName" name="UserName" value="<?= @$UserName ?>" placeholder="Enter User Name">
                        <span class="text-danger"><?= @$message['UserName'] ?></span>
                    </div>
                    <div class="form-group">
                        <label for="Password">Password</label>
                        <input type="password" class="form-control" id="Password" name="Password" placeholder="Password">
                        <span class="text-danger"><?= @$message['Password'] ?></span>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

        </div>
        <!-- /.card -->
    </div>
</div>


<?php
$content = ob_get_clean();
include '../layouts.php';
?>
