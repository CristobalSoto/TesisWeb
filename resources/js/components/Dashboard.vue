<template>
<div id="container">
   
  <Navbar></Navbar>
  <Sidebar></Sidebar>
  <div class="container-fluid">
  <router-view></router-view>
 <!-- <DashboardContent></DashboardContent> -->

  </div>
</div>
</template>

<script>

import Navbar from './Navbar.vue'
import Sidebar from './Sidebar.vue'
import DashboardContent from './DashboardContent.vue'

export default {
  components: {
    DashboardContent,
    Navbar,
    Sidebar
  }
}
</script>


