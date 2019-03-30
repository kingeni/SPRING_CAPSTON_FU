package main

import "fmt"

type Account struct {
	name   string
	amount float32
}

func (a *Account) setName(newname string) {
	a.name = newname
	fmt.Println("Your account was change name to: ", a.name)
}

func (a Account) getAmount() {
	fmt.Println("Your account have ", a.amount, " VND")
}
func (a *Account) addFund(number float32) {
	a.amount = a.amount + number
	fmt.Println("Your new ammount are: ", a.amount, " VND")
}
func (a *Account) withdrawMoney(number float32) {
	if a.amount > 50 {
		if a.amount >= number {
			a.amount = a.amount - number
			fmt.Println("Your money after withdraw are:", a.amount)
		} else {
			fmt.Println("Not enought money for withdraw!")
		}

	} else {
		fmt.Println("Your money must be > 50 VND!")

	}

}

var account1 = Account{"a", 100}
var name string
var amount, addamount float32
var i bool = true
var choice int
var newname string

func main() {
	for i == true {
		fmt.Println("________________________")
		fmt.Println("Menu")
		fmt.Println("1: get info for account")
		fmt.Println("2: Withdraw Money")
		fmt.Println("3: Change name for account")
		fmt.Println("4: Add money to your account")
		fmt.Println("________________________")

		fmt.Scanf("%d", &choice)
		switch choice {
		case 1:
			fmt.Println("Account info: ", account1)
		case 2:
			fmt.Println("Input amount money to withdraw: ")
			fmt.Scan(&amount)
			fmt.Println("Withdraw: ", amount)
			account1.withdrawMoney(amount)
		case 3:
			fmt.Println("Input new name: ")
			fmt.Scan(&newname)
			account1.setName(newname)
			fmt.Println("New name for account: ", account1.name)
		case 4:
			fmt.Println("Input amount of money to add: ")
			fmt.Scan(&addamount)
			account1.addFund(addamount)
			// fmt.Println("New amount for your account: ", account1.amount)

		}

	}

	// account1.getAmount()

	// account1.withdrawMoney(22.1)
}
