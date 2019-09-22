<template>
  <div class="card">
    <div class="card-header">Add new item</div>
    <div class="card-body">
      <div>
        <label for="Item_title">Title</label>
        <br />
        <input type="text" placeholder="Type your title.." v-model="item.title" />
      </div>
      <br />
      <!-- 
                            TO FIX
                            ------
                            <div>
                            <label for="Item_image">Upload your image</label><br>
                            <input type="file" accept=".png,.gif,.jpeg" @change="choose_image">
                        </div>
      <br>-->
      <div>
        <label for="Item_image">Describe your item</label>
        <br />
        <textarea v-model="item.description" placeholder="Type your description here.."></textarea>
      </div>
    </div>
    <div class="card-body">
      <button class="btn btn-primary" @click="send_item">Get Items</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      item: {
        title: "",
        description: ""
      }
    };
  },
  methods: {
      send_item(){
          if(this.validate_item(this.item)){
              axios
                .get("api/add_item", this.item)
                .then(res=>{
                    console.log(res);
                })
                .catch(err=>{
                    console.log(err);
                })
          }else {
              alert("Please fill the fields");
          }
      },
      validate_item(item){
          return item.title.length > 0 && item.description.length > 0;
      }
  }
};
</script>
