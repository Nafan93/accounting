<template>
    <div class="uk-container">
        <div class="uk-width-1-1">
            <div class="uk-card">
                <div class="uk-card-header uk-flex uk-flex-middle uk-flex-between">
                    <h3 class="uk-card-title uk-margin-remove">Мои компании</h3>
                    <div>
                        <button
                            class="uk-button uk-button-primary"
                            type="button"
                            uk-toggle="target: #addNew"
                        >
                            Создать компанию
                        </button>
                    </div>
                </div>

                <div class="card-body table-responsive p-0">
                    <table class="uk-table">
                        <tbody>
                            <tr>
                                <th>Название</th>
                                <th>Директор</th>
                                <th>ИНН</th>
                                <th>КПП</th>
                                <th>Юредический адрес</th>
                            </tr>

                            <tr v-for="company in user.companies" :key="company.id">
                                <td>
                                    <router-link :key="company.id" :to="{ name: 'showCompany', params: { companyID: company.id, userID: user.id}}" >{{ company.name }}</router-link>
                                    
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
                            Создать компанию
                        </h5>
                    </div>
                        <form >
                            <div class="uk-margin">
                                <input type="text" name="company_inn" v-model="company_inn" class="uk-input" placeholder="Введите ИНН для поиска" @change="setCompany()">
                                <div class="uk-margin">
                                    <span v-if="company_exist == true" class="uk-text-success">Клиент с таким ИНН уже существует</span>
                                    <span v-if="company_inn_error == true" class="uk-text-danger">Введите корректный ИНН</span>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_name" placeholder="Название организации" readonly>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_kpp" placeholder="КПП организации" readonly>
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_legal" placeholder="Юридический адрес организации" readonly> 
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_director" placeholder="Директор оганизации" readonly>
                            </div>
                            <h5>Банковские реквизиты</h5>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_bank_rs" placeholder="Расчетный счет">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_bank_bic" placeholder="БИК банка" @change="setBank()">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_bank_ks" placeholder="Кор. счет">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_bank_name" placeholder="Наименование банка">
                            </div>
                            <div class="uk-margin">
                                <input type="text" class="uk-input" v-model="company_bank_legal" placeholder="Адрес банка">
                            </div>
                        </form>
                    
                    <div class="uk-modal-footer">
                          <button
                              type="button"
                              class="uk-button uk-button-danger"
                              data-dismiss="modal"
                              @click="closeaddcompany()"
                          >
                              Close
                          </button>
                      
                          <button
                              type="submit"
                              class="uk-button uk-button-primary"
                              @click="createCompany()"
                              v-show="!company_exist"
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
    props: ['userID'],
    data() {
        return {
            editMode: false,
            user: {},
            token: process.env.MIX_DADATA_API_KEY,
            form: new Form({
                id: "",
                name: "",
                full_name: "",
                director_name: "",
                inn: "",
                kpp: "",
                legal_addres: "",
            }),
            company_exist: false,
            company_inn_error: false,
            company_inn: '',
            company_name: '',
            company_kpp: '',
            company_legal: '',
            company_director: '',
            company_director_post: '',
            company_full_name: '',
            company_bank_bic: '',
            company_bank_name: '',
            company_bank_rs: '',
            company_bank_ks: '',
            company_bank_legal: '',
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

        loadCompany() {
            axios.get("/api/user/" + this.userID).then(data => (this.user = data.data));

            //pick data from controller and push it into users object
        },

        createCompany() {
            this.$Progress.start();

            const formData = new FormData()
            formData.append('user_id', this.userID)
            formData.append('name', this.company_name)
            formData.append('full_name', this.company_full_name)
            formData.append('director_name', this.company_director)
            formData.append('director_post', this.company_director_post)
            formData.append('inn', this.company_inn)
            formData.append('kpp', this.company_kpp)
            formData.append('legal_addres', this.company_legal)
            formData.append('bank', this.company_bank_name)
            formData.append('bic', this.company_bank_bic)
            formData.append('ks', this.company_bank_ks)
            formData.append('rs', this.company_bank_rs)
            axios
                .post('/api/user/' + this.userID + '/company', formData)
                .then((res) => {
                    if(res.status === 200) {
                        
                        console.log(res.data);
                        
                        UIkit.modal("#addNew").hide();
                        this.loadCompany();
                    }
                })
            this.$Progress.finish()
            //this.loadUsers();
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
        },
        setCompany(){
            this.company_exist = false
            this.company_inn_error = false
            let url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party";
            let query = this.company_inn;
            let companies = this.user.companies

            for (let i = 0; i < companies.length; i++) {
                if (query == companies[i].inn) {
                    this.company_exist = true
                    break
                } 
            }
            var options = {
                method: "POST",
                mode: "cors",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Token " + this.token
                    },
                body: JSON.stringify({query: query})
            }
            if(this.company_exist === false && query != 0) {
                fetch(url, options)
                    .then(response => response.json())
                    .then( result => {
                        if (result.suggestions.length == 0) {
                            this.company_inn_error = true
                        } else {
                            this.company_name = result.suggestions[0].value
                            this.company_kpp = result.suggestions[0].data.kpp
                            this.company_legal = result.suggestions[0].data.address.unrestricted_value
                            this.company_director = result.suggestions[0].data.management.name
                            this.company_director_post = result.suggestions[0].data.management.post
                            this.company_full_name = result.suggestions[0].data.name.full_with_opf 
                        }
                        
                    })
                    .catch(error => console.log("error", error));
                }
            
                    
        },
        setBank() {
            var url = "https://suggestions.dadata.ru/suggestions/api/4_1/rs/suggest/bank";
            var query = this.company_bank_bic;

            var options = {
                method: "POST",
                mode: "cors",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "Authorization": "Token " + this.token
                },
                body: JSON.stringify({query: query})
            }

            fetch(url, options)
                .then(response => response.json())
                .then(result => {
                    this.company_bank_name = result.suggestions[0].data.name.payment
                    this.company_bank_ks = result.suggestions[0].data.correspondent_account
                    this.company_bank_legal = result.suggestions[0].data.address.value
                    })
                .catch(error => console.log("error", error));
        },
    },

    created() {
        this.loadCompany();

        Fire.$on("AfterCreatedUserLoadIt", () => {
            //custom events fire on
            this.loadCompany();
        });
    }
};
</script>