<!--博文编辑页面-->
<template>
    <div class="blogging">
        <div class="articleTitle">
            <div><i class="el-icon-arrow-left" style="padding-right: 5px;font-size: 2rem;"></i>文章管理</div>
            <div><input type="text" placeholder="输入文章标题"></div>
            <div>
                <span class="save">保存草稿</span>
                <span class="release">发布文章</span>
                <span class="avatar"><router-link to="/personal/index"><img :src="circleUrl"></router-link></span>
            </div>
        </div>
        <div style="height: 80vh;background-color: #428bca;">
            <mavon-editor v-model="content" ref=md @imgAdd="$imgAdd" @imgDel="$imgDel" style="height: 100%;"/>
        </div>
    </div>
</template>

<script>
    export default {
        name: "blogging",
        data(){
            return{
                img_file: {},
                content:  "",
                circleUrl:"https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg",
            }
        },
        methods:{
            // 绑定@imgAdd event
            $imgAdd(pos, $file) {
                // 第一步.将图片上传到服务器.
                var formdata = new FormData();
                formdata.append('image', $file);
                this.img_file[pos] = $file;
                // console.log(this.content);
                // this.$http({
                //     url: '/api/edit/uploadimg',
                //     method: 'post',
                //     data: formdata,
                //     headers: { 'Content-Type': 'multipart/form-data' },
                // }).then((res) => {
                //     let _res = res.data;
                //     // 第二步.将返回的url替换到文本原位置![...](0) -> ![...](url)
                //     this.$refs.md.$img2Url(pos, _res.url);
                // })
            },
            $imgDel(pos) {
                delete this.img_file[pos];
            }

        },
    }
</script>

<style lang="less">
    .blogging{padding: 1rem;
        .articleTitle{display: flex;padding: .5rem 1rem;justify-content: left;align-items: center;
            &>div:nth-child(1){flex: 1;font-size: 1.8rem;text-align: left;cursor: pointer;line-height: 3rem;}
            &>div:nth-child(2){flex: 5;
                input{display: inline-block;width: 100%;height: 3rem;padding: .5rem;font-size: 1.8rem;outline-style: none;}
            }
            &>div:nth-child(3){flex: 2;display: flex;justify-content: center ;align-items: center;
                .release,.save{display:inline-block;text-align:center;line-height:3.5rem;width: 9rem;height: 3.5rem;background-color: #CA0C16;color: #fff;border-radius: .5rem;cursor: pointer;}
                .save{margin-right: 1rem;background-color: #fff;color: #CA0C16;border: 1px solid #CA0C16;height: 3.5rem;}
                .avatar{padding-left: 2rem; img{width: 3.5rem;height: 3.5rem;border-radius: 50%;}}
            }
        }
    }
</style>