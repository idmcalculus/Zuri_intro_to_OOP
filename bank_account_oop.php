<?php

class BankAccount {
    protected float $balance;
    protected array $transactions;

    public function __construct(float $initialBalance)
    {
        $this->balance = $initialBalance;
        $this->transactions = [];
        echo "Account created with balance: $initialBalance\n";
    }

    // Function to deposit money into the bank account
    public function deposit($amount): void
    {
        if ($this->validateAmount($amount)) {
            $this->balance += $amount;
            $this->addTransaction("Deposit", $amount);
            echo "Deposited: $amount\n";
        } else {
            echo "Invalid deposit amount\n";
        }
    }

    // Function to withdraw money from the bank account
    public function withdraw($amount): void
    {
        if ($this->validateAmount($amount) && $amount <= $this->balance) {
            $this->balance -= $amount;
            $this->addTransaction("Withdrawal", $amount);
            echo "Withdrew: $amount\n";
        } else {
            echo "Invalid withdrawal amount or insufficient funds\n";
        }
    }

    public function checkBalance(): float {
        return $this->balance;
    }

    protected function validateAmount($amount): bool
    {
        return is_numeric($amount) && $amount > 0;
    }

    // Function to add a transaction to the transaction history
    protected function addTransaction($type, $amount): void
    {
        $this->transactions[] = [
            'type' => $type,
            'amount' => $amount,
            'date' => date("Y-m-d H:i:s")
        ];
    }

    // Function to print the transaction history
    public function printTransactionHistory(): void
    {
        if (empty($this->transactions)) {
            echo "No transactions found\n";
            return;
        }

        echo "Transaction History:\n";
        foreach ($this->transactions as $transaction) {
            echo "{$transaction['date']} - {$transaction['type']}: {$transaction['amount']}\n";
        }
    }
}

class SavingsAccount extends BankAccount {
    private float $interestRate;

    public function __construct(float $initialBalance, float $interestRate)
    {
        parent::__construct($initialBalance);
        $this->interestRate = $interestRate;
    }

    public function addInterest(): void
    {
        $interest = $this->balance * $this->interestRate / 100;
        $this->deposit($interest);
        echo "Added interest: $interest\n";
    }
}

class CheckingAccount extends BankAccount {
    private float $transactionFee;
    private float $overdraftLimit;

    public function __construct(float $initialBalance, float $transactionFee, float $overdraftLimit)
    {
        parent::__construct($initialBalance);
        $this->transactionFee = $transactionFee;
        $this->overdraftLimit = $overdraftLimit;
    }

    public function deductFees(): void
    {
        $this->withdraw($this->transactionFee);
        echo "Deducted transaction fee: $this->transactionFee\n";
    }

    public function withdraw($amount): void
    {
        if ($this->validateAmount($amount) && $amount <= $this->balance + $this->overdraftLimit) {
            $this->balance -= $amount;
            $this->addTransaction("Withdrawal", $amount);
            if ($this->balance < 0) {
                $this->deductFees();
            }
            echo "Withdrew: $amount\n";
        } else {
            echo "Invalid withdrawal amount or insufficient funds\n";
        }
    }
}

function userMenu(BankAccount $bankAccount): void
{
    while (true) {
        echo "\nBank Account Menu:\n";
        echo "1. Check Balance\n";
        echo "2. Deposit Money\n";
        echo "3. Withdraw Money\n";
        echo "4. Print Transaction History\n";
        echo "5. Apply Interest (Savings Account Only)\n";
        echo "6. Exit\n";
        echo "Choose an option: ";
        $choice = trim(fgets(STDIN));

        switch ($choice) {
            case '1':
                echo "Current balance: " . $bankAccount->checkBalance() . "\n";
                break;
            case '2':
                echo "Enter deposit amount: ";
                $amount = trim(fgets(STDIN));
                $bankAccount->deposit($amount);
                break;
            case '3':
                echo "Enter withdrawal amount: ";
                $amount = trim(fgets(STDIN));
                $bankAccount->withdraw($amount);
                break;
            case '4':
                $bankAccount->printTransactionHistory();
                break;
            case '5':
                if ($bankAccount instanceof SavingsAccount) {
                    if (method_exists($bankAccount, 'addInterest')) {
                        $bankAccount->addInterest();
                    } else {
                        echo "This option is only available for Savings Account\n";
                    }
                } else {
                    echo "This option is only available for Savings Account\n";
                }
                break;
            case '6':
                echo "Exiting...\n";
                exit;
            default:
                echo "Invalid option. Please try again.\n";
        }
    }
}

// $bankAccount = new SavingsAccount(1000, 5);

$currentAccount = new CheckingAccount(50000, 1.5, 200);

userMenu($currentAccount);