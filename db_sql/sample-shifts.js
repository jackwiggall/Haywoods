#!/usr/bin/env node

// shifts
const data = [
  [
    ["michael", "09:00:00", "13:00:00"],
    ["nicole", "13:00:00", "20:00:00"],
    ["robyn", "12:00:00", "18:00:00"],
    ["benjamin", "09:00:00", "17:00:00"],
    ["chris", "15:00:00", "20:00:00"],
  ],
  [
    ["louise", "09:00:00", "17:00:00"],
    ["chris", "11:00:00", "19:00:00"],
    ["elliot", "14:00:00", "20:00:00"],
    ["gregor", "09:00:00", "19:00:00"],
    ["jonathan", "12:00:00", "18:00:00"],
  ],
  [
    ["michael", "09:00:00", "13:00:00"],
    ["nicole", "09:00:00", "17:00:00"],
    ["elliot", "16:00:00", "20:00:00"],
    ["benjamin", "10:00:00", "18:00:00"],
    ["jack", "12:00:00", "16:00:00"],
  ],
  [
    ["michael", "16:00:00", "20:00:00"],
    ["nicole", "09:00:00", "17:00:00"],
    ["elliot", "12:00:00", "16:00:00"],
    ["benjamin", "09:00:00", "15:00:00"],
    ["jack", "14:00:00", "18:00:00"],
  ],
  [
    ["louise", "09:00:00", "17:00:00"],
    ["michael", "16:00:00", "20:00:00"],
    ["nicole", "09:00:00", "17:00:00"],
    ["benjamin", "12:00:00", "20:00:00"],
    ["jack", "12:00:00", "16:00:00"],
    ["gregor", "09:00:00", "19:00:00"],
  ],
  [
    ["louise", "09:00:00", "17:00:00"],
    ["jonathan", "16:00:00", "20:00:00"],
    ["elliot", "16:00:00", "20:00:00"],
    ["chris", "09:00:00", "14:00:00"],
    ["robyn", "12:00:00", "18:00:00"],
    ["jack", "14:00:00", "18:00:00"],
    ["gregor", "09:00:00", "19:00:00"],
  ],
  [
    ["louise", "09:00:00", "17:00:00"],
    ["nicole", "13:00:00", "20:00:00"],
    ["chris", "12:00:00", "20:00:00"],
    ["gregor", "09:00:00", "19:00:00"],
  ],
];

nameMaps = {
  michael: 1,
  elliot: 2,
  benjamin: 3,
  chris: 4,
  nicole: 5,
  jack: 6,
  jonathan: 7,
  louise: 8,
  gregor: 9,
  robyn: 10,
};

let inserts = [];

const monthStart = Date.parse("2022-11-01 00:00:00");
const monthEnd = Date.parse("2022-11-30 00:00:00");

function getDate(date) {
  const f = new Date(focusDay).toLocaleDateString().split("/");
  return `${f[2]}-${f[1]}-${f[0]}`;
}

let focusDay = monthStart;
let counter = 1;
while (focusDay < monthEnd) {
  data.forEach((day) => {
    const focus = new Date(focusDay).toLocaleString();
    day.forEach((staff) => {
      if (focusDay < monthEnd) {
        const staff_id = nameMaps[staff[0]];
        const start = getDate(focusDay) + " " + staff[1];
        const end = getDate(focusDay) + " " + staff[2];
        inserts.push(`(${counter}, ${staff_id}, "${start}", "${end}")`);
      }
      counter++;
    });
    focusDay = focusDay + 1_000 * 60 * 60 * 24;
  });
}

console.log("use 22ac3d03;");
console.log(
  "INSERT INTO Shift (shift_id, staff_id, start, end) VALUES \n" +
    inserts.join(",\n") +
    ";"
);
