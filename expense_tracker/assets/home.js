// INTERFACE
const balance = document.getElementById("balance");
const moneyPlus = document.getElementById("money-plus");
const moneyMinus = document.getElementById("money-minus");
const list = document.getElementById("list");
const form = document.getElementById("form");
const text = document.getElementById("text");
const amount = document.getElementById("amount");



// GLOBAL

// Local Storage
const localStorageTransactions = JSON.parse(localStorage.getItem("transactions"));

// Get transactions from Local Storage or set as empty array
let transactions = localStorage.getItem("transactions") !== null ? localStorageTransactions : [];



// FUNCTIONS

// Add transaction
function addTransaction(eventObject) {
    // prevent default behaviour
    eventObject.preventDefault();
    // check if empty input
    if (text.value.trim() === "" || amount.value.trim() === "") {
        alert("Please fill both the text and the amount.");
    } else {
        // create transaction object
        const transaction = {
            id: generateID(),
            text: text.value,
            amount: Number(amount.value),
        }
        // push into array
        transactions.push(transaction);
        // display in list
        displayTransaction(transaction);
        // update interface
        updateValues();
        // update Local Storage
        updateLocalStorage();
        // clear input
        text.value = "";
        amount.value = "";
    }
}

// Generate random ID
function generateID() {
    return Math.floor(Math.random() * 1000000);
}

// Display transaction in interface list
function displayTransaction(transaction) {
    // get plus or minus
    const sign = transaction.amount < 0 ? "-" : "+";
    // create list item
    const listItem = document.createElement("li");
    // add class
    listItem.classList.add(transaction.amount < 0 ? "minus" : "plus");
    // add amount
    listItem.innerHTML = `
        ${transaction.text} <span>${sign}${Math.abs(transaction.amount)}</span>
        <button class="delete-button" onclick="removeTransaction(${transaction.id})">x</button>
    `;
    // add to interface list
    list.appendChild(listItem);
}

// Remove transaction
function removeTransaction(id) {
    // filter out transaction by ID
    transactions = transactions.filter(transaction => transaction.id !== id);
    // update Local Storage
    updateLocalStorage();
    // re-initialize application
    initializeApplication();
}

// Update Local Storage
function updateLocalStorage() {
    // store transactions array
    localStorage.setItem("transactions", JSON.stringify(transactions));
}

// Initialize application
function initializeApplication() {
    // clear interface list
    list.innerHTML = "";
    // loop through transactions
    transactions.forEach(displayTransaction);
    // update interface
    updateValues();
}

// Update balance, income and expense
function updateValues() {
    // get amounts
    const amounts = transactions.map(transaction => transaction.amount);
    // get total
    // by adding all values together
    // and two decimal places
    const total = amounts
        .reduce((accumulator, item) => (accumulator += item), 0)
        .toFixed(2);
    // get income
    // by filtering all positive values
    // and adding them together
    // and two decimal places
    const income = amounts
        .filter(item => item > 0)
        .reduce((accumulator, item) => (accumulator += item), 0)
        .toFixed(2);
    // get expense
    // by filtering all negative values
    // and adding them together
    // and making result negative
    // and two decimal places
    const expense = (amounts
        .filter(item => item < 0)
        .reduce((accumulator, item) => (accumulator += item), 0)
        * -1)
        .toFixed(2);
    // display in interface
    balance.innerText = `$${total}`;
    moneyPlus.innerText = `$${income}`;
    moneyMinus.innerText = `$${expense}`;
}



// EVENT LISTENERS

// Add transaction
form.addEventListener("submit", addTransaction);


// CALLS
initializeApplication();
const container = document.getElementById('container');
const loginBtn = document.getElementById('login');
const registerBtn = document.getElementById('register');

registerBtn.addEventListener('click', () => {
    container.classList.add('active');
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
});
