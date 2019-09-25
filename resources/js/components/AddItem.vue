<template>
  <div class="card mb-3" id="add_item_div">
    <div class="card-header">Add new item</div>
    <div class="card-body">
      <div>
        <label for="Item_title">Title</label>
        <br />
        <input type="text" class="col-md-4 col-form-label text-md-right" placeholder="Type your title.." v-model="item.title" />
      </div>
      <br />
      <div>
        <label for="Item_image">Upload your image</label><br>
        <input type="file" class="col-md-4 col-form-label text-md-right" accept=".png,.gif,.jpeg" @change="choose_image">
      </div>
      <br>
      <div>
        <label for="Item_image">Describe your item</label>
        <br />
        <textarea v-model="item.description" class="col-md-4 col-form-label text-md-right" placeholder="Type your description here.."></textarea>
      </div>
    </div>
    <div class="card-body text-center">
      <button class="btn btn-primary large" @click="send_item">Add new item</button>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      item: {
        title: "",
        description: "",
        image: ""
      }
    };
  },
  methods: {
      send_item(){
          if(this.validate_item(this.item)){
              axios
                .post("/add", this.item)
                .then(res=>{
                  if(res.status === 200){
                    window.location.reload();
                  }
                    console.log(res.status);
                })
                .catch(err=>{
                    console.log(err);
                });
          }else {
              alert("Please fill the fields");
          }
      },
      validate_item(item){
          return item.title.length > 0 && item.description.length > 0 && item.image.length > 0;
      },
      choose_image(e){
        let image = new FileReader();
        let vm = this;
        image.readAsDataURL(e.target.files[0]);
        image.onload = (res)=>{
          vm.item.image = res.target.result;
        }
        console.log(vm.item);
      }
  }
};
</script>
