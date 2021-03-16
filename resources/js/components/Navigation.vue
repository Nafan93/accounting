<template>
   <div>
       <div class="uk-navbar-container uk-navbar-transparent" uk-navbar>
           <div class="uk-navbar-left">
               <a class="uk-navbar-item uk-logo" href="#">Accounting</a>
               <ul class="uk-navbar-nav">
                    <li>
                        <a href="#">Продажи</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li ><router-link :key="company" :to="{ name: 'Invoice', params: { companyID: company, userID: user}}" >Счета</router-link></li>
                                <li><router-link :key="company" :to="{ name: 'AcceptanceCertificate', params: { companyID: company }}" >Акты</router-link></li>
                                <li><a href="">Товарные накладные</a></li>
                                <li><a href="">Товарно-траспортные накладные</a></li>
                                <li><a href="">Счета-фактуры</a></li>
                                <li><a href="">УПД</a></li>
                                <li><a href="">Заказы</a></li>
                                <li><a href="">Договоры</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#">Покупки</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="">Счета</a></li>
                                <li><a href="">Акты</a></li>
                                <li><a href="">Товарные накладные</a></li>
                                <li><a href="">Товарно-траспортные накладные</a></li>
                                <li><a href="">Счета-фактуры</a></li>
                                <li><a href="">УПД</a></li>
                                <li><a href="">Заказы</a></li>
                                <li><a href="">Договоры</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="#">Покупатели</a>
                    </li>
                    <li>
                        <a href="#">Товары</a>
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                <li><a href="">Склад</a></li>
                                <li><a href="">Прайс-листы</a></li>
                                <li><a href="">Оборот товара</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
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
    props: ['company', 'user'], 
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