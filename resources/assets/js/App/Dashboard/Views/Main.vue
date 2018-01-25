<template>
<v-app>
  <v-navigation-drawer app fixed v-model="menuActive" :enableResizeWatcher="true">
    <v-list dense class="pt-0">
      <v-list-group v-for="item in menus" :key="item.title">
        <v-list-tile slot="item" exact :to='item.uri'>
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>{{ item.title }}</v-list-tile-title>
          </v-list-tile-content>
          <v-list-tile-action v-if="item.items">
            <v-icon>keyboard_arrow_down</v-icon>
          </v-list-tile-action>
        </v-list-tile>

        <v-list-tile v-for="subItem in item.items" :key="subItem.title" :to='subItem.uri'>
          <v-list-tile-action>
            <v-icon>{{ subItem.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title>{{ subItem.title }}</v-list-tile-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list-group>
    </v-list>
  </v-navigation-drawer>
  <v-toolbar app dark fixed>
    <v-toolbar-side-icon @click.stop="menuActive = !menuActive"></v-toolbar-side-icon>
    <v-spacer></v-spacer>
    <v-btn icon outline small fab color="white" @click.native="logout()">
      <v-icon>close</v-icon>
    </v-btn>
  </v-toolbar>

    <v-content>
      <v-container fluid>
        <router-view></router-view>
      </v-container>
    </v-content>

  <v-footer app></v-footer>
</v-app>
</template>

<script>

import menus from '../../../configs/menus.js'
import { http } from '../../../services/http'

export default {    
    data() {
      return {
        menus: menus,
        menuActive: true
      }
    },

    computed: {
      styles(){
        return {paddingLeft:"0px"}
      }
    },

    methods: {
      logout(){
        http.delete('logout')
      }
    }
}
</script>

