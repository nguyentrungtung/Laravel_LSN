<template>
<!--add content-->
<div class="list_content_item">
    <div class="add_list_content">
        
        <CreateContent></CreateContent>
        <!-- /show list content/ -->
        <div v-for="item in listContents" :key="item.id" class="list__item">
            <div class="list__item__intro">
                <div class="item__status">
                    <div class="item__status__text">
                        <p v-if="!item.is_done">Learning</p>
                        <p v-else>Done</p>
                    </div>
                    <div class="item__status__icon">
                        <i class="fas fa-heart"></i>
                        <!-- <span>{{item.document_id}}</span> -->
                    </div>
                </div>
                <div class="item__content">
                    <div class="item__content__avatar">
                        <img :src="item.author.avatar">
                    </div>
                    <div class="item__content__descript">
                        <div class="item__content__name">
                            <!-- <p>{{item.author}}</p> -->
                            <p>{{item.author.full_name}}</p>
                        </div>
                        <div class="item__content__time">
                            <p>Start: {{item.start_date}}</p>
                            <p>End: {{item.end_date}}</p>
                            <p>Tags: defaultTag</p>
                            <p>Level: {{item.level}}</p>
                        </div>
                    </div>
                </div>
                <div class="item__attendance">
                    <span>Take attendance</span>
                </div>
            </div>
            <div class="list__item__content">
                <div class="item__title">
                    <span >{{item.title}}</span>
                </div>
                <div class="item__content">
                    <!-- <i class="fas fa-ellipsis-h"></i> -->
                    <p v-show="item.checkAll">{{item.content_short}}</p>
                    <p v-show="!item.checkAll" v-html="item.content" ></p>
                    <div class="viewAll">
                        <button @click="item.checkAll=!item.checkAll" v-show="item.checkAll" id="viewAll_button">View all</button>
                        <button @click="item.checkAll=!item.checkAll" v-show="!item.checkAll" id="viewLess_button">View less</button>
                    </div>
                </div>
                <div class="item__option__icon" @click="item.checkEdit=!item.checkEdit">
                    <i class="fas fa-ellipsis-h"></i>
                </div>
                <div class="item__option__text" v-if="!item.checkEdit">
                    <p @click="item.checkEdit=!item.checkEdit">Add event</p>
                     <router-link to="/show/editcontent">
                    <p @click="sendEditItem(item)">
                        Edit
                        </p>
                        </router-link>
                    <p @click="item.checkEdit=!item.checkEdit">Delete</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end add_list_content -->
</div>
</template>

