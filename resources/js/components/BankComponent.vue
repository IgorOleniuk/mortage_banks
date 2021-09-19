<template>
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header banks-card-header">
                        <span>Banks</span>
                        <button
                            class="btn btn-primary"
                            @click="openModel('create')"
                        >
                            Create Bank
                        </button>
                    </div>

                    <div class="card-body">
                        <ul class="items-list">
                            <li
                                v-for="bank in banks"
                                :key="bank.id"
                                class="list-item"
                            >
                                <a :href="'/' + bank.id + '/loan-history'">{{ bank.bank_name }}</a>
                                <div>
                                    <i
                                        class="bi bi-pencil-fill"
                                        @click="openModel('edit', bank)"
                                    >
                                    </i>
                                    <i
                                        class="bi bi-trash-fill"
                                        @click="openModel('delete', bank)"
                                    >
                                    </i>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- The popup for creating/editing/deleting brands -->
        <div
            class="modal"
            id="bankModal"
            tabindex="-1"
            role="dialog"
            data-keyboard="false"
            data-backdrop="static"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modalTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span
                                aria-hidden="true"
                                @click="closeModal"
                            >
                                &times;
                            </span>
                        </button>
                    </div>
                    <div class="modal-body" v-if="!deleteModal">
                        <div v-if="errorMessages">
                            <ul
                                class="error-messages-list"
                            >
                                <li
                                    v-for="(error, i) in errorMessages"
                                    :key="i"
                                    class="error-message"
                                >
                                    {{ error[0] }}
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label
                                for="name"
                            >
                                Bank Name
                            </label>
                            <input
                                v-model="formData.bank_name"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                placeholder="Enter bank name"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label
                                for="interest_rate"
                            >
                                Interest rate, %
                            </label>
                            <input
                                v-model="formData.interest_rate"
                                type="number"
                                class="form-control"
                                min="0"
                                maxlength="100"
                                step="0.1"
                                name="interest_rate"
                                id="interest_rate"
                                placeholder="Example: 5.5"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label
                                for="max_loan"
                            >
                                Maximum loan
                            </label>
                            <input
                                v-model="formData.max_loan"
                                type="number"
                                class="form-control"
                                name="max_loan"
                                id="max_loan"
                                placeholder="Example: 100000"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label
                                for="min_down_payment"
                            >
                                Minimum down payment
                            </label>
                            <input
                                v-model="formData.min_down_payment"
                                type="number" class="form-control"
                                name="min_down_payment"
                                id="min_down_payment"
                                placeholder="Example: 10000"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label
                                for="loan_term"
                            >
                                Loan term, years
                            </label>
                            <input
                                v-model="formData.loan_term"
                                type="number"
                                class="form-control"
                                name="loan_term"
                                id="loan_term"
                                placeholder="Years"
                                required
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            v-if="deleteModal"
                            type="button"
                            class="btn btn-danger"
                            @click="deleteBank"
                        >
                            Delete
                        </button>
                        <button
                            v-else
                            type="button"
                            class="btn btn-primary"
                            @click="saveBank"
                        >
                            Save
                        </button>
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal"
                            @click="closeModal"
                        >
                            Close
                        </button>
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
                modalTitle: '',
                deleteModal: false,
                bankId: null,
                formData: {
                  bank_name: '',
                  interest_rate: null,
                  max_loan: null,
                  min_down_payment: null,
                  loan_term: null
                },
                errorMessages: null,
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

            openModel(type, bank = []) {
                if (type === 'edit') {
                    this.modalTitle = 'Edit bank';
                    this.formData = bank;
                } else if (type === 'create') {
                    this.modalTitle = 'Create a bank';
                } else if (type === 'delete') {
                    this.modalTitle = 'Are you sure you want to delete this bank?';
                    this.deleteModal = true;
                }

                $('#bankModal').modal('show');
                this.bankId = bank.id;
            },

            closeModal() {
                $('#bankModal').modal('hide');
                this.formData = {
                    bank_name: '',
                    interest_rate: null,
                    max_loan: null,
                    min_down_payment: null,
                    loan_term: null
                };
                this.errorMessages = null;
                this.deleteModal = false;
            },

            saveBank() {
                let url = '/api/banks/create/bank';
                if (this.bankId) {
                    url = `/api/banks/update/bank/${this.bankId}`;
                }

                axios.post(url, {
                    bank: this.formData
                })
                    .then(() => {
                        this.getAllBanks();
                        this.closeModal();
                        this.$toast.success('The bank was saved', 'Success', {
                            timeout: 2000,
                            position: 'bottomRight'
                        });
                    })
                    .catch((e) => {
                        if (e.response.status === 422) {
                            this.errorMessages = e.response.data.errors;
                        }
                        console.log(e);
                    });
            },

            deleteBank() {
                axios.delete('/api/banks/delete/bank/' + this.bankId)
                    .then(() => {
                        this.getAllBanks();
                        this.closeModal();
                        this.$toast.success('Bank was deleted successfully', 'Success', {
                            timeout: 2000,
                            position: 'bottomRight'
                        });
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            },
        }
    }
</script>
