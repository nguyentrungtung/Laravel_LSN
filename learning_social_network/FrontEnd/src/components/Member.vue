<template>
            <div class="list__member__block">
                <div class="list__member__item" v-for="member in memberItems" :key="member.id">
                  <div class="member_item_avatar">
                    <img :src="member.user_id.avatar">
                  </div>
                  <div class="member_item_info">
                    <div class="member_infor_intro">
                      <div>
                        <p>{{member.user_id.full_name}}</p>
                        <p>Joint date: {{member.user_id.created_at}}</p>
                      </div>
                      <p class="member_info_icon">
                        <i class="fas fa-user"></i>
                        <span v-if="member.is_captain">Captain</span>
                        <span v-else-if="member.is_mentor">Mentor</span>
                        <span v-else>Guest</span>
                        <!-- <span v-else-if="!member.is_captain && !member.is_mentor">Guest</span> -->
                      </p>
                    </div>
                    <div class="member_infor_social">
                      <p>Gmail: {{member.user_id.email}}</p>
                      <p>Skype: Kien Nguyen Trung</p>
                    </div>
                  </div>
                 
                  <!-- <div class="member_item_icon" @click="showpoup(member)">
                    <i class="fas fa-ellipsis-h"></i>
                  </div>

                  <div class="member_item_select" v-if="member.show">
                      <p>Remove</p>
                      <p>Remove mentor</p>
                      <p>Set captain</p>
                  </div> -->

                  <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                      <button class="dropdown-item" type="button">Action</button>
                      <button class="dropdown-item" type="button">Another action</button>
                      <button class="dropdown-item" type="button">Something else here</button>
                    </div>
                  </div>


                </div> 
              </div>
</template>

<script>
export default {
  name: "member",
  components: {},
  data() {
    return {
      memberItems: []
    };
  },
  methods: {
    
  },
  created() {
    this.$http
      .get(
        "https://cors.io/?https://ccd301eb.ngrok.io/api/member"
      )
      .then(data => {
        this.memberItems = data.body;
        data.body.forEach(element => {
          element.show = false;
        });
        console.log(this.memberItems);
      });
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
/* style for list member */

.list__member__block {
  margin-right: 20px;
  width: 69%;
}

.list__member__item {
  width: 100%;
  display: flex;
  justify-content: space-between;
  border: 1px solid #80808070;
  padding: 20px;
  margin-bottom: 20px;
  position: relative;
}

.list__member__item p {
  margin-bottom: 10px;
}

.member_infor_intro {
  display: flex;
}
.member_item_info {
    width: 65%;
}
.member_infor_intro i {
  font-size: 23px;
  margin-top: 10px;
  margin-left: 25px;
}

.member_item_icon {
  width: 5%;
  height: 18%;
  cursor: pointer;
  font-size: 22px;
}
.btn.dropdown-toggle {
    width:  15px;
    height:  25px;
    background: #f0f0f0;
    border:  none;
    outline:  none;
}
.member_item_select {
  position: absolute;
  left: 73%;
  top: 22%;
  background: white;
  width: 155px;
  text-align: center;
  height: 140px;
  line-height: 40px;
}
.member_item_select p:hover {
  background: gray;
  cursor: pointer;
  width: 100%;
  height: 40px;
  line-height: 40px;
}
/* end style for list member */
</style>
