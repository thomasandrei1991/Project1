document.addEventListener('DOMContentLoaded', function() {
    loadItems();
    
    // Add item form submission
    document.getElementById('add-item-form').addEventListener('submit', function(e) {
        e.preventDefault();
        addItem();
    });
    
    // Edit modal close
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('edit-modal').style.display = 'none';
    });
    
    // Edit form submission
    document.getElementById('edit-item-form').addEventListener('submit', function(e) {
        e.preventDefault();
        updateItem();
    });
});

function loadItems() {
    fetch('get_items.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayItems(data.items);
            } else {
                console.error('Error loading items:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
}

function displayItems(items) {
    const tbody = document.querySelector('#inventory-table tbody');
    tbody.innerHTML = '';
    
    items.forEach(item => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.id}</td>
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>$${parseFloat(item.price).toFixed(2)}</td>
            <td>${item.description || ''}</td>
            <td>
                <button class="action-btn edit-btn" onclick="editItem(${item.id}, '${item.name}', ${item.quantity}, ${item.price}, '${item.description || ''}')">Edit</button>
                <button class="action-btn delete-btn" onclick="deleteItem(${item.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function addItem() {
    const formData = new FormData(document.getElementById('add-item-form'));
    
    fetch('add_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('add-item-form').reset();
            loadItems();
            alert('Item added successfully!');
        } else {
            alert('Error adding item: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function editItem(id, name, quantity, price, description) {
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-quantity').value = quantity;
    document.getElementById('edit-price').value = price;
    document.getElementById('edit-description').value = description;
    document.getElementById('edit-modal').style.display = 'block';
}

function updateItem() {
    const formData = new FormData(document.getElementById('edit-item-form'));
    
    fetch('update_item.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('edit-modal').style.display = 'none';
            loadItems();
            alert('Item updated successfully!');
        } else {
            alert('Error updating item: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function deleteItem(id) {
    if (confirm('Are you sure you want to delete this item?')) {
        fetch('delete_item.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadItems();
                alert('Item deleted successfully!');
            } else {
                alert('Error deleting item: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
}
