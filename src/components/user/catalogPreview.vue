<template>
    <div class="catalogPreview">
        <div class="article_none" v-show="checked.length?!original.length:!alldata.length">
            <img :src="none">
            <div>空空如也</div>
            <router-link to="/md/mavon" style="text-decoration: none;"><span>写博客</span></router-link>
        </div>

        <div class="banner" v-show="checked.length?original.length:alldata.length">
            <div><el-checkbox v-model="checked">只看原创</el-checkbox></div>
            <el-tabs v-model="activeName" type="border-card" @tab-click="handleClick" style="box-shadow:none;padding:0;border:1px solid #ede9ff;display:block;text-align:center;">
                <el-tab-pane label="默认" name="first"></el-tab-pane>
                <el-tab-pane label="按更新时间" name="second"></el-tab-pane>
                <el-tab-pane label="按访问量" name="third"></el-tab-pane>
                <el-tab-pane label="RSS订阅" name="fourth"></el-tab-pane>
            </el-tabs>
        </div>
        <div class="catalog" v-for="(item,index) in checked?original:alldata" :key="index">
            <div class="title">
                <router-link :to="{path:'/index/user/details',query:{userId:userId,articleId:item.uniqueId}}" style="text-decoration: none;">
                    <span class="titleInner"> {{item.title}} </span>
                </router-link>
            </div>
            <div class="contentt">
                <router-link :to="{path:'/index/user/details',query:{userId:userId,articleId:item.uniqueId}}" style="text-decoration: none;"><span class="innerContent">
                    {{item.content}}
                </span></router-link>
            </div>
            <div class="bottomMark">
                <span class="time">{{item.time}}</span>
                <el-divider direction="vertical"></el-divider>
                <span class="readingNum" @click="sort_time(item.content)">阅读数 <span style="color: #428bca;">419</span></span>
                <el-divider direction="vertical"></el-divider>
                <span class="commentNum">评论数 <span style="color: #428bca;">4</span></span>
            </div>
        </div>
<!--        底部分页 后期再添加-->
<!--        <div class="block" style="margin-bottom: 20rem;display: flex;align-items: center;justify-content: center;padding: 1.5rem;">-->
<!--            <el-pagination-->
<!--                    :page-size="100"-->
<!--                    layout="prev, pager, next, jumper"-->
<!--                    :total="1000">-->
<!--            </el-pagination>-->
<!--        </div>-->
    </div>
</template>

<script>
    import none from "assets/none.jpg";//1.引入图片地址
    export default {
        name: "catalogPreview",
        props: ["userId","alldata",'original'],
        data(){
            return{
                none: none,//2.赋值图片地址,然后在:src中可以直接使用
                checked: false,
                show_data: '',
                activeName: 'first'
            }
        },
        methods:{
            sort_time(content){
                console.log(content);
            },
            handleClick(tab, event) {
                this.$emit('changeData',tab.index);
                console.log(tab.index, event);
            },
            updated(){
                alert('挂载完成!');
            }
        },
    }
</script>

<style lang="less">
    .catalogPreview{
        height: 100%;
        background-color: #fff;
        padding: 0 0 10rem 0;
    }
    .el-tabs--border-card>.el-tabs__content{padding:0;}
    .banner{display: flex;height: 4rem;align-items: center;border-bottom: 1px solid #000;padding: .5rem 1rem .5rem 2rem;
        div{flex: 1;display: flex;justify-content:space-between;
            span{flex: 1;cursor: default;text-align:center;cursor: pointer;
                &:hover{color: #409EFF;}
                &:nth-child(1){color: #999;cursor: auto; &:hover{color: none;}}

            }
            .selected{color: #ca0c16}
        }
    }
    .catalog{display: flex;flex-direction:column;padding: 1rem 2rem;border-bottom: 1px solid #000;transition: background-color .25s;
        &:last-child{border-bottom: none;}
        &:hover{background-color: #F4F4F4;transition: background-color .25s;}
        .title{display: flex;flex: 2;font-size: 1.8rem;color: #3d3d3d;font-weight: bold;padding-bottom: .5rem;cursor:pointer;
            .titleInner{color: #3d3d3d;&:hover{color: #B66300;}}
        }
        .contentt{flex: 3;overflow: hidden;font-size: 1.4rem;line-height: 2.2rem;text-overflow: -o-ellipsis-lastline;overflow: hidden;max-height: 7rem;
            text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 2;line-clamp: 2;-webkit-box-orient: vertical;cursor:pointer;
            .innerContent{color: #6b6b6b;}
        }
        .bottomMark{flex: 1;padding: .5rem;font-size: 1.3rem;
            .time{color: #6b6b6b;}
            .readingNum,.commentNum{color: #999;}
        }
    }

    .article_none{display: flex;width: 100%;align-items: center;justify-content: center;flex-direction: column;padding-top: 10rem;
        img{width: 35rem;height: 25rem;}
        div{font-size: 1.6rem;color: #6B6B6B;font-weight: bold;letter-spacing: .2rem;margin: 1.5rem 0;}
        span{display: block;background-color: #CA0C16;color: #fff;padding: 1rem 10rem;margin-top: 1.5rem;font-size: 1.8rem;border-radius: .5rem;cursor: pointer;}
    }
</style>