<template>
    <div class="catalogPreview">
        <div class="banner">
            <div><el-checkbox v-model="checked">只看原创</el-checkbox></div>
            <div class="sort">
                <span>排序:</span>
                <span class="selected">默认</span>
                <span>按更新时间</span>
                <span>按访问量</span>
                <span>RSS订阅</span>
            </div>
        </div>
        <div class="catalog" v-for="item in 20" :key="item">
            <div class="title"><router-link to="/index/user/details" style="text-decoration: none;"><span class="titleInner"> python专题文件操作 </span></router-link></div>
            <div class="contentt">
                <router-link to="/index/user/details" style="text-decoration: none;"><span class="innerContent">
                一 前言 本篇文章主要对文件操作进行说明，知识追寻者创作必属精品，读完本篇你将获得基础的文件操作能力，深入理解文件操作API，
                基础真的很重要，不管学什么知识，故看知识追寻者的专题系列真的很不错。 二 open函数介绍 2.1 open函数概览 open(file, mode=‘r’, buffering=None, encoding=None, errors=None, newline=None, closefd=True)
                </span></router-link>
            </div>
            <div class="bottomMark">
                <span class="time">2020-01-22 10:28:45</span>
                <el-divider direction="vertical"></el-divider>
                <span class="readingNum">阅读数 <span style="color: #428bca;">419</span></span>
                <el-divider direction="vertical"></el-divider>
                <span class="commentNum">评论数 <span style="color: #428bca;">4</span></span>
            </div>
        </div>
        <div class="block" style="margin-bottom: 20rem;display: flex;align-items: center;justify-content: center;padding: 1.5rem;">
            <el-pagination
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page.sync="currentPage3"
                    :page-size="100"
                    layout="prev, pager, next, jumper"
                    :total="1000">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    export default {
        name: "catalogPreview",
        data(){
            return{
                checked: false,
            }
        }
    }
</script>

<style lang="less">
    .catalogPreview{
        height: 100%;
        background-color: #fff;
    }
    .banner{display: flex;height: 4rem;align-items: center;border-bottom: 1px solid #000;padding: .5rem 2rem;
        div{flex: 1;display: flex;
            span{flex: 1;cursor: default;text-align:center;cursor: pointer;
                &:hover{color: #ca0c16;}
                &:nth-child(1){color: #999;cursor: auto; &:hover{color: none;}}

            }
            .selected{color: #ca0c16}
        }
    }
    .catalog{display: flex;flex-direction:column;padding: 1rem 2rem;border-bottom: 1px solid #000;transition: background-color .25s; &:hover{background-color: #F4F4F4;transition: background-color .25s;}
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
</style>