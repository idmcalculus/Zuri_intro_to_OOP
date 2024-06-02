<?php
use JetBrains\PhpStorm\NoReturn;

// Define an associative array to hold the bank account information
$bankAccount = [
    'balance' => 0,
    'transactions' => []
];

// Function to create a bank account
function createAccount(&$account, $initialBalance): void
{
    $account['balance'] = $initialBalance;
    echo "Account created with balance: $initialBalance\n";
}

// Function to deposit money into the bank account
function deposit(&$account, $amount): void
{
    if (validateAmount($amount)) {
        $account['balance'] += $amount;
        addTransaction($account, "Deposit", $amount);
        echo "Deposited: $amount\n";
    } else {
        echo "Invalid deposit amount\n";
    }
}

// Function to withdraw money from the bank account
function withdraw(&$account, $amount): void
{
    if (validateAmount($amount) && $amount <= $account['balance']) {
        $account['balance'] -= $amount;
        addTransaction($account, "Withdrawal", $amount);
        echo "Withdrew: $amount\n";
    } else {
        echo "Invalid withdrawal amount or insufficient funds\n";
    }
}

// Function to check the balance of the bank account
function checkBalance($account): float {
    return $account['balance'];
}

// Function to validate the deposit or withdrawal amount
function validateAmount($amount): bool
{
    return is_numeric($amount) && $amount > 0;
}

// Function to add a transaction to the transaction history
function addTransaction(&$account, $type, $amount): void
{
    $account['transactions'][] = [
        'type' => $type,
        'amount' => $amount,
        'date' => date("Y-m-d H:i:s")
    ];
}

// Function to print the transaction history
function printTransactionHistory($account): void
{
    if (empty($account['transactions'])) {
        echo "No transactions found\n";
        return;
    }

    echo "Transaction History:\n";
    foreach ($account['transactions'] as $transaction) {
        echo "{$transaction['date']} - {$transaction['type']}: {$transaction['amount']}\n";
    }
}

// User interaction function
#[NoReturn] function userMenu(): void
{
    global $bankAccount;

    while (true) {
        echo "\nBank Account Menu:\n";
        echo "1. Check Balance\n";
        echo "2. Deposit Money\n";
        echo "3. Withdraw Money\n";
        echo "4. Print Transaction History\n";
        echo "5. Exit\n";
        echo "Choose an option: ";
        $choice = trim(fgets(STDIN));

        switch ($choice) {
            case '1':
                echo "Current balance: " . checkBalance($bankAccount) . "\n";
                break;
            case '2':
                echo "Enter deposit amount: ";
                $amount = trim(fgets(STDIN));
                deposit($bankAccount, $amount);
                break;
            case '3':
                echo "Enter withdrawal amount: ";
                $amount = trim(fgets(STDIN));
                withdraw($bankAccount, $amount);
                break;
            case '4':
                printTransactionHistory($bankAccount);
                break;
            case '5':
                echo "Exiting...\n";
                exit;
            default:
                echo "Invalid option. Please try again.\n";
        }
    }
}

// Example usage
createAccount($bankAccount, 1000); // Creating account with initial balance
userMenu(); // Interacting with the bank account