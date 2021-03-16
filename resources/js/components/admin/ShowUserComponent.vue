<template>
    <div>

    </div>
</template>

<script>
export default {
    props: ['userID'], 
    data() {
        return {
            companies: {},
        };
    },
    methods: {
        loadCompanies() {
            axios.get("api/company").then(data => (this.companies = data.data));
        },
    },
    created() {
        this.loadCompanies();
    }
}
</script>

<style>

</style>