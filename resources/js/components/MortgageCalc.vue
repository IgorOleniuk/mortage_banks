<template>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header banks-card-header">
                        <span>Mortgage Calculator</span>
                    </div>

                    <div class="card-body">
                        <div v-if="errors.length">
                            <b>Please correct the following error(s):</b>
                            <ul class="error-messages-list">
                                <li v-for="error in errors" class="error-message">{{ error }}</li>
                            </ul>
                        </div>

                        <select
                            v-model="formData.selectedBank"
                            class="custom-select my-3"
                            aria-label=">Choose a bank"
                        >
                            <option disabled>Choose a bank</option>
                            <option
                                v-for="bank in banks"
                                :key="bank.id"
                                :value="bank"
                            >
                                {{ bank.bank_name }}
                            </option>
                        </select>
                        <div class="row">
                            <div class="form-group col-6">
                                <label
                                    for="initial_loan"
                                >
                                    Initial loan
                                </label>
                                <input
                                    v-model="formData.initial_loan"
                                    type="number"
                                    class="form-control"
                                    name="initial_loan"
                                    id="initial_loan"
                                    placeholder="Example: 100000"
                                    required
                                >
                            </div>
                            <div class="form-group col-6">
                                <label
                                    for="down_payment"
                                >
                                    Down payment
                                </label>
                                <input
                                    v-model="formData.down_payment"
                                    type="number"
                                    class="form-control"
                                    name="down_payment"
                                    id="down_payment"
                                    placeholder="Example: 10000"
                                    required
                                >
                            </div>
                        </div>
                        <div>
                            <button
                                class="btn btn-primary my-3"
                                @click="calculateMortgage"
                            >
                                Calculate mortgage
                            </button>
                            <button
                                class="btn btn-dark my-3 ml-3"
                                @click="resetCalculator"
                            >
                                Clear
                            </button>
                        </div>
                        <p v-if="monthlyPayment">
                            Your monthly mortgage in <i>{{ this.formData.selectedBank.bank_name }}</i> is going to be: <b>{{ monthlyPayment }}</b>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            banks: [],
            formData: {
                initial_loan: null,
                down_payment: null,
                selectedBank: 'Choose a bank'
            },
            monthlyPayment: null,
            errors: []
        }
    },

    mounted() {
        this.getAllBanks();
    },

    methods: {
        getAllBanks() {
            axios.get('/api/banks')
                .then((res) => {
                    this.banks = res.data.data;
                })
                .catch((e) => {
                    console.log(e);
                });
        },

        validateCalculator() {
            this.errors = [];

            if (!this.formData.down_payment || !this.formData.initial_loan || !this.formData.selectedBank) {
                this.errors.push('Fill your Loan, Down Payment information and choose a bank');
            } else if (this.formData.initial_loan > this.formData.selectedBank.max_loan) {
                this.errors.push(`The max loan for - ${this.formData.selectedBank.bank_name} is ${this.formData.selectedBank.max_loan}. Please, enter a smaller Initial loan`);
            } else if (this.formData.down_payment < this.formData.selectedBank.min_down_payment) {
                this.errors.push(`The minimum down payment for - ${this.formData.selectedBank.bank_name} is ${this.formData.selectedBank.min_down_payment}.  Please, enter a greater Down payment`);
            } else {
                this.errors = [];
            }
        },

        calculateMortgage() {
            this.validateCalculator();

            if (!this.errors.length) {
                let value = 0;
                // principal amount to borrow (loan - down payment)
                let loanAmount = this.formData.initial_loan - this.formData.down_payment;
                // monthly interest rate
                let monthlyInterestRate = (this.formData.selectedBank.interest_rate / 12) / 100;
                // the number of payments over the life of the loan in months
                let numberOfMonthlyPayments = this.formData.selectedBank.loan_term * 12;

                // calculate the monthly payment
                value = (loanAmount * monthlyInterestRate * Math.pow((1 + monthlyInterestRate), numberOfMonthlyPayments)) / (Math.pow((1 + monthlyInterestRate), numberOfMonthlyPayments) - 1);
                this.monthlyPayment = Math.round(value * 100) / 100;

                axios.post(`/api/banks/${this.formData.selectedBank.id}/create/bank-loan-history`, {
                    'initial_loan': this.formData.initial_loan,
                    'down_payment': this.formData.down_payment,
                    'monthly_payment': this.monthlyPayment,
                    'interest_rate':  this.formData.selectedBank.interest_rate,
                    'loan_term': this.formData.selectedBank.loan_term
                })
                    .then(() => {
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            }
        },

        resetCalculator() {
            this.errors = [];
            this.monthlyPayment = null;
            this.formData = {
                initial_loan: null,
                down_payment: null,
                selectedBank: 'Choose a bank'
            }
        }
    }
}
</script>
