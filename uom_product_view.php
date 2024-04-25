<?php
foreach ($product as $key => $value) {
    ?>
    <div>
        <div><img src="<?= site_url('public/images/') . $value['Image'] ?>"></div>
        <?= $value['Name'] ?>
        <?= $value['Category'] ?>
        <?= $value['Price'] ?>
        <?= form_open('mycart/addCart') ?>
        <input type="hidden" name="Id" value="<?= $value['Id'] ?>">
        <input type="hidden" name="Name" value="<?= $value['Name'] ?>">
        <input type="text" name="Qty">
        <select name="dish_options" id="dish_options">
            <option value="">Select Option</option>
            <?php foreach ($dishOptions[$value['Id']] as $option): ?>
                <option value="<?= $option['Id'] ?>"><?= $option['Description'] ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="Price" value="<?= $value['Price'] ?>">
        <button type='submit'>Add to Cart</button>
        <?= form_close() ?>
    </div>

    <?php
}
