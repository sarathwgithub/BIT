<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart Details</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>
    </head>
    <body>
        <h2>Cart Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Options</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $item): ?>
                    <tr>
                        <td><?= $item['name'] ?></td>
                        <td>
                            <?= form_open('mycart/updateCart') ?>
                            <input type='text' name='qty' value="<?= $item['qty'] ?>" onchange="form.submit()">
                            <input type="hidden" name="rowId" value="<?= $item['rowid'] ?>">
                            <?= form_close() ?>
                        </td>
                        <td>$<?= $item['price'] ?></td>
                        <td>
                            <?php if (!empty($item['options']['dish_options_name'])): ?>
                                <?= $item['options']['dish_options_name'] ?>
                            <?php else: ?>
                                None
                            <?php endif; ?>
                        </td>
                        <td>$<?= $item['subtotal'] ?></td>
                        <td><a href="<?= site_url('mycart/removeItem/') . $item['rowid'] ?> ?>">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </body>
</html>
