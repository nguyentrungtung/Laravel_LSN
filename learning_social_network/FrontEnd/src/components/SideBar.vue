<template>
    <div class="side__bar">
				<searchmember></searchmember>
				<div class="side__calendar">

				</div>
				<div class="side_classinfo">
					<h3>Class's Informations</h3>
					<p><i class="fas fa-clock"></i>14-07-2020 - now</p>
					<p><i class="fas fa-star"></i>Batman</p>
					<p><i class="fas fa-users"></i>Members: 1500</p>
					<p><i class="fas fa-calendar-alt"></i>Events: Unlimit</p>
				</div>
				<div class="slide__link">
					<h3>Important Links</h3>
					<p><i class="fab fa-skype"></i>14-07-2020 - now</p>
					<p><i class="fab fa-google-plus-g"></i>Batman</p>
					<p><i class="fab fa-facebook-square"></i>Members: 1500</p>
				</div>
	</div>
</template>

<script>
import SearchMember from './SearchMember.vue'
export default {
  name: 'slideClass',
  components:{
      searchmember:SearchMember
  },
  data(){
      return{
          
      }
  }
}
</script>

<style>
.side__bar{
	width: 30%;
    position: relative;
}

.side__calendar {
    width: 100%;
    height: 225px;
    background: #1c2632;
    margin-top: 25px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
}

.side_classinfo,.slide__link {
    width:  100%;
    color: #000000b5;
    border: 1px solid #808080ad;
    padding: 15px;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
}

.side_classinfo h3,.slide__link h3 {
    font-size: 23px;
    padding-bottom: 15px;
}

.side_classinfo p, .slide__link p{line-height: 35px;font-size: 18px;}

.side_classinfo p i,.slide__link p i {
    padding-right: 20px;
}

.slide__link {
    margin-top: 20px;
}
/* end style for sidebar */

</style>
