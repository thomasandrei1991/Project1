<?php

session_start();

if(!isset($_SESSION['username'])){
    header("Location: login.php");
}

require_once __DIR__ . "/config/database.php";

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>POS</title>

    <link rel="stylesheet"
          href="assets/css/style.css">

</head>

<body>

<div class="dashboard-container">

    <div class="sidebar">

        <h2>POS SYSTEM</h2>

        <ul>

            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a class="active" href="pos.php">POS</a></li>
            <li><a href="inventory.php">Inventory</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="logout.php">Logout</a></li>

        </ul>

    </div>

    <div class="main-content">

        <h1>Point of Sale</h1>

        <div class="pos-container">

            <div class="products">

                <?php
                while($row = mysqli_fetch_assoc($result)){
                ?>

                <div class="product-card">

                    <h3>
                        <?php echo $row['product_name']; ?>
                    </h3>

                    <p>
                        ₱<?php echo $row['price']; ?>
                    </p>

                    <button
                        onclick="addToCart(
                            '<?php echo $row['product_name']; ?>',
                            <?php echo $row['price']; ?>
                        )">

                        Add to Cart

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
                        <input type="number"
                               id="payment"
                               placeholder="Enter Payment">
                        <button onclick="checkout()">
                            Checkout
                        </button>
                    </div>

                    <div class="summary-row summary-change">
                        <span>Change</span>
                        <strong>₱<span id="change">0</span></strong>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<script>

let cart = [];

function addToCart(product, price){

    let existing =
        cart.find(item => item.product === product);

    if(existing){

        existing.qty++;

    }else{

        cart.push({
            product: product,
            price: price,
            qty: 1
        });

    }

    displayCart();

}

function displayCart(){

    let cartItems =
        document.getElementById("cart-items");

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

        let itemTotal =
            item.price * item.qty;

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

                    <button onclick="
                        removeItem(${index})
                    ">
                        Remove
                    </button>

                </td>

            </tr>
        `;

        cartItems.innerHTML += row;

    });

    document.getElementById("total")
            .innerText = total;

    document.getElementById("cart-count")
            .innerText = cart.length;

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

    let total =
        parseFloat(
            document.getElementById("total")
            .innerText
        );

    let payment =
        parseFloat(
            document.getElementById("payment")
            .value
        );

    let change = payment - total;

    document.getElementById("change")
            .innerText = change;

    alert("Checkout Successful!");

}

</script>

</body>
</html>