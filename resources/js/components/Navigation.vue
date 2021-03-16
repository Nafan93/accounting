<template>
   <div>
        <button class="uk-button uk-button-default uk-margin-small-right" type="button" uk-toggle="target: #navigation">Меню</button>
        <div id="navigation" uk-offcanvas>
            <div class="uk-offcanvas-bar">
                <button class="uk-offcanvas-close" type="button" uk-close></button>
                <ul uk-accordion>
                    <li>
                        <a class="uk-accordion-title" href="#">Продажи</a>
                        <ul class="uk-accordion-content uk-open" style="list-style-type: none">
                            <li ><router-link :key="company" :to="{ name: 'Invoice', params: { companyID: company, userID: user}}" >Счета</router-link></li>
                            <li><router-link :key="company" :to="{ name: 'AcceptanceCertificate', params: { companyID: company }}" >Акты</router-link></li>
                            <li><a href="">Товарные накладные</a></li>
                            <li><a href="">Товарно-траспортные накладные</a></li>
                            <li><a href="">Счета-фактуры</a></li>
                            <li><a href="">УПД</a></li>
                            <li><a href="">Заказы</a></li>
                            <li><a href="">Договоры</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="uk-accordion-title" href="#">Покупки</a>
                        <ul class="uk-accordion-content uk-open" style="list-style-type: none">
                            <li><a href="">Счета</a></li>
                            <li><a href="">Акты</a></li>
                            <li><a href="">Товарные накладные</a></li>
                            <li><a href="">Товарно-траспортные накладные</a></li>
                            <li><a href="">Счета-фактуры</a></li>
                            <li><a href="">УПД</a></li>
                            <li><a href="">Заказы</a></li>
                            <li><a href="">Договоры</a></li>
                        </ul>
                    </li>
                    <li>
                        <a class="uk-accordion-title" href="#">Товары</a>
                        <ul class="uk-accordion-content uk-open" style="list-style-type: none">
                            <li><a href="">Склад</a></li>
                            <li><a href="">Прайс-листы</a></li>
                            <li><a href="">Оборот товара</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
   </div>
</template>



<script>
export default {
    props: ['company', 'user'], 
    data() {
        return {
            
        }
    },
   
}
</script>

<style>

</style>