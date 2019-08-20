<template>
    <div>
     <v-app>
    <v-toolbar color="white" app>
    
      <img src="../../../../public/Logo.png" height="42" width="42" alt="" >
      <v-toolbar-title>QRku</v-toolbar-title>

      <v-spacer></v-spacer>
      <v-layout row align-center style="max-width: 250px">
        <v-text-field
          placeholder="Search"
          single-line
          append-icon="search"
          :append-icon-cb="() => {}"
          color="white"
          hide-details
        ></v-text-field>
      </v-layout>
    </v-toolbar>

    <router-view></router-view>
    
    
        
    <v-footer absolute height="auto" color="indigo">          
              
        <v-flex
        indigo
        py-3
        text-xs-center
        white--text
        xs12
        >
        &copy;2019 — <strong><a href="https://github.com/adryantheo" style="color: white">Adryan Theo</a></strong>
        </v-flex>
          
    </v-footer>

</v-app>
    
</div>
</template>

<script>


export default {

   
  
  
}  
</script>