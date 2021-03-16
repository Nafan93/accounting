<template>
    <div class="uk-container">
        <div class="uk-width-1-1">
            <div class="uk-card">
                <div class="uk-card-header uk-flex uk-flex-middle uk-flex-between">
                    <h3 class="uk-card-title uk-margin-remove">Company Table</h3>

                    <div>
                        <button
                            class="uk-button uk-button-primary"
                            type="button"
                            uk-toggle="target: #addNew"
                        >
                            Add New
                        </button>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="uk-table">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Director name</th>
                                <th>INN</th>
                                <th>KPP</th>
                                <th>Legal address</th>
                            </tr>

                            <tr v-for="company in companies" :key="company.id">
                                <td>
                                    <router-link :key="company.id" :to="{ name: 'showCompany', params: { companyID: company.id }}" >{{ company.name }}</router-link>
                                    
                                </td>
                                <td>{{ company.director_name }}</td>
                                <td>{{ company.inn }}</td>
                                <td>{{ company.kpp }}</td>
                                <td>{{ company.legal_addres }}</td>
                                <td>
                                    <a
                                        href="#"
                                        data-id="company.id"
                                        @click="editModalWindow(company)"
                                    >
                                        <span uk-icon="pencil"></span>
                                    </a>
                                    <span>|</span>
                                    <a href="#" @click="deleteCompany(company.id)">
                                        <span uk-icon="close"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="uk-card-footer"></div>
            </div>
        </div>

        <div id="addNew"  uk-modal aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical" uk-overflow-auto>
              <button class="uk-modal-close-default" type="button" @click="closeCreateCompany()" uk-close></button>
                <div class="modal-content">
                    <div class="uk-modal-header">
                        <h5 class="modal-title" id="addNewLabel">
                            Создать клиента
                        </h5>
                    </div>
                        <form >
                            <div class="uk-margin">
                                <input type="text" name="customer_inn" v-model="customer_inn" class="uk-input" placeholder="Введите ИНН для поиска" @change="loadCustomer()">
                                <div class="uk-margin">
                                    <span v-if="customer_exist == true" class="uk-text-success">Клиент с таким ИНН уже существует</span>
                                    <span v-if="customer_inn_error == true" class="uk-text-danger">Введите корректный ИНН</span>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_name" placeholder="Название организации" readonly>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_kpp" placeholder="КПП организации" readonly>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_legal" placeholder="Юридический адрес организации" readonly> 
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_director" placeholder="Директор оганизации" readonly>
                            </div>
                            <h5>Банковские реквизиты</h5>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_rs" placeholder="Расчетный счет">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_bic" placeholder="БИК банка" @change="loadBank()">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_ks" placeholder="Кор. счет">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_name" placeholder="Наименование банка">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="customer_bank_legal" placeholder="Адрес банка">
                            </div>
                        </form>
                    
                    <div class="uk-modal-footer">
                          <button
                              type="button"
                              class="uk-button uk-button-danger"
                              data-dismiss="modal"
                              @click="closeaddCustomer()"
                          >
                              Close
                          </button>
                      
                          <button
                              type="submit"
                              class="uk-button uk-button-primary"
                              @click="createCustomer()"
                              v-show="!customer_exist"
                          >
                              Create
                          </button>
                      </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            editMode: false,
            companies: {},
            form: new Form({
                id: "",
                name: "",
                full_name: "",
                director_name: "",
                inn: "",
                kpp: "",
                legal_addres: "",
            })
        };
    },
    methods: {
        editModalWindow(company) {
            this.form.clear();
            this.editMode = true;
            this.form.reset();
            UIkit.modal("#addNew").show();
            this.form.fill(company);
        },
        updateCompany() {
            this.form
                .put("api/company/" + this.form.id)
                .then(() => {
                    Toast.fire({
                        icon: "success",
                        title: "User updated successfully"
                    });

                    Fire.$emit("AfterCreatedUserLoadIt");

                    UIkit.modal("#addNew").hide();
                })
                .catch(() => {
                    console.log("Error.....");
                });
        },
        openModalWindow() {
            this.editMode = false;
            this.form.reset();
            UIkit.modal("#addNew").show();
        },

        loadCompanies() {
            axios.get("api/company").then(data => (this.companies = data.data));

            //pick data from controller and push it into users object
        },

        createCompany() {
            this.$Progress.start();

            this.form
                .post("api/company")
                .then(() => {
                    Fire.$emit("AfterCreatedUserLoadIt"); //custom events

                    Toast.fire({
                        icon: "success",
                        title: "User created successfully"
                    });

                    this.$Progress.finish();
                    this.form.reset();
                    UIkit.modal("#addNew").hide();
                })
                .catch(() => {
                    console.log("Error......");
                });

            this.loadCompany();
        },
        deleteCompany(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then(result => {
                if (result.value) {
                    //Send Request to server
                    this.form
                        .delete("api/company/" + id)
                        .then(response => {
                            Swal.fire(
                                "Deleted!",
                                "User deleted successfully",
                                "success"
                            );
                            this.loadCompanies();
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Something went wrong!",
                                footer: "<a href>Why do I have this issue?</a>"
                            });
                        });
                }
            });
        }
    },

    created() {
        this.loadCompanies();

        Fire.$on("AfterCreatedUserLoadIt", () => {
            //custom events fire on
            this.loadCompanies();
        });
    }
};
</script>
