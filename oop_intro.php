<?php
class Person {
    public $name;
    public $gender;
    public $email;
    public $password;

    public function greet() {
        return "Hello, my name is " . $this->name;
    }

    public function eat() {
        return $this->name . " is eating";
    }

    public function getAge() {
        return $this->name . " is " . $this->age . " years old";
    }

    public function __construct($name, $email, $gender)
    {
        $this->name = $name;
        $this->email = $email;
        $this->gender = $gender;
    }

    public function loginUser($email, $password) {
        if ($this->email === $email && $this->password === $password) {
            return "You are now logged in";
        } else {
            return "Your email or password is incorrect";
        }
        // hash password, encrypt password
    }
}

class Employee extends Person {
    private string $position;
    private float $salary;
    public string $employmentStatus;
    private string $employmentType;

    public function __construct($name, $email, $gender, $position, $salary, $employmentStatus = "Employed", $employmentType = "Full-time")
    {
        parent::__construct($name, $email, $gender);
        $this->position = $position;
        $this->salary = $salary;
        $this->employmentStatus = $employmentStatus;
        $this->employmentType = $employmentType;
    }

    public function getSalary() {
        return $this->salary;
    }

    public function work() {
        return $this->name . " is working";
    }

    public function attendMeeting() {
        return $this->name . " is attending a meeting";
    }

    public function applyLeave() {
        return $this->name . " is applying for leave";
    }

    public function takeBreak() {
        return $this->name . " is taking a break";
    }

    public function loginUser($email, $password)
    {
        if ($this->email === $email && $this->password === $password) {
            if ($this->employmentStatus === "Employed") {
                return "You are now logged in";
            } else {
                return "Please contact HR for assistance";
            }
        } else {
            return "Your email or password is incorrect";
        }
    }
}

$employee1 = new Employee("John Doe", "john.doe@email.com", "male", "Software Developer", 50000);
$employee1->password = "password";

echo $employee1->loginUser("john.doe@email.com", "password") . "\n";

$employee2 = new Employee("Jane Doe", "jane.doe@email.com", "female", "Software Developer", 50000, "Resigned");
$employee2->password = "password";

echo $employee2->loginUser("jane.doe@email.com", "password") . "\n";



