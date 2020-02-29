<template>
    <div class="sortPreview">
        <div class="sort_colum">
            <div><img :src="collection_clip_detail.picture" style="width: 10rem;height: 10rem;"></div>
            <div>
                <div class="sort_colum_name">
                    <span>{{collection_clip_detail.name}}</span>
                    <span>关注</span>
                </div>
                <div class="sort_colum_describe">
                    <span>{{collection_clip_detail.describe}}</span>
                </div>
                <div class="sort_colum_record">
                    关注数:<span>0</span>
                    文章数:<span>{{collection_clip_detail.essay.length}}</span>
                    访问量:<span>1048</span>
                </div>
            </div>
        </div>
        <div class="sort_brief">
            <div><span></span>作者介绍</div>
            <div>面朝大海,春暖花开!</div>
        </div>
        <div class="sort_preview" v-for="(item,index) in collection_clip_detail.essay" :key="index">
            <router-link target="_blank"  :to="{path:'/index/user/details',query:{userId:userId,articleId:item.uniqueId}}" style="text-decoration: none;">
                <div><span v-show="item.type=='原创'">{{item.type}}</span>{{item.title}}</div>
                <div>{{item.content}}</div>
                <div>
                    <span>{{item.time}}</span>
                    <span>阅读数 415</span>
                    <span>评论数 54</span>
                </div>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "sortPreview",
    props: ["collection_clip_detail","userId"],
    data() {
        return {

        }
    }
}
</script>

<style lang="less">
    .sortPreview{
        height: 100%;
        width: 100%;
        /*background-color: #fff;*/
    }
    .sort_colum{display: flex;width: 100%;padding: 2rem;box-sizing: border-box;background-color: #2e2f30;
        div:nth-child(1){display: inline-block;width: 11.5rem;height: 10rem;margin-right: 1.5rem;}
        div:nth-child(2) {display: flex;flex-direction: column;height: 10rem;width: 100%;
            &>div{flex:1;display: flex;align-items: center;justify-content:flex-start;}
            .sort_colum_describe{position: relative;span{position: absolute;left: 0;line-height: 3.33rem;color: #999;font-size: 1.4rem;}}
            .sort_colum_name{width: 100%;
                span:nth-child(1){font-size: 2rem;color: #c5c5c5;}
                span:nth-child(2){display: inline-block; padding: .25rem 1.2rem;border: 1px solid #de7f3e;color:#de7f3e; margin-left: 2rem;border-radius: .5rem;}
            }
            .sort_colum_record{color: #777;
                span{margin-right: 5rem;margin-left: 1rem;color: #6091b8;}
            }
        }
    }

    .sort_brief{display: flex;flex-direction: column;width: 100%;padding: 2rem;box-sizing: border-box;background-color: #262728;margin-bottom: 1rem;
        div{flex: 1;display: flex;align-items: center;justify-content: flex-start;
            &:nth-child(1){font-size: 1.8rem;color: #c5c5c5;width: 100%;
                span{display: inline-block; width: .5rem;height: 2.5rem;background-color: #de7f3e;margin-right: 1rem;}
            }
            &:nth-child(2){display: inline-block;width: 100%;color: #999;font-size: 1.4rem;margin: 1rem 0 0 0rem;width: 100%;}
        }
    }

    .sort_preview{padding: 1.5rem;background-color: #262728;color: #fff;margin-bottom: 1rem;
        div:nth-child(1){font-size: 1.8rem;color: #c5c5c5;display: flex;align-items: center;margin-bottom: 1rem;
            span{color: #de7f3e;padding: .25rem .5rem;font-size: 1.2rem;background-color: #f9ecec;border-radius: .2rem;margin-right: 1.5rem;}
        }
        div:nth-child(2){color: #999;font-size: 1.4rem;overflow : hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-line-clamp: 3;-webkit-box-orient: vertical;}
        div:nth-child(3){margin-top: 1rem;color: #777;
            span{margin-right: 2rem;}
        }
    }
</style>