<template>
    <div class="card">
        <div class="card-header">All items</div>
        <div class="card-body">
            <SingleItem v-for="(item, k) in items" :item="item" :key="k"></SingleItem>
        </div>
    </div>
</template>

<script>
    import SingleItem from "../components/SingleItem.vue";
    import AddItem from "../components/AddItem.vue";
    export default {
        components: {
            SingleItem,
            AddItem
        },
        data(){
            return {
                items: []
            }
        },
        methods: {
            get_items() {
                let vm = this;
                axios
                    .get("api/items")
                    .then((res)=>{
                        vm.items = res.data;
                        console.log(res);
                    })
            }
        },
        created(){
            this.get_items();
        }
    }
</script>
