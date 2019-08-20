<template>
  <v-card>
      <v-toolbar color="transparent" flat>
            <v-toolbar-title class="headline">
                {{ !!creditId? 'Ubah Credit' : 'Credit Baru'}}
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
        <v-form ref="form_new_credit" @submit.prevent="createNewCredit" v-show="!dialogLoading">
            <v-card-text>
            <v-container grid-list-lg>
                <v-layout row wrap>
                    <v-flex xs12>
                        <v-text-field
                            label="Jumlah Topup"
                            v-model="amount"
                            :rules="[rules.required, rules.number, rules.notZero, rules.tooMuch]"
                            ref="amount"
                        ></v-text-field>
                    </v-flex>
                    <!-- <v-flex xs12>
                        <v-btn color="primary" flat @click="pickFile">
                            Upload Gambar
                        </v-btn>
                        <v-img class="brand-img"
                        v-if="!!fileUrl"
                        :src="fileUrl"
                        max-height="200px"
                        contain
                        >                            
                        </v-img>
                        <input type="file"
                        ref="file"
                        name="thumbnail"
                        @change="onFileChange(
                            $event.target.name, $event.target.files)"
                            style="display:none">
                    </v-flex> -->
                </v-layout>
            </v-container>     
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" large type="submit" :loading="btnLoading">
                    <v-icon left>
                        {{ !!creditId? 'save' : 'add'}}
                    </v-icon>
                    {{ !!creditId? 'simpan' : 'buat credit'}}
                </v-btn>
            </v-card-actions>
        </v-form>
  </v-card>
</template>

<script>
export default {
    props:{
        brand:{
            type: Number,
            required: true,
        },
       
        creditId:{
            type: Number,
            required: true,
        },
    },
    data: ()=> ({
        dialogLoading: true,
        btnLoading: false,
        name:null,
        amount:null,
        fileUrl: '',

        rules: {
            required: v => !!v || 'Harus Disi',
            number: v => /^[0-9]*$/.test(v) || 'Harus Angka',
            notZero: v => v > 0 || 'Tidak Boleh 0',
            tooMuch: v => v < 9999999 || 'Terlalu Banyak',

        },
    }),
    methods: {

        pickFile(){
            this.$refs.file.click();
        },
        onFileChange(fieldName, file) {
            const { maxSize } = this;
            console.log(fieldName);

            let imageFile = file[0]
            if (file.length > 0){
                let size = imageFile.size / maxSize / maxSize
                if(!imageFile.type.match('image,*')){
                    this.errorText = 'File harus berupa gambar!';
                }else if(size>1){
                    this.errorText = 'Ukuran File harus dibawah 1 MB';
                }else{
                    this.errorText = '';

                    this.fileUrl = URL.createObjectURL(imageFile);
                    this.fileBin = imageFile;
                }
            }

        },
        async createNewCredit() {

            if(this.$refs.form_new_credit.validate()){
                this.btnLoading = true;
                const data = new FormData();
                data.append(`amount`, this.amount);
                data.append(`qr_strings`, this.amount);
                data.append(`brands_id`, this.brand);
                if(this.fileBin){
                    data.append(`image`,this.fileBin);
                }
                try {
                    if(!this.brandId){
                        const res = await axios.post('/api/credits', data, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        });
                        alert("Credits Baru Berhasil dibuat");
                    }else{
                        const res = await axios.patch(`/api/credits/${this.creditId}`,{
                            amount: this.amount,
                        })
                        alert("Credit Berhasil diubah");
                    }
                    this.$emit('create_success');
                } catch(err){
                    console.log(err);
                }
            }
        },
    },

    async mounted(){
        if(!!this.creditId){
            const res = await axios.get(`/api/credits/${this.creditId}`)
            this.amount = res.data.amount;
            // this.fileUrl = res.data.image;
        }
        this.dialogLoading = false;
        this.$nextTick(()=> this.$refs.amount.focus());
    }

}
</script>
