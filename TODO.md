- [ ] Inspect `inventory/actions/update_product.php` for current update + image upload logic
- [ ] Implement fix: preserve old image when no file uploaded; validate upload; add error handling
- [ ] Convert UPDATE query to prepared statement to avoid SQL breakage/injection
- [ ] Redirect back to inventory on success; show error on failure
- [ ] Smoke test: update product with no image change, and with image change

