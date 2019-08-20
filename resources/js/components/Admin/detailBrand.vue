<template>
    <v-container grid-list-lg>
        <v-layout row wrap>
            <div class="ml-4">
                    <v-img
                    :src="image"
                    :aspect-ratio="16/9"                    
                    ></v-img>
                    <div class="headline font-weight-bold mb-1">Brand {{ name }}</div>
                </div>
        </v-layout>

        <v-container grid-list-lg>
            <v-layout row align-center class="mt-2 mb-3">
                <div class="subheading font-weight-bold">
                    List Credits
                </div>
                <v-spacer></v-spacer>
                <v-btn color="primary" dark class="mb-2" @click="openCreditDialog">+ Tambah Credit</v-btn>
            </v-layout>
            <v-layout align-center justify-space-around row fill-height>
            <v-flex xs12 md6 xl4 v-for="(item, i) in productCredits" :key="`am-${i}`">
                <v-card class="rounded" height="100%">
                    <div>
                    <v-img
                    :src="item.image"
                    :aspect-ratio="16/9"
                    ></v-img>
                    </div>
                    <v-spacer></v-spacer>
                    <v-card-text class="text-xs-center">
                        <div class="subheading">{{item.amount}}</div>
                    </v-card-text>
                    <v-card-actions>
                     <v-spacer></v-spacer>
                        <v-btn round color="error" dark @click="deleteCredit(item.id)">Delete</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
        <v-dialog v-model="dialogCreateEditCredit"
    persistent max-width="600px"
    >
    <dialog-create-edit-credit
    :creditId = "parseInt(creditId)"
    :brand = "parseInt(brand)"
    @close="closeCredit"
    @create_success="reloadCredit"
    :key="dialogCreateEditCreditKey"
    >
    </dialog-create-edit-credit>

    </v-dialog>
        </v-container>
    </v-container>
  
</template>

<script>
import dialogCreateEditCredit from './dialogCreateEditCredit'
export default {

    components:{
        dialogCreateEditCredit,
    },
    props:{
        brand: {
            type: String,
            require: true,
        },
    },
    data:() => ({
            creditId: 0,
            name: "",
            image: "",
            amount: "",
            qr_strings: "",
            dialogCreateEditCredit: false,
            dialogCreateEditCreditKey: 0,
            productCredits: [],
        }),
    methods: {
            fetchBrandDetail(){
                return axios.get(`/api/products/${this.brand}`);
            },
            async getBrandDetail(){
                try{
                    const res = await this.fetchBrandDetail();
                    const brand = res.data;
                    this.name = brand.name;
                    this.productCredits = brand.credits.reverse();
                }catch(err){
                    console.log(err);
                }
            },

            // fetchCredit(){
            //     return axios.get('/api/credits')
            //     },
            // async getCredit(){
            //         try{
            //             const res = await this.fetchCredit();
            //             this.credit = res.data.reverse();
            //         } catch (err) {
            //             console.log(err);
            //         }            
            //     },
            openCreditDialog(){
                this.dialogCreateEditCreditKey = !!this.dialogCreateEditCreditKey? 0 : 1;
                this.dialogCreateEditCredit = true;
            },
            editCredit(id){
                this.creditId = id;
                this.openCreditDialog();
            },
            async deleteCredit(id){
                const willDelete = confirm("Apakah Anda Yakin Ingin Menghapus ini?");
                if(willDelete){
                    try{
                        const res = await axios.delete(`/api/credits/${id}`, null);
                        console.log(res.data);
                        this.getCredit();
                    }catch(err){
                        console.log(err);
                    }
                }
            },
            closeCredit(){
                this.dialogCreateEditCredit = false;
                this.creditId = 0;
            },
            reloadCredit(){
            this.closeCredit();
            this.getCredit();  
            },
        },
    mounted(){
        this.getBrandDetail();
    }, 

}
</script>

<style>

</style>