<script>
import ListContent from './ListContent'
import SearchMember from './SearchMember.vue'
import CreateContent from './Create_Content.vue'
export default {
    name: 'listcontent',
    components: {
        SearchMember,
        CreateContent: CreateContent
    },
    data() {
        return {
            listContents: [],
            dropdown: false,
            page: 1,
            content: {},

        }
    },
    watch:{
        
    },
    methods: {
        sendEditItem:function(item){
            item.checkEdit=!item.checkEdit 
            this.content=item;
            
            console.log(this.content);
            this.saveContent();
        },
        show_dropdown: function () {
            this.dropdown = true
        },
        saveContent: function () {
            if (typeof Storage !== "undefined") {
                var str = JSON.stringify(this.content);
                localStorage.setItem("content", str);
            } else {
                console.log("Trình duyệt của bạn không hỗ trợ local storage");
            }
        },
    },
    created() {
        this.$http.get("https://cors.io/?http://ccd301eb.ngrok.io/api/content/list").then(data => {
            data.body.forEach(element => {
                element.checkAll = true;
                element.checkEdit = true;
                this.content = element;
                this.listContents.push(element);
            });
        })
    },
    computed:{

    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.add_list_content {
    width: 97%;
    position: relative;
    padding-bottom: 35px;
    margin-left: 0;
}

/*-- style for add_list --*/

.add_list_select {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    background: white;
    font-size: 18px;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
}

.add_content,
.add_view {
    width: 17%;
    height: 45px;
    background: white;
    border: 1px solid #80808052;
    line-height: 45px;
    text-align: center;
    cursor: pointer;
}

.add_view {
    background: #00000075;
    color: white;
    width: 83%;
    text-align: left;
}

.add_view p {
    padding-left: 25px;
}

.add_list_textarea {
    width: 100%;
    height: 50px;
}

.add_list_textarea p {
    padding: 15px;
    cursor: pointer;
}

/*-- end style for add_list --*/

/* style for content_edit */

.content_edit {
    background: white;
    margin-top: 25px;
    height: auto;
    width: 100%;
    border: 1px solid #80808029;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
}

.content_edit_block {
    padding: 20px;
}

.content_edit_input {
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding-bottom: 10px;
}

.content_edit_input input {
    width: 47%;
    height: 30px;
    padding-right: 10px;
    padding-left: 15px;
    outline: none;
}

.content_edit_input select {
    width: 47%;
    padding-left: 15px;
    outline: none;
}

.content_edit textarea {
    width: 100%;
    padding: 30px;
    outline: none;
}

.content_edit_date {
    display: flex;
    margin-top: 30px;
    width: 100%;
}

.content_edit_start {
    margin-right: 45px;
    width: 50%;
    display: flex;
    justify-content: space-between;
}

.content_edit_end {
    width: 50%;
    display: flex;
    justify-content: space-between;
}

.content_edit_start p,
.content_edit_end p {
    padding-bottom: 10px;
}

.content_edit_start input,
.content_edit_end input {
    height: 30px;
    font-size: 19px;
    width: 78%;
    outline: none;
    border: 1px solid #80808061;
    border-radius: 0px;
    text-align: center;
    padding-left: 35px;
}

#add_content_done {
    width: 72px;
    height: 35px;
    background: lightseagreen;
    color: white;
    outline: none;
    border: none;
    margin-top: 3%;
    margin-right: 3%;
    cursor: pointer;
}

/* End style for content_edit */

/* style for list-item */

.infor_menu ul a {
    width: 100%;
    text-decoration: none;
    color: #000000a6;
}

.infor_menu ul li {
    list-style: none;
    width: 100%;
    height: 50px;
    background: white;
    text-align: center;
    line-height: 50px;
    font-size: 22px;
}

/* style for list-item */

.list__item {
    width: 100%;
    height: auto;
    margin-top: 55px;
    display: flex;
    justify-content: space-between;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
}

.list__item__intro {
    background-image: url('../assets/bg.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    width: 30%;
    height: 450px;
    position: relative;
}

.item__status {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    padding-top: 31px;
}

.item__status__text {
    width: 95px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    background: white;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
    cursor: pointer;
    margin-left: 25px;
    margin-right: 45px;
}

.item__status__icon {
    font-size: 24px;
    color: white;
}

.item__status__icon i {
    color: #ff000078;
}

.item__content {
    display: flex;
    justify-content: space-around;
    padding-top: 30px;
}

.item__content__avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-left: 15px;
}

.item__content__avatar img {
    width: 100%;
    height: 100%;
}

.item__content__descript {
    width: 75%;
    color: white;
    padding-left: 13px;
    line-height: 15px;
}

.item__title span {
    font-size: 30px;
    position: relative;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    overflow: hidden;
    -webkit-box-orient: vertical;
}
.item__title span:hover{
    -webkit-line-clamp: 2;
}
.item__title {
    margin-top: 25px;
    margin-bottom: 25px;
}

.item__title:after {
    content: "";
    display: block;
    border: 0.5px solid #808080b5;
    width: 33%;
    height: 0.5px;
}

.item__content__name {
    padding-bottom: 10px;
}

.item__attendance {
    width: 170px;
    height: 50px;
    border: 1px solid white;
    text-align: center;
    line-height: 50px;
    position: absolute;
    top: 80%;
    left: 18%;
    color: white;
    cursor: pointer;
}

.list__item__content {
    width: 70%;
    height: 100%;
    position: relative;
    padding: 0 15px;
}

.item__title {
    width: 94%;
}

.item__content {
    width: 100%;
    height: 5%;
}
#viewAll_button{
    position: absolute;
    top: 127%;
    left: 87%;
    border:none;
    background: #f0f0f0;
    cursor: pointer;
}
#viewLess_button{
    position: absolute;
    top: 95%;
    left: 86%;
    border:none;
    background: #f0f0f0;
    cursor: pointer;
}
.item__option__icon {
    width: 5%;
    height: 5%;
    position: absolute;
    top: 0;
    left: 95%;
    font-size: 19px;
    cursor: pointer;
}

.item__option__text {
    width: 160px;
    height: 90px;
    background: white;
    text-align: center;
    position: absolute;
    top: 3%;
    left: 67%;
}

.item__option__text p {
    display: block;
    width: 100%;
    height: 30px;
    cursor: pointer;
    margin: 0;
}

.item__option__text p:hover {
    background: gray;
    color: white;
}

/* End style for list-item */

.regexRight {
    margin-left: -12px;
}
</style>
