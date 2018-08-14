
<template>
  <div>
      <div id="main_logout">
        <headerLogout></headerLogout>
        <router-view/>
        <footerLogout></footerLogout>
      </div>
  </div>
</template>

<script>
import footer_logout from "./footer_logout.vue";
import header_logout from "./header_logout.vue";
import slide_logout from "./slide_logout.vue";
export default {
  name: "appmain",
  components: {
    footerLogout: footer_logout,
    headerLogout: header_logout,
    slideLogout: slide_logout
  },
  data() {
    return {};
  }
};
</script>

<style>
</style>
