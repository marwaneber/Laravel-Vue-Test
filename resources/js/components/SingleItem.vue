<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ item.title }}</div>
                    <div class="card-body">
                        <img v-bind:src="item.image" alt="" width="100">
                    </div>
                    <div class="card-body">
                        {{ item.description }}
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
