
<?php
// session_start();
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';
 

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'includes/config.php';
$user_id = $_SESSION['user_id'];

// Fetch user's expenses
$stmt = $pdo->prepare("SELECT * FROM expenses WHERE user_id = ?");
$stmt->execute([$user_id]);
$expenses = $stmt->fetchAll();
?>

 <!-- <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?>! </h1> -->

<!-- Display expenses here -->

<!-- // Inside home.php -->
<h1>Welcome, <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest' ?>!</h1>

<link rel="stylesheet" href="assets/home.css">

<body>
    

<h2>This is your Expense Tracker</h2>


<div class="container">
    <h4>Your Balance</h4>
    <h1 id="balance"> Rs 0.00</h1>

    <div class="inc-exp-container">
        <div>
            <h4>Income</h4>
            <p id="money-plus" class="money plus">+$0.00</p>
        </div>
        <div>
            <h4>Expense</h4>
            <p id="money-minus" class="money minus">-$0.00</p>
        </div>
    </div>

    <h3>History</h3>
    <ul id="list" class="list">
        <li class="minus">
      Cash <span>-$400</span><button class="delete-button">x</button>
    </li>
    </ul>

    <h3>Add new transaction</h3>
    <form id="form">
        <div class="form-control">
            <label for="text">Text</label>
            <input type="text" id="text" placeholder="Enter text..." />
        </div>
        <div class="form-control">
            <label for="amount">Amount <br />
                (negative - expense, positive - income)</label> <br>
            <input type="number" id="amount" placeholder="Enter amount..." />
        </div>
        <button class="button">Add transaction</button>
        
        
        
               
            

    </form>
    <a href="logout.php">Logout</a>

</div>

<script src="assets/home.js"></script>

</body>
