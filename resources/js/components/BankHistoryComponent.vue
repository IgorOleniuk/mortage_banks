<template>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header banks-card-header">
                        <span>Bank Loans History</span>
                    </div>

                    <div class="card-body">
                        <table v-if="loans.length" class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Initial Loan,$</th>
                                    <th scope="col">Down Payment,$</th>
                                    <th scope="col">Interest Rate,%</th>
                                    <th scope="col">Loan Term,y</th>
                                    <th scope="col">Monthly Payment,$</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="loan in loans"
                                    :key="loans.id"
                                >
                                    <th scope="row">{{ loan.id}}</th>
                                    <td>{{ loan.initial_loan}}</td>
                                    <td>{{ loan.down_payment}}</td>
                                    <td>{{ loan.interest_rate}}</td>
                                    <td>{{ loan.loan_term}}</td>
                                    <td>{{ loan.monthly_payment}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <p v-else class="text-center">There is no loans history yet!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        id: {
            type: Number,
            default: null
        }
    },

    data() {
        return {
            loans: []
        }
    },

    mounted() {
        this.getBankLoans();
    },

    methods: {
        getBankLoans() {
            axios.get(`/api/banks/${this.id}/loan-history`)
                .then((res) => {
                    this.loans = res.data.data;
                })
                .catch((e) => {
                    console.log(e);
                });
        }
    }
}
</script>
