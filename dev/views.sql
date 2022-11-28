-- Receipt details
CREATE VIEW ReceiptDetails AS
SELECT Sale.sale_id,
  Sale.date,
  Sale.totalCost,
  Sale.review_code,
  Store.location,
  Staff.firstname,
  CashPayment.initialTender,
  CardPayment.last4Digits
FROM Sale
  JOIN Store ON (Sale.store_id = Store.store_id)
  JOIN Staff ON (Sale.staff_id = Staff.staff_id)
  LEFT JOIN CashPayment ON (Sale.sale_id = CashPayment.sale_id)
  LEFT JOIN CardPayment ON (Sale.sale_id = CardPayment.sale_id);
-- Receipt items
CREATE VIEW SaleItems AS
SELECT Sale.sale_id,
  Sale.review_code,
  Product.sku_code,
  Product.name,
  Product.price,
  Sale_Product.quantity
FROM Sale
  JOIN Sale_Product ON (Sale.sale_id = Sale_Product.sale_id)
  JOIN Product ON (Sale_Product.sku_code = Product.sku_code);
-- Staff details for banner
CREATE VIEW StaffDetails AS
SELECT Store.store_id,
  Store.location,
  AccessLevel.name AS accessLevelName,
  Staff.firstname,
  Staff.lastname,
  Staff.login_username
FROM Staff
  JOIN Store ON (Staff.store_id = Store.store_id)
  JOIN AccessLevel ON (
    Staff.accessLevel_id = AccessLevel.accessLevel_id
  );
-- Cash and Card sales
CREATE VIEW CashCardSales AS
SELECT Store.store_id,
  Sale.date,
  Sale.totalCost,
  CardPayment.cardPayment_id,
  CashPayment.cashPayment_id
FROM Sale
  JOIN Store ON (Sale.store_id = Store.store_id)
  LEFT JOIN CashPayment ON (Sale.sale_id = CashPayment.sale_id)
  LEFT JOIN CardPayment ON (Sale.sale_id = CardPayment.sale_id);
-- Top Sellers
CREATE VIEW TopSellers AS
SELECT Store.store_id,
  Sale.date,
  Product.sku_code,
  Product.name,
  COUNT(Sale_Product.quantity) AS quantity
FROM Sale
  JOIN Sale_Product ON (Sale.sale_id = Sale_Product.sale_id)
  JOIN Store ON (Sale.store_id = Store.store_id)
  JOIN Product ON (Sale_Product.sku_code = Product.sku_code)
GROUP BY Sale_Product.sku_code,
  MONTH(Sale.date),
  YEAR(Sale.date),
  Store.store_id
ORDER BY quantity DESC;
-- Average Rating
CREATE VIEW AverageRating AS
SELECT Product.sku_code,
  coalesce(ROUND(AVG(Review.rating), 1), '?') AS rating
FROM Product
  LEFT JOIN Review ON (Product.sku_code = Review.sku_code)
GROUP BY Product.sku_code;
-- ProductList
CREATE VIEW ProductList AS
SELECT sku_code,
  name,
  description,
  price
FROM Product;
-- SaleHistory
CREATE VIEW SaleHistory AS
SELECT Sale.sale_id,
  Sale.date,
  Sale.store_id,
  Staff.firstname,
  Staff.lastname,
  COUNT(Sale_Product.quantity) AS quantity,
  Sale.totalCost
FROM Sale
  JOIN Staff ON (Sale.staff_id = Staff.staff_id)
  JOIN Sale_Product ON (Sale.sale_id = Sale_Product.sale_id)
GROUP BY Sale.sale_id;