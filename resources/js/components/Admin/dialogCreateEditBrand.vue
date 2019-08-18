<template>
  <v-card>
      <v-toolbar color="transparent" flat>
            <v-toolbar-title class="headline">
                {{ !!brandId? 'Ubah Brand' : 'Brand Baru'}}
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="$emit('close')">
                <v-icon>close</v-icon>
            </v-btn>
        </v-toolbar>
        <v-card-text v-if="dialogLoading" class="text-xs-center">
            <v-progress-circular
                :size="70"
                :width="7"
                color="primary"
                indeterminate
            ></v-progress-circular>
        </v-card-text>
        <v-form ref="form_new_brand" @submit.prevent="createNewBrand" v-show="!dialogLoading">
            <v-card-text>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-text-field
                            label="Nama Brand"
                            v-model="name"
                            :rules="[rules.required]"
                            ref="name"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-container>     
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" large type="submit" :loading="btnLoading">
                    <v-icon left>
                        {{ !!brandId? 'save' : 'add'}}
                    </v-icon>
                    {{ !!brandId? 'simpan' : 'buat brand'}}
                </v-btn>
            </v-card-actions>
        </v-form>
  </v-card>
</template>

<script>
export default {
    props:{
        brandId:{
            type: Number,
            required: true,
        },
    },
    data: ()=> ({
        dialogLoading: true,
        btnLoading: false,
        name:null,

        rules: {
            required: v => !!v || 'Harus Disi',

        },
    }),

    methods: {
        async createNewBrand() {

            if(this.$refs.form_new_brand.validate()){
                this.btnLoading = true;
                try {
                    if(!this.brandId){
                        const res = await axios.post('/api/products', {
                            name: this.name,
                        })
                        alert("Brand Berhasil dibuat");
                    }else{
                        const res = await axios.patch(`/api/products/${this.brandId}`,{
                            name: this.name,
                        })
                        alert("Brand Berhasil diubah");
                    }
                    this.$emit('create_success');
                } catch(err){
                    console.log(err);
                }
            }
        },
    },

    async mounted(){
        if(!!this.brandId){
            const res = await axios.get(`/api/products/${this.brandId}`)
            this.name = res.data.name
        }
        this.dialogLoading = false;
        this.$nextTick(()=> this.$refs.name.focus());
    }

}
</script>
