<?php

    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }

    require_once __DIR__ . "/config/database.php";
    $sql = "SELECT * FROM products";
    $result = mysqli_query($conn, $sql);
    $categoryQuery = "SELECT DISTINCT category FROM products";
    $categoryResult = mysqli_query($conn, $categoryQuery);
    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>POS</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <div class="dashboard-container">
            <div class="sidebar">
                <h2>POS SYSTEM</h2>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a class="active" href="pos.php">POS</a></li>
                    <?php if($_SESSION['role'] == 'admin'){ ?>
                        <li><a href="inventory.php">Inventory</a></li>
                        <li><a href="reports.php">Reports</a></li>
                    <?php } ?>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div class="main-content">
                <h1>Point of Sale</h1>
                <div class="pos-container">
                    <div class="search-container">
                        <input type="text" id="search" placeholder="Search Product..." onkeyup="searchProduct()">
                        <select id="categoryFilter" onchange="filterCategory()">
                            <option value="all">All Categories</option>
                            <?php 
                                $categoryResult = mysqli_query($conn, "SELECT DISTINCT category FROM products ORDER BY category ASC");
                                while($category = mysqli_fetch_assoc($categoryResult)){ 
                            ?>
                            <option value="<?php echo strtolower(trim($category['category'])); ?>">
                                <?php echo ucfirst($category['category']); ?>
                            </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="products">
                        <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <div class="product-card" data-name="<?php echo strtolower($row['product_name']); ?>" data-category="<?php echo strtolower(trim($row['category'])); ?>">
                            <h3><?php echo $row['product_name']; ?></h3>
                            <p> ₱<?php echo $row['price']; ?></p>
                            <p style="font-size: 0.85rem; color: #64748b; margin: 8px 0;">Stock: <strong><?php echo $row['stocks']; ?></strong></p>
                            <button onclick="addToCart('<?php echo $row['product_name']; ?>', <?php echo $row['price']; ?>, <?php echo $row['stocks']; ?>)" <?php echo ($row['stocks'] <= 0) ? 'disabled style="opacity: 0.5; cursor: not-allowed;"' : ''; ?>> 
                                <?php echo ($row['stocks'] <= 0) ? 'Out of Stock' : 'Add to Cart'; ?>
                            </button>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="cart">
                        <div class="cart-header">
                            <h2>Cart</h2>
                            <span class="cart-count">(<span id="cart-count">0</span> items)</span>
                        </div>
                        <div class="cart-table-wrapper">
                            <table class="cart-table" width="100%">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items"></tbody>
                            </table>
                        </div>
                        <div class="cart-summary">
                            <div class="summary-row">
                                <span>Total</span>
                                <strong>₱<span id="total">0</span></strong>
                            </div>
                            <div class="cart-actions">
                                <input type="number" id="payment" placeholder="Enter Payment">
                                <button onclick="checkout()"> Checkout </button>
                            </div>
                            <div class="summary-row summary-change">
                                <span>Change</span>
                                <strong>₱<span id="change">0</span></strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="receipt" class="receipt">
                    <button class="close-btn" onclick="closeReceipt()">&times;</button>
                    <h2>POS SYSTEM</h2>
                    <hr>
                    <div id="receipt-items"></div>
                    <hr>
                    <h3>Total:₱<span id="receipt-total">0</span></h3>
                    <h3>Payment: ₱<span id="receipt-payment">0</span>
                    </h3>
                    <h3>Change: ₱<span id="receipt-change">0</span></h3>
                    <br>
                    <p>Thank you for your purchase!</p>
                    <button onclick="printReceipt()">Print Receipt</button>
                </div>
            </div>
        </div>
        <script>
            let cart = [];

            function addToCart(product, price, availableStock){
                let existing = cart.find(item => item.product === product);
                let currentQuantityInCart = existing ? existing.qty : 0;

                if(currentQuantityInCart >= availableStock){
                    alert("Cannot add more " + product + ". Only " + availableStock + " available in stock.");
                    return;
                }

                if(existing){
                    existing.qty++;
                }
                else {
                    cart.push({
                        product: product,
                        price: price,
                        qty: 1
                    });
                }
                displayCart();
            }

            function displayCart(){
                let cartItems = document.getElementById("cart-items");
                cartItems.innerHTML = "";
                let total = 0;
                if (cart.length === 0) {
                    cartItems.innerHTML = `
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 24px; color: #64748b;">
                                Your cart is empty.
                            </td>
                        </tr>
                    `;
                }

                cart.forEach((item, index) => {
                    let itemTotal = item.price * item.qty;
                    total += itemTotal;
                    let row = `
                        <tr>
                            <td>${item.product}</td>
                            <td>₱${item.price}</td>
                            <td class="qty-cell">
                                <div class="qty-controls">
                                    <button class="qty-btn" onclick="decreaseQty(${index})">-</button>
                                    <span class="qty-value">${item.qty}</span>
                                    <button class="qty-btn" onclick="increaseQty(${index})">+</button>
                                </div>
                            </td>
                            <td>
                                ₱${itemTotal}
                            </td>
                            <td>
                                <button onclick="removeItem(${index})">Remove</button>
                            </td>
                        </tr>
                    `;
                    cartItems.innerHTML += row;
                });

                document.getElementById("total").innerText = total;
                document.getElementById("cart-count").innerText = cart.length;
            }

            function increaseQty(index){
                cart[index].qty++;
                displayCart();
            }

            function decreaseQty(index){
                if(cart[index].qty > 1){
                    cart[index].qty--;
                }
                displayCart();
            }

            function removeItem(index){
                cart.splice(index, 1);
                displayCart();
            }

            function checkout(){
                let total = parseFloat(document.getElementById("total").innerText);
                let payment = parseFloat(document.getElementById("payment").value);

                if(payment < total){
                    alert("Insufficient Payment");
                    return;
                }
                let change = payment - total;

                document.getElementById("change").innerText = change;
                fetch("actions/checkout.php", {
                    method: "POST",
                    headers:{
                        "Content-Type":"application/json"
                    },
                    body: JSON.stringify(cart)
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(text);
                        });
                    }
                    return response.text();
                })
                .then(data => {
                    let receiptItems = "";
                    cart.forEach(item => {
                        receiptItems += `
                            <p>
                                ${item.product}
                                x${item.qty}
                                - ₱${item.price * item.qty}
                            </p>
                        `;
                    });

                    document.getElementById("receipt-items").innerHTML = receiptItems;
                    document.getElementById("receipt-total").innerText = total;
                    document.getElementById("receipt-payment").innerText = payment;
                    document.getElementById("receipt-change").innerText = change;
                    document.getElementById("receipt").style.display = "block";
                    alert("Checkout Successful! Inventory has been updated.");
                    cart = [];
                    displayCart();
                    document.getElementById("payment").value = "";
                })
                .catch(error => {
                    alert("Error: " + error.message);
                    document.getElementById("change").innerText = "0";
                });

            }

            function printReceipt(){
                let receipt = document.getElementById("receipt").innerHTML;
                let original = document.body.innerHTML;
                document.body.innerHTML = receipt;
                window.print();
                document.body.innerHTML = original;
                location.reload();
            }

            function closeReceipt(){
                document.getElementById("receipt").style.display = "none";
            }

            // Optional: populate receipt elements and show receipt
            function showReceipt(payment, change, total){
                const receipt = document.getElementById('receipt');
                const items = document.getElementById('receipt-items');
                items.innerHTML = '';
                cart.forEach(item => {
                    const div = document.createElement('div');
                    div.textContent = `${item.product} x${item.qty} — ₱${item.price * item.qty}`;
                    items.appendChild(div);
                });
                document.getElementById('receipt-total').innerText = total;
                document.getElementById('receipt-payment').innerText = payment;
                document.getElementById('receipt-change').innerText = change;
                receipt.style.display = 'block';
            }

            function searchProduct(){
                let input = document.getElementById("search").value.toLowerCase();
                let cards = document.querySelectorAll(".product-card");
                cards.forEach(card => {
                    let name = card.dataset.name;
                    if(name.includes(input)){
                        card.style.display = "";
                    }else{
                        card.style.display = "none";
                    }
                });
            }

            function filterCategory(){
                let category = document.getElementById("categoryFilter").value.toLowerCase().trim();
                let cards = document.querySelectorAll(".product-card");
                cards.forEach(card => {
                    let productCategory = card.dataset.category.toLowerCase().trim();
                    if(category === "all" || productCategory === category){
                        card.style.display = "";
                    }else{
                        card.style.display = "none";
                    }
                });
            }

        </script>
    </body>
</html>