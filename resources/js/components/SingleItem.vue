<template>
    <div class="container mb-3">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card" v-if="!item.last_one">
                    <div class="card-header">{{ item.title }} <small right>{{ item.created_at }}</small> </div>
                    <div class="card-body">
                        <img v-bind:src="item.image" alt="" width="100">
                    </div>
                    <div class="card-body">
                        {{ item.description }}
                    </div>
                </div>
                <div class="card" v-else>
                    <div class="card-body text-center">
                        No more posts! Put some content 📝
                        <a href="#add_item_div">tap here to add new post</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["item"]
    }
</script>
