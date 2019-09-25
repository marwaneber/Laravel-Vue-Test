<template>
    <div class="card" id="all_items_div" v-on:scroll="consol.log('herrr')">
        <div class="card-header">All items</div>
        <div class="card-body">
            <SingleItem  v-for="(item, k) in items" :item="item" :key="k"></SingleItem>
            <div v-show="!complet" class="text-center">
                <img src="../loading.gif" alt="">
            </div>
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
                items: [],
                fetched_data: {},
                last_page: 0,
                current_page: 1,
                complet: false
            }
        },
        methods: {
            get_items() {
                let vm = this;
                axios
                    .get("api/items")
                    .then((res)=>{
                        vm.fetched_data[vm.current_page] = res.data.data;
                        vm.items = [];
                        Object.values(vm.fetched_data).forEach(item => {
                            vm.items = vm.items.concat(item);
                            console.log(vm.fetched_data.length);
                        });
                        vm.last_page = res.data.last_page;
                        console.log(res);
                    });
            },
            load_more() {
                let vm = this;
                let bottom_page = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;
                if(bottom_page && !this.complet){
                    if(this.current_page < this.last_page){
                        console.log(`Fetching data of ${vm.current_page}`);
                        this.current_page++;
                        axios
                        .get("api/items?page="+this.current_page)
                        .then((res)=>{
                            vm.fetched_data[vm.current_page] = res.data.data;
                            vm.loaded = false;
                            setTimeout(()=>{
                                vm.items = [];
                                Object.values(vm.fetched_data).forEach(item => {
                                    vm.items = vm.items.concat(item);
                                    // console.log(vm.fetched_data.length);
                                });
                            }, 1000);
                            vm.loaded = true;
                        })
                    }else {
                        this.items.push({
                            last_one: true
                        });
                        this.complet = true;
                    }
                }else {
                    console.log("Last post");
                }
            }
            
        },
        created(){
            this.get_items();
            window.addEventListener("scroll", this.load_more);  
        }
    }
</script>
