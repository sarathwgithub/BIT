----------------------------------------------------
**Date Validation**
----------------------------------------------------
1. Disable the date picker in HTML5 for past dates you can use the min attribute on the <input> element of type date. This attribute specifies the minimum allowable date, which you can set to the current date.
   ```html
      <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Date Validation Form</title>
          
      </head>
      <body>
          <h1>Order Search Form</h1>
          <form id="searchForm" action="search_orders.php" method="POST">
              <label for="order_date">Order Date:</label>
              <input type="date" id="order_date" name="order_date" min="<?= date('Y-m-d') ?>"><br><br>
              
              <label for="customer_name">Customer Name:</label>
              <input type="text" id="customer_name" name="customer_name"><br><br>
              
              <label for="product_name">Product Name:</label>
              <input type="text" id="product_name" name="product_name"><br><br>
              
              <label for="order_status">Order Status:</label>
              <select id="order_status" name="order_status">
                  <option value="">--Select Status--</option>
                  <option value="Pending">Pending</option>
                  <option value="Completed">Completed</option>
                  <option value="Shipped">Shipped</option>
                  <option value="Cancelled">Cancelled</option>
              </select><br><br>
              
              <button type="submit">Search</button>
          </form>    
          
      </body>
      </html>
2. Disable the date picker in HTML5 for feature dates you can use the max attribute on the <input> element of type date
   ```html
      <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Date Validation Form</title>
          
      </head>
      <body>
          <h1>Order Search Form</h1>
          <form id="searchForm" action="search_orders.php" method="POST">
              <label for="order_date">Order Date:</label>
              <input type="date" id="order_date" name="order_date" max="<?= date('Y-m-d') ?>"><br><br>
              
              <label for="customer_name">Customer Name:</label>
              <input type="text" id="customer_name" name="customer_name"><br><br>
              
              <label for="product_name">Product Name:</label>
              <input type="text" id="product_name" name="product_name"><br><br>
              
              <label for="order_status">Order Status:</label>
              <select id="order_status" name="order_status">
                  <option value="">--Select Status--</option>
                  <option value="Pending">Pending</option>
                  <option value="Completed">Completed</option>
                  <option value="Shipped">Shipped</option>
                  <option value="Cancelled">Cancelled</option>
              </select><br><br>
              
              <button type="submit">Search</button>
          </form>
      
          
      </body>
      </html>


   
