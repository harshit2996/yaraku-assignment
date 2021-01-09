<template>
  <v-app>
    <v-app-bar 
      app 
      clipped-left
      flat
    >
      <v-app-bar-nav-icon @click="leftDrawer = !leftDrawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Yaraku</v-toolbar-title>
    </v-app-bar>
    <v-navigation-drawer
      v-model="leftDrawer"
      app
      clipped
    >
      <v-list 
        nav
        >
        <v-list-item
          v-for="item in items"
          :key="item.title"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
    <v-main>
      <slot/>
    </v-main>
  </v-app>
</template>

<script>
export default {

  data:()=>({
    items:[
      {
        icon:'mdi-view-dashboard',
        title:'Dashboard'
      }
    ],

    leftDrawer:false

  })

}
</script>

<style>

</style>