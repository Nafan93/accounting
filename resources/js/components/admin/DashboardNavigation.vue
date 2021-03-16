<template>
   <div>
       <div class="uk-navbar-container uk-navbar-transparent" uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo" href="#">Accounting</a>
            </div> 
            <div class="uk-navbar-right">
                <div class="uk-navbar-nav uk-padding-small">
                        <button class="uk-button uk-button-text" type="button">
                            userName
                        </button>
                    </div>
                    
                    <div uk-dropdown="mode: click">
                        <a href="" @click.prevent="logout()">Выйти</a>
                        
                    </div>
            </div>
       </div>
   </div>
</template>

<script>
export default {
    props: ['user'], 
    methods: {
        logout() {
            axios.post('/logout')
                .then(() => location.href = '/')
        }
    },
   
}
</script>

<style>

</style>