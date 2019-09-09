<template>
    <div>
    <v-content>        
      <v-container grid-list-lg class="my-3">
          <v-layout align-center justify-space-around>
          </v-layout>
          <v-layout align-center justify-space-around row fill-height>
          <v-flex>
              <p class="headline">App Scaner</p>
                <qrcode-stream></qrcode-stream>
          </v-flex>
          </v-layout>         
          
        <v-layout align-center justify-space-around row fill-height>
            <v-flex xs12 md6 xl4>
                
            </v-flex>
        </v-layout>
      </v-container>
    </v-content>
</div>
</template>

<script>


export default {
}  
</script>