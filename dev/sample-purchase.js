#!/usr/bin/env node

const data = [
  {
    items: ["110001", "110001"],
    purchaseTime: "2022/11/01 10:50:01",
    staffId: 1,
    payedCash: false,
  },
  {
    items: ["110001"],
    purchaseTime: "2022/11/01 11:00:21",
    staffId: 2,
    payedCash: true,
  },
  {
    items: ["330001", "210002"],
    purchaseTime: "2022/11/08 14:00:15",
    staffId: 3,
    payedCash: false,
  },
  {
    items: ["310004"],
    purchaseTime: "2022/11/17 09:12:28",
    staffId: 4,
    payedCash: false,
  },
  {
    items: ["220003", "110002"],
    purchaseTime: "2022/11/03 11:45:29",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["320001"],
    purchaseTime: "2022/11/22 15:13:40",
    staffId: 1,
    payedCash: true,
  },
  {
    items: ["120001", "220001"],
    purchaseTime: "2022/11/09 18:27:34",
    staffId: 3,
    payedCash: false,
  },
  {
    items: ["330001"],
    purchaseTime: "2022/11/17 20:37:56",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["110001", "120002", "310002", "330002"],
    purchaseTime: "2022/11/07 10:34:15",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["220004"],
    purchaseTime: "2022/11/01 15:38:11",
    staffId: 1,
    payedCash: true,
  },
  {
    items: ["110004", "320002", "330001"],
    purchaseTime: "2022/11/01 11:11:18",
    staffId: 1,
    payedCash: false,
  },
  {
    items: ["210003"],
    purchaseTime: "2022/11/06 16:05:34",
    staffId: 4,
    payedCash: true,
  },
  {
    items: ["220001"],
    purchaseTime: "2022/11/23 11:18:59",
    staffId: 5,
    payedCash: false,
  },
  {
    items: ["110002", "210004"],
    purchaseTime: "2022/11/01 13:19:27",
    staffId: 5,
    payedCash: false,
  },
  {
    items: ["110001", "330002"],
    purchaseTime: "2022/11/12 17:36:51",
    staffId: 3,
    payedCash: false,
  },
  {
    items: ["220001"],
    purchaseTime: "2022/11/07 10:20:30",
    staffId: 2,
    payedCash: true,
  },
  {
    items: ["220002"],
    purchaseTime: "2022/11/21 21:43:01",
    staffId: 1,
    payedCash: true,
  },
  {
    items: ["210003"],
    purchaseTime: "2022/11/15 18:43:16",
    staffId: 1,
    payedCash: false,
  },
  {
    items: ["110001", "320001"],
    purchaseTime: "2022/11/16 08:11:24",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["110002", "210003", "220003", "320001"],
    purchaseTime: "2022/11/19 16:41:55",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["220002", "320002"],
    purchaseTime: "2022/11/17 09:15:32",
    staffId: 3,
    payedCash: false,
  },
  {
    items: ["110002"],
    purchaseTime: "2022/11/16 22:11:19",
    staffId: 3,
    payedCash: false,
  },
  {
    items: ["310001"],
    purchaseTime: "2022/11/08 16:43:22",
    staffId: 4,
    payedCash: true,
  },
  {
    items: ["110004", "220004"],
    purchaseTime: "2022/11/06 17:00:49",
    staffId: 4,
    payedCash: false,
  },
  {
    items: ["210001", "310002"],
    purchaseTime: "2022/11/11 11:11:22",
    staffId: 5,
    payedCash: true,
  },
  {
    items: ["310004"],
    purchaseTime: "2022/11/01 15:34:21",
    staffId: 1,
    payedCash: false,
  },
  {
    items: ["220003"],
    purchaseTime: "2022/11/01 14:56:41",
    staffId: 2,
    payedCash: true,
  },
  {
    items: ["210004"],
    purchaseTime: "2022/11/07 07:11:44",
    staffId: 1,
    payedCash: false,
  },
  {
    items: ["110004"],
    purchaseTime: "2022/11/17 18:05:55",
    staffId: 1,
    payedCash: false,
  },
  {
    items: ["220002"],
    purchaseTime: "2022/11/01 16:37:58",
    staffId: 4,
    payedCash: false,
  },
  {
    items: ["330001"],
    purchaseTime: "2022/11/09 12:47:21",
    staffId: 5,
    payedCash: true,
  },
  {
    items: ["320002"],
    purchaseTime: "2022/11/21 13:42:31",
    staffId: 2,
    payedCash: true,
  },
  {
    items: ["310001", "320002", "330001"],
    purchaseTime: "2022/11/01 09:11:06",
    staffId: 1,
    payedCash: false,
  },
  {
    items: ["210001"],
    purchaseTime: "2022/11/05 11:44:22",
    staffId: 2,
    payedCash: true,
  },
  {
    items: ["110004", "210001"],
    purchaseTime: "2022/11/22 20:17:50",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["120001", "120002"],
    purchaseTime: "2022/11/29 11:48:19",
    staffId: 4,
    payedCash: true,
  },
  {
    items: ["310003"],
    purchaseTime: "2022/11/29 11:12:30",
    staffId: 5,
    payedCash: false,
  },
  {
    items: ["210003"],
    purchaseTime: "2022/11/01 13:56:43",
    staffId: 4,
    payedCash: false,
  },
  {
    items: ["110003", "120001"],
    purchaseTime: "2022/11/11 18:51:30",
    staffId: 4,
    payedCash: false,
  },
  {
    items: ["320001", "330001"],
    purchaseTime: "2022/11/16 10:14:27",
    staffId: 4,
    payedCash: true,
  },
  {
    items: ["120004"],
    purchaseTime: "2022/11/13 19:27:21",
    staffId: 3,
    payedCash: false,
  },
  {
    items: ["320002"],
    purchaseTime: "2022/11/29 14:48:12",
    staffId: 2,
    payedCash: true,
  },
  {
    items: ["210003", "210003", "210003", "210003", "210003"],
    purchaseTime: "2022/11/11 11:20:14",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["110002"],
    purchaseTime: "2022/11/15 18:00:00",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["330001"],
    purchaseTime: "2022/11/27 12:00:05",
    staffId: 1,
    payedCash: true,
  },
  {
    items: [
      "220002",
      "220002",
      "220002",
      "220002",
      "220002",
      "220002",
      "220002",
      "220002",
      "220002",
    ],
    purchaseTime: "2022/11/05 04:41:23",
    staffId: 1,
    payedCash: false,
  },
  {
    items: ["110002"],
    purchaseTime: "2022/11/20 15:04:33",
    staffId: 3,
    payedCash: false,
  },
  {
    items: ["210001"],
    purchaseTime: "2022/11/15 16:20:21",
    staffId: 3,
    payedCash: false,
  },
  {
    items: ["310003"],
    purchaseTime: "2022/11/28 09:18:27",
    staffId: 2,
    payedCash: false,
  },
  {
    items: ["120001"],
    purchaseTime: "2022/11/17 20:11:10",
    staffId: 1,
    payedCash: false,
  },
];

