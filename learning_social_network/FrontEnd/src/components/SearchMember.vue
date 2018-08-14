<template>
<div class="side__addmember">
    <input type="text" v-model="search" placeholder="add member" @click="addemail" @input="onChange" for="search">
    <i class="fas fa-user-plus" @click="addmember"></i>
    <div v-show="itememail" class="item__email">
        <div v-for="item in filteremail" :key="item.id" @click="onEnter(item.email)" class="itemSuggest">
            {{item.email}}
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'searchmember',
    computed: {
        filteremail: function () {
            return this.items.filter((item) => {
                return item.email.match(this.search);
            });
        }
    },
    data() {
        return {
            items: [],
            members: [],
            search: '',
            itememail: false,
            out: 0,
            in: 0
        }
    },
    methods: {
        addemail: function () {
            this.itememail = true;
            this.filteremail;
        },
        onChange: function () {
            this.itememail = true;
            this.filteremail;
        },
        onEnter: function (item) {
            this.search = item;
        },
        addmember: function () {
            this.itememail = false;
            if (this.search.length == 0) {
                alert("bạn cần nhập email")
            } else {
                for (let i = 0; i < this.items.length; i++) {
                    if (this.search === this.items[i].email) {
                        this.out++;
                        for (let j = 0; j < this.members.length; j++) {
                            if (this.search !== this.members[j]) {
                                this.in=0;
                            }
                            else{
                                this.in++;
                            }
                        }
                        if(this.in==0){
                            alert("Đã thêm vào member");
                                this.$http.post("https://ccd301eb.ngrok.io/api/member", {
                                    user_id: this.items[i].id,
                                    class_id: 1
                                }).then(data => {
                                    console.log(data.body);
                                }).catch(err => console.log(err));
                                break;
                        }else{
                            alert("đã có trong list member")
                        }   
                    }
                }
                if (this.out == 0) {
                    alert("email không có trong hệ thống")
                }
            }
        },
        handleClickOutside(evt) {
            if (!this.$el.contains(evt.target)) {
                this.itememail = false;
            }
        }
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    },
    destroyed() {
        document.removeEventListener('click', this.handleClickOutside);
    },
    created() {
        this.$http.get("https://cors.io/?https://ccd301eb.ngrok.io/api/auth/list")
            .then(data => {
                this.items = data.body;
            })
            .catch(err => console.log(err));
        this.$http.get("https://cors.io/?https://ccd301eb.ngrok.io/api/member")
            .then(data => {
                for (let i = 0; i < data.body.length; i++) {
                    this.members.push(data.body[i].user_id.email);
                }
                console.log(this.members);
            })
            .catch(err => console.log(err))
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.side__addmember {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.side__addmember input {
    width: 80%;
    height: 35px;
    cursor: pointer;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
    border: 1px solid #8080804d;
    padding-left: 10px;
}

.side__addmember i {
    font-size: 31px;
    display: block;
    color: teal;
    cursor: pointer;
}

.item__email {
    width: 100%;
    height: 245px;
    position: absolute;
    top: 42px;
    background: #f0f0f0;
}

.itemSuggest {
    font-size: 13px;
}

.itemSuggest:hover {
    color: gray;
}
</style>
