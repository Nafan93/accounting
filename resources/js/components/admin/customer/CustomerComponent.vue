<template>
  <div>
     <table class="uk-table">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Director name</th>
                                <th>INN</th>
                                <th>KPP</th>
                                <th>Legal address</th>
                            </tr>

                            <tr v-for="customer in company.customers" :key="customer.id">
                                <td>
                                    <router-link :key="customer.id" :to="{ name: 'showCustomer', params: { customerId: company.id }}" >{{ customer.name }}</router-link>
                                    
                                </td>
                                <td>{{ customer.director_name }}</td>
                                <td>{{ customer.inn }}</td>
                                <td>{{ customer.kpp }}</td>
                                <td>{{ customer.legal_addres }}</td>
                                <td>
                                    <a
                                        href="#"
                                        data-id="customer.id"
                                        @click="editModalWindow(customer)"
                                    >
                                        <span uk-icon="pencil"></span>
                                    </a>
                                    <span>|</span>
                                    <a href="#" @click="deleteCustomer(customer.id)">
                                        <span uk-icon="close"></span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
  </div>
</template>

<script>
export default {
    props: ['companyId'],
    data(){
        return {
            company: {},
        }
    },
    methods: {
        loadCompany(){
            axios.get('/api/company/' + this.companyId).then(data => (this.company = data.data));
        }
    },
    mounted() {
        this.loadCompany();
    }
}
</script>

<style>

</style>