const prices = {
  110001: 23.99,
  110002: 25.99,
  110003: 30.99,
  110004: 19.99,
  120001: 89.99,
  120002: 95.95,
  120003: 595.99,
  120004: 112,
  210001: 89.95,
  210002: 77.99,
  210003: 121.95,
  210004: 146.99,
  220001: 87.99,
  220002: 79.95,
  220003: 99.99,
  220004: 112.45,
  310001: 359.99,
  310002: 688.99,
  310003: 296.99,
  310004: 1000,
  320001: 299.99,
  320002: 315.95,
  330001: 210.99,
  330002: 175.95,
};
function getPrice(items) {
  let price = 0;
  for (let i = 0; i < items.length; i++) {
    price += prices[items[i]];
  }
  return price;
}

var saleInserts = [];
var sale_productInserts = [];
var paymentInserts = [];

const store_id = 1;
for (let i = 0; i < data.length; i++) {
  const purchase = data[i];
  const sale_id = i + 1;
  const totalCost = getPrice(purchase.items);
  const staffId = purchase.staffId;
  const reviewCode = Math.floor(Math.random() * 2 ** 26).toString(16);
  const purchaseTime = purchase.purchaseTime;

  // insert into sale
  saleInserts.push(
    `INSERT INTO Sale (sale_id, store_id, totalCost, staff_id, review_code, date) VALUES (${sale_id}, ${store_id}, ${totalCost.toFixed(
      2
    )}, ${staffId}, "${reviewCode}", "${purchaseTime}");`
  );
  // insert into sale_product
  for (let j = 0; j < purchase.items.length; j++) {
    sale_productInserts.push(
      `INSERT INTO Sale_Product (sale_id, sku_code, quantity) VALUES (${sale_id}, ${purchase.items[j]}, 1);`
    );
  }
  // insert into cash/card payment
  if (purchase.payedCash) {
    const roundedTo = [0, 1, 2, 5, 10, 20];
    const overBy = roundedTo[Math.floor(Math.random() * roundedTo.length)];
    var initialTender = totalCost;
    if (overBy != 0) {
      initialTender += overBy;
      initialTender = Math.floor(initialTender);
    }
    paymentInserts.push(
      `INSERT INTO CashPayment (sale_id, initialTender) VALUES (${sale_id}, ${initialTender});`
    );
  } else {
    const cardLast4Digits = Math.floor(Math.random() * 10_000) + 1_000;
    paymentInserts.push(
      `INSERT INTO CardPayment (sale_id, last4Digits) VALUES (${sale_id}, ${cardLast4Digits});`
    );
  }
}

console.log("USE 22ac3d03;");
saleInserts.forEach((e) => console.log(e));
sale_productInserts.forEach((e) => console.log(e));
paymentInserts.forEach((e) => console.log(e));

// INSERT INTO Sale (store_id, totalCost, staff_id, review_code) VALUES (:store_id, :totalCost, :staff_id, :review_code)
// INSERT INTO Sale_Product(sale_id, sku_code, quantity) VALUES(: sale_id, : sku_code, 1)
// INSERT INTO CardPayment (sale_id, last4Digits) VALUES (:sale_id, :last4Digits)
