<template>
<div>
  <v-content>
        
      <v-container grid-list-lg class="my-3">
          <v-layout align-center justify-space-around>
              <v-btn color="primary" dark class="mb-2" @click="openBrandDialog">+ Tambah Brand</v-btn>
          </v-layout>
          <v-layout align-center justify-space-around row fill-height>
          <v-flex>
              <p class="headline">List Brands</p>
          </v-flex>
          </v-layout>         
          
        <v-layout align-center justify-space-around row fill-height>
        
            <v-flex xs12 md6 xl4 v-for="(item, id) in brand" :key="`brand-${id}`">
                <v-card class="rounded" height="100%">
                    <div>
                    <v-img
                    :src="item.image"
                    :aspect-ratio="16/9"
                    ></v-img>

                    </div>
                    <v-spacer></v-spacer>
                    
                    <v-card-text class="text-xs-center">{{item.amount}}</v-card-text>
                    <v-card-actions>
                        <v-btn color="indigo" flat around :to="`/admin/brand/${item.id}`">Info</v-btn>
                        <v-spacer></v-spacer>
                         <v-btn round color="error" dark @click="deleteBrand(item.id)">Delete</v-btn>
                         <v-spacer></v-spacer>
                    </v-card-actions>

                </v-card>
            </v-flex>

        </v-layout>
         

        
        <!-- <qrcode value="Rp 25.000" :options="{width: 200}"></qrcode> -->
      </v-container>
    </v-content>
    <v-dialog v-model="dialogCreateEditBrand"
    persistent max-width="600px"
    >
    <dialog-create-edit-brand
    :brandId = "parseInt(brandId)"
    @close="closeBrand"
    @create_success="reloadBrand"
    :key="dialogCreateEditBrandKey"
    >
    </dialog-create-edit-brand>

    </v-dialog>
</div>


</template>

<script>
import dialogCreateEditBrand from './dialogCreateEditBrand'
export default {
     components: {
        dialogCreateEditBrand,

    },

    data:() =>({
        brandId: 0,
        brand: [],
        dialogCreateEditBrand: false,
        dialogCreateEditBrandKey: 0,


    }),

    methods: {
        
        fetchBrand(){
            return axios.get('/api/products')
        },
        async getBrand(){
            try{
                const res = await this.fetchBrand();
                this.brand = res.data.reverse();
            } catch (err) {
                console.log(err);
            }            
        },
        openBrandDialog(){
            this.dialogCreateEditBrandKey = !!this.dialogCreateEditBrandKey? 0 : 1;
            this.dialogCreateEditBrand = true;
        },
        editBrand(id){
            this.standId = id;
            this.openBrandDialog();
        },
        async deleteBrand(id){
            const willDelete = confirm("Apakah Anda Yakin Ingin Menghapus ini?");
            if(willDelete){
                try{
                    const res = await axios.delete(`/api/products/${id}`, null);
                    console.log(res.data);
                    this.getBrand();
                }catch(err){
                    console.log(err);
                }
            }

        },
        closeBrand(){
            this.dialogCreateEditBrand = false;
            this.brandId = 0;
        },
        reloadBrand(){
          this.closeBrand();
          this.getBrand();  
        },
        


    },
    mounted(){
            this.getBrand();
        },

}
</script>

<style>

</style>