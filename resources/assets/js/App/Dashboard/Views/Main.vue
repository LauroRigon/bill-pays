<template>
<v-app>
  <v-navigation-drawer app>
    <v-list dense class="pt-0">
      <v-list-tile v-for="item in menus" :key="item.title" exact :to='item.uri'>
        <v-list-tile-action>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title>{{ item.title }}</v-list-tile-title>
        </v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-navigation-drawer>
  <v-toolbar app></v-toolbar>
  <main>
    <v-content style="padding-left:100px;">
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>
  </main>
  <v-footer app></v-footer>
</v-app>
</template>

<script>

import menus from '../../../configs/menus.js'

export default {    
    data() {
      return {
        menus: menus
      }
    },

    computed: {
      styles(){
        return {paddingLeft:"0px"}
      }
    }
}
</script